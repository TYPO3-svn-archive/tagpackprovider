<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Francois Suter (Cobweb) <typo3@cobweb.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
*
* $Id$
***************************************************************/

require_once(t3lib_extMgm::extPath('basecontroller', 'services/class.tx_basecontroller_providerbase.php'));
require_once(t3lib_extMgm::extPath('basecontroller', 'services/class.tx_basecontroller_filterbase.php'));

/**
 * Base dataprovider service. All Data Provider services should inherit from this class
 *
 * @author		Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package		TYPO3
 * @subpackage	tx_tagpackprovider
 */
class tx_tagpackprovider extends tx_basecontroller_providerbase {

	/**
	 * This method returns the type of data structure that the Data Provider can prepare
	 *
	 * @return	string	type of the provided data structure
	 */
	public function getProvidedDataStructure() {
		return tx_basecontroller::$idlistStructureType;
	}

	/**
	 * This method indicates whether the Data Provider can create the type of data structure requested or not
	 *
	 * @param	string		$type: type of data structure
	 * @return	boolean		true if it can handle the requested type, false otherwise
	 */
	public function providesDataStructure($type) {
		return $type == tx_basecontroller::$idlistStructureType;
	}

	/**
	 * This method returns the type of data structure that the Data Provider can receive as input
	 *
	 * @return	string	type of used data structures
	 */
	public function getAcceptedDataStructure() {
		return '';
	}

	/**
	 * This method indicates whether the Data Provider can use as input the type of data structure requested or not
	 *
	 * @param	string		$type: type of data structure
	 * @return	boolean		true if it can use the requested type, false otherwise
	 */
	public function acceptsDataStructure($type) {
		return false;
	}

	/**
	 * This method assembles the data structure and returns it
	 *
	 * @return	array	standardised data structure
	 */
	public function getDataStructure() {
		$structure = array();
		$uidsPerTable = array();
		$tagsPerItem = array();
		$tables = t3lib_div::trimExplode(',', $this->providerData['tables']);

			// Assemble list of tags
		$manualTags = array();
			// Get manually selected tags
		if (!empty($this->providerData['tags'])) {
			$manualTags = t3lib_div::trimExplode(',', $this->providerData['tags']);
		}
			// Get tags from expressions
		$expressionTags = array();
		if (!empty($this->providerData['tag_expressions'])) {
			$expressionTags = $this->parseExpressionField($this->providerData['tag_expressions']);
		}
			// Assemble final tags array
		$tags = $manualTags;
		if (count($expressionTags) > 0) {
				// Expression tags override manual tags
			if ($this->providerData['tags_override']) {
				$tags = $expressionTags;

				// Expression tags and manual tags are merged
			} else {
				$tags = array_merge($manualTags, $expressionTags);
			}
		}
			// Make sure each tag appears only once
		$finalTags = array_unique($tags);

		$where = '';
			// Assemble where clause based on selected tags, if any
		if (count($finalTags) > 0) {
			$where = 'uid_local IN (' . implode(',', $finalTags) . ')';
		}

			// Continue only if where clause is not empty
			// (the contrary would mean selecting all records from the selected tables, which makes no sense)
		if (!empty($where)) {
				// Add condition on tables
			if (!empty($this->providerData['tables'])) {
				$condition = '';
				foreach ($tables as $aTable) {
					if (!empty($condition)) {
						$condition .= ',';
					}
					$condition .= "'" . $aTable . "'";
				}
				$where .= ' AND tablenames IN (' . $condition . ')';
			}
				// NOTE: not sure how tagpack uses/sets these fields
				// Anyway there's no TCA for table tx_tagpack_tags_relations_mm,
				// so the proper API cannot be used
			$where .= " AND hidden='0' AND deleted='0'";
				// Query the tags relations table
				// NOTE: results are sorted by table and by sorting
				// This respects the order in which tags were applied. Maybe this doesn't make sense after all. Could be reviewed at a later stage
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid_local, uid_foreign, tablenames', 'tx_tagpack_tags_relations_mm', $where, '', 'tablenames ASC, sorting ASC');

				// Loop on the results and sort them by table
			while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
				if (!isset($uidsPerTable[$row['tablenames']])) {
					$uidsPerTable[$row['tablenames']] = array();
					$tagsPerItem[$row['tablenames']] = array();
				}
				if (!isset($tagsPerItem[$row['tablenames']][$row['uid_foreign']])) {
					$tagsPerItem[$row['tablenames']][$row['uid_foreign']] = array();
				}
				$uidsPerTable[$row['tablenames']][$row['uid_foreign']] = $row['uid_foreign'];
				$tagsPerItem[$row['tablenames']][$row['uid_foreign']][] = $row['uid_local'];
			}
				// If the items should match all tags ("AND" logical operator chosen)
				// perform some post-process filtering, because such a condition
				// cannot be expressed simply in the SELECT query
			if ($this->providerData['logical_operator'] == 'AND') {
				foreach ($tagsPerItem as $table => $tableRows) {
					foreach ($tableRows as $uid_foreign => $uid_locals) {
							// Check if all chosen tags are matched by tags found per item
						$rest = array_diff($finalTags, $uid_locals);
							// At least one tag was not matched,
							// remove item from list
						if (count($rest) > 0) {
							unset($uidsPerTable[$table][$uid_foreign]);
						}
					}
				}
			}
		}

