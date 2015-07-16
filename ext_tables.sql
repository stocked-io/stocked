CREATE TABLE `tx_stocked_domain_model_product` (
	`uid` int(11) unsigned NOT NULL auto_increment,
	`pid` int(11) unsigned NOT NULL DEFAULT '0',
	`tstamp` int(11) unsigned NOT NULL DEFAULT '0',

	`company` int(11) unsigned NOT NULL DEFAULT '0',
	`default_delivery_time` int(11) unsigned NOT NULL DEFAULT '0',
	`title` varchar(255) NOT NULL DEFAULT '',
	`user` int(11) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tx_stocked_domain_model_stock` (
	`uid` int(11) unsigned NOT NULL auto_increment,
	`pid` int(11) unsigned NOT NULL DEFAULT '0',
	`tstamp` int(11) unsigned NOT NULL DEFAULT '0',

	`amount` int(11) unsigned NOT NULL DEFAULT '0',
	`company` int(11) unsigned NOT NULL DEFAULT '0',
	`count_date` int(11) unsigned NOT NULL DEFAULT '0',
	`product` int(11) unsigned NOT NULL DEFAULT '0',
	`user` int(11) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tx_stocked_domain_model_transaction` (
	`uid` int(11) unsigned NOT NULL auto_increment,
	`pid` int(11) unsigned NOT NULL DEFAULT '0',
	`tstamp` int(11) unsigned NOT NULL DEFAULT '0',

	`amount` int(11) unsigned NOT NULL DEFAULT '0',
	`company` int(11) unsigned NOT NULL DEFAULT '0',
	`completion_date` int(11) unsigned NOT NULL DEFAULT '0',
	`price` float(11,2) unsigned NOT NULL DEFAULT '0.00',
	`product` int(11) unsigned NOT NULL DEFAULT '0',
	`order_date` int(11) unsigned NOT NULL DEFAULT '0',
	`trade_partner` varchar(255) NOT NULL DEFAULT '',
	`type` varchar(255) NOT NULL DEFAULT '',
	`user` int(11) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

