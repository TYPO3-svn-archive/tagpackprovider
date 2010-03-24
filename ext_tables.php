<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::allowTableOnStandardPages('tx_tagpackprovider_selections');


if (TYPO3_MODE == 'BE')	{
	include_once(t3lib_extMgm::extPath('tagpackprovider') . 'class.tx_tagpackprovider_tca.php');
}

$TCA['tx_tagpackprovider_selections'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:tagpackprovider/locallang_db.xml:tx_tagpackprovider_selections',		
		'label'     => 'name',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'res/icon_tx_tagpackprovider_selections.gif',
	),
);

	// Add context sensitive help (csh) for this table
t3lib_extMgm::addLLrefForTCAdescr('tx_tagpackprovider_selections', t3lib_extMgm::extPath($_EXTKEY) . 'locallang_csh_txtagpackproviderselections.xml');

	// Register tagpackprovider as a secondary Data Provider
t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['columns']['tx_displaycontroller_provider2']['config']['allowed'] .= ',tx_tagpackprovider_selections';

	// Add a wizard for adding a tagpackprovider
$addTagpackProviderWizard = array(
						'type' => 'script',
						'title' => 'LLL:EXT:tagpackprovider/locallang_db.xml:wizards.add_tagpackprovider',
						'script' => 'wizard_add.php',
						'icon' => 'EXT:tagpackprovider/res/add_tagpackprovider_wizard.gif',
						'params' => array(
								'table' => 'tx_tagpackprovider_selections',
								'pid' => '###CURRENT_PID###',
								'setValue' => 'append'
							)
						);
$TCA['tt_content']['columns']['tx_displaycontroller_provider2']['config']['wizards']['add_tagpackprovider'] = $addTagpackProviderWizard;
?>