			// Assemble data structure parts
		$count = 0;
		$uniqueTable = $tables[0];
		$uidList = '';
		$uidListWithTable = '';
		if (count($uidsPerTable) > 0) {
				// Set unique table name, if indeed unique
			if (count($uidsPerTable) == 1) {
				$uniqueTable = key($uidsPerTable);
				$Uids = array_unique($uidsPerTable[$uniqueTable]);
				$uidList = implode(',', $Uids);
			} else {
				$uniqueTable = '';
				$uidList = '';
			}
				// Loop on list of uid's per table and assemble lists of id's prepended with table names
			$prependedUids = array();
			$count = 0;
			foreach ($uidsPerTable as $aTable => $list) {
				$Uids = array_unique($list);
				foreach ($Uids as $id) {
					$prependedUids[] = $aTable . '_' . $id;
					$count++;
				}
			}
			$uidListWithTable = implode(',', $prependedUids);
		}

			// Assemble final structure
		$structure['uniqueTable'] = $uniqueTable;
		$structure['uidList'] = $uidList;
		$structure['uidListWithTable'] = $uidListWithTable;
		$structure['count'] = $count;
		$structure['totalCount'] = $count;
		return $structure;
	}

	/**
	 * This method is used to pass a data structure to the Data Provider
	 *
	 * @param 	array	$structure: standardised data structure
	 * @return	void
	 */
	public function setDataStructure($structure) {
	}

	/**
	 * This method is used to pass a Data Filter structure to the Data Provider
	 *
	 * @param	array	$filter: Data Filter structure
	 * @return	void
	 */
	public function setDataFilter($filter) {
	}

	/**
     * This method returns a list of tables and fields available in the data structure,
     * complete with localized labels
     *
     * @param	string	$language: 2-letter iso code for language
     * @return	array	list of tables and fields
     */
	public function getTablesAndFields($language = '') {
		return array();
	}

	/**
	 * This method relies on the basecontroller parser to get tags from expressions
	 *
	 * @param	string	$field: field to parse for expressions
	 * @return	string	Comma-separated list of tag primary keys
	 */
	protected function parseExpressionField($field) {
		$tags = array();
			// Explode all the lines on the return character
		$allLines = t3lib_div::trimExplode("\n", $field, 1);
		foreach ($allLines as $aLine) {
				// Take only line that don't start with # or // (comments)
			if (strpos($aLine, '#') !== 0 && strpos($aLine, '//') !== 0) {
				$line = trim($aLine);
				try {
					$evaluatedExpression = tx_expressions_parser::evaluateExpression($line);
					if (!empty($evaluatedExpression)) {
						$tagList = array();
						if (strpos($evaluatedExpression, ',') === false) {
							$tagList = array($evaluatedExpression);
						} else {
							$tagList = t3lib_div::trimExplode(',', $evaluatedExpression, 1);
						}
						foreach ($tagList as $aTag) {
							$tags[] = intval($aTag);
						}
					}
				}
				catch (Exception $e) {
					// Do nothing if expression parsing failed
				}
			}
		}
		return $tags;
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tagpackprovider/class.tx_tagpackprovider.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tagpackprovider/class.tx_tagpackprovider.php']);
}
?>