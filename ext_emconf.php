<?php

########################################################################
# Extension Manager/Repository config file for ext "tagpackprovider".
#
# Auto generated 10-07-2012 10:43
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Tag Pack-based Data Provider - Tesseract project',
	'description' => 'This Data Provider relies on tags from extension Tag Pack to provide lists of items. More info on http://www.typo3-tesseract.com/',
	'category' => 'services',
	'author' => 'Francois Suter (Cobweb)',
	'author_email' => 'typo3@cobweb.ch',
	'shy' => '',
	'dependencies' => 'tagpack,tesseract,expressions',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '1.2.0',
	'constraints' => array(
		'depends' => array(
			'tagpack' => '',
			'typo3' => '4.5.0-4.7.99',
			'tesseract' => '1.0.0-0.0.0',
			'expressions' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:17:{s:9:"ChangeLog";s:4:"d623";s:28:"class.tx_tagpackprovider.php";s:4:"c151";s:32:"class.tx_tagpackprovider_tca.php";s:4:"ec88";s:16:"ext_autoload.php";s:4:"d40e";s:21:"ext_conf_template.txt";s:4:"6374";s:12:"ext_icon.gif";s:4:"f4d1";s:17:"ext_localconf.php";s:4:"4cba";s:14:"ext_tables.php";s:4:"e9a1";s:14:"ext_tables.sql";s:4:"5796";s:45:"locallang_csh_txtagpackproviderselections.xml";s:4:"e45c";s:16:"locallang_db.xml";s:4:"7a77";s:10:"README.txt";s:4:"a890";s:7:"tca.php";s:4:"4ded";s:14:"doc/manual.pdf";s:4:"6f68";s:14:"doc/manual.sxw";s:4:"5451";s:34:"res/add_tagpackprovider_wizard.gif";s:4:"032f";s:42:"res/icon_tx_tagpackprovider_selections.gif";s:4:"f4d1";}',
	'suggests' => array(
	),
);

?>