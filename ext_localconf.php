<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_tagpackprovider_selections=1
');

// Register as Data Provider service
// Note that the subtype corresponds to the name of the database table

t3lib_extMgm::addService($_EXTKEY,  'dataprovider' /* sv type */,  'tx_tagpackprovider_selections' /* sv key */,
		array(

			'title' => 'Tag Pack Provider',
			'description' => 'Secondary data provider based on Tag Pack tags',

			'subtype' => 'tx_tagpackprovider_selections',

			'available' => TRUE,
			'priority' => 50,
			'quality' => 50,

			'os' => '',
			'exec' => '',

			'classFile' => t3lib_extMgm::extPath($_EXTKEY, 'class.tx_tagpackprovider.php'),
			'className' => 'tx_tagpackprovider',
		)
	);
?>