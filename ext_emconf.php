<?php

########################################################################
# Extension Manager/Repository config file for ext: "tagpackprovider"
#
# Auto generated 15-06-2009 15:33
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Tag Pack Data Provider',
	'description' => 'This Data Provider relies on tags from extension Tag Pack to provide lists of items.',
	'category' => 'services',
	'author' => 'Francois Suter (Cobweb)',
	'author_email' => 'typo3@cobweb.ch',
	'shy' => '',
	'dependencies' => 'tagpack,tesseract',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.5.0',
	'constraints' => array(
		'depends' => array(
			'tagpack' => '',
			'tesseract' => '0.1.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:12:{s:9:"ChangeLog";s:4:"004f";s:10:"README.txt";s:4:"ee2d";s:65:"class.tx_tagpackprovider_tx_tagpackprovider_selections_tables.php";s:4:"35c2";s:12:"ext_icon.gif";s:4:"1bdc";s:17:"ext_localconf.php";s:4:"b0ca";s:14:"ext_tables.php";s:4:"a64d";s:14:"ext_tables.sql";s:4:"2806";s:38:"icon_tx_tagpackprovider_selections.gif";s:4:"475a";s:16:"locallang_db.xml";s:4:"1ac2";s:7:"tca.php";s:4:"2425";s:19:"doc/wizard_form.dat";s:4:"0ea6";s:20:"doc/wizard_form.html";s:4:"50dc";}',
);

?>