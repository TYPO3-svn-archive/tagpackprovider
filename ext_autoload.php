<?php
/* 
 * Register necessary class names with autoloader
 *
 * $Id$
 */
$extensionPath = t3lib_extMgm::extPath('tagpackprovider');
return array(
	'tx_tagpackprovider'		=> $extensionPath . 'class.tagpackprovider.php',
	'tx_tagpackprovider_tca'	=> $extensionPath . 'class.tx_tagpackprovider_tca.php',
);
?>
