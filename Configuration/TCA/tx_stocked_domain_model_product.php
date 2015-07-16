<?php

$extkey = 'stocked';
$table = 'tx_stocked_domain_model_product';
$lllPath = 'LLL:EXT:' . $extkey. '/Resources/Private/Language/locallang_tca.xlf:' . $table;

return [
	'ctrl' => [
		'title' => $lllPath,
		'label' => 'title',
		'tstamp' => 'tstamp',
	],
	'columns' => [
		'company' => [
			'label' => $lllPath . '.company',
			'config' => [
				'enableMultiSelectFilterTextfield' => TRUE,
				'foreign_table' => 'fe_groups',
				'foreign_table_where' => 'ORDER BY fe_groups.title',
				'minitems' => '1',
				'maxitems' => '1',
				'size' => '1',
				'type' => 'select',
			],
		],
		'default_delivery_time' => [
			'label' => $lllPath . '.default_delivery_time',
			'config' => [
				'type' => 'input',
			],
		],
		'title' => [
			'label' => $lllPath . '.title',
			'config' => [
				'type' => 'input',
				'size' => '30',
				'max' => '255',
				'eval' => 'required',
			],
		],
	],
	'types' => [
		'1' => [
			'showitem' => 'company, title',
		],
	],
];
