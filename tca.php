<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_tagpackprovider_selections'] = array (
	'ctrl' => $TCA['tx_tagpackprovider_selections']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'name,tables,tags'
	),
	'feInterface' => $TCA['tx_tagpackprovider_selections']['feInterface'],
	'columns' => array (
		'name' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tagpackprovider/locallang_db.xml:tx_tagpackprovider_selections.name',		
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required,trim',
			)
		),
		'tables' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tagpackprovider/locallang_db.xml:tx_tagpackprovider_selections.tables',		
			'config' => array (
				'type' => 'select',
				'itemsProcFunc' => 'tx_tagpackprovider_tca->getListOfTables',
				'size' => 5,
				'maxitems' => 10,
			)
		),
		'tags' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tagpackprovider/locallang_db.xml:tx_tagpackprovider_selections.tags',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_tagpack_tags',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 1000,
			)
		),
		'tag_expressions' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:tagpackprovider/locallang_db.xml:tx_tagpackprovider_selections.tag_expressions',
			'config' => array (
				'type' => 'text',
				'cols' => 50,
				'rows' => 5,
			)
		),
		'logical_operator' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:tagpackprovider/locallang_db.xml:tx_tagpackprovider_selections.logical_operator',
			'config' => array (
				'type' => 'radio',
				'default' => 'OR',
				'items' => array (
					array('LLL:EXT:tagpackprovider/locallang_db.xml:tx_tagpackprovider_selections.logical_operator.I.0', 'AND'),
					array('LLL:EXT:tagpackprovider/locallang_db.xml:tx_tagpackprovider_selections.logical_operator.I.1', 'OR'),
				),
			)
		),
		'tags_override' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:tagpackprovider/locallang_db.xml:tx_tagpackprovider_selections.tags_override',
			'config' => array (
				'type' => 'check',
				'default' => 1
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'name;;;;1-1-1, tables;;;;2-2-2, tags;;;;3-3-3, tag_expressions;;1, logical_operator')
	),
	'palettes' => array (
		'1' => array('showitem' => 'tags_override')
	)
);
?>