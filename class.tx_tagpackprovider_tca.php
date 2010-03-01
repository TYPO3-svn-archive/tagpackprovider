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
***************************************************************/

/**
 * This class provides a method for filling up the selection of tables in tx_tagpackprovider_selections tables
 *
 * @author		Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package		TYPO3
 * @subpackage	tx_tagpackprovider
 *
 * $Id$
 */
class tx_tagpackprovider_tca {

	/**
	 * This method provides a list of tables, based on various settings
	 *
	 * @param	array		$$params: properties of the field being modified
	 * @param	object		$pObj: parent object
	 * @return	void
	 */
	function getListOfTables(&$params,&$pObj) {
			// Get the extension configuration
		$configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['tagpackprovider']);
			// Get the list of allowed tables from the extension's configuration
			// If empty, get the list of allowed tables from the configuration of tagpack
		$tablesList = '';
		if (empty($configuration['taggedTables'])) {
			$tagpackConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['tagpack']);
			$tablesList = $tagpackConfiguration['taggedTables'];
		} else {
			$tablesList = $configuration['taggedTables'];
		}
			// If a list of tables is defined, use it to fill the items array
		if (!empty($tablesList)) {
			$listOfTables = t3lib_div::trimExplode(',', $tablesList, true);
			foreach ($listOfTables as $table) {
				$label = isset($GLOBALS['TCA'][$table]['ctrl']['label']) ? $GLOBALS['LANG']->sL($GLOBALS['TCA'][$table]['ctrl']['title']) : $table;
				$params['items'][] = array($label, $table);
			}
		}
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tagpackprovider/class.tx_tagpackprovider_tca.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tagpackprovider/class.tx_tagpackprovider_tca.php']);
}
?>