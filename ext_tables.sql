#
# Table structure for table 'tx_tagpackprovider_selections'
#
CREATE TABLE tx_tagpackprovider_selections (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	tables varchar(40) DEFAULT '' NOT NULL,
	tags text,
	tag_expressions text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);