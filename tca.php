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
	),
	'types' => array (
		'0' => array('showitem' => 'name;;;;1-1-1, tables;;;;2-2-2, tags, tag_expressions')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>