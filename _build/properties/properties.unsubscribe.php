<?php

$properties = array();

$tmp = array(
	/*'id' => array(
		'type' => 'numberfield',
		'value' => '',
	),*/
	'tplUnsubscribe' => array(
		'type' => 'textfield',
		'value' => 'tpl.Sendex.unsubscribe',
	)
);

foreach ($tmp as $k => $v) {
	$properties[] = array_merge(
		array(
			'name' => $k,
			'desc' => PKG_NAME_LOWER . '_prop_' . $k,
			'lexicon' => PKG_NAME_LOWER . ':properties',
		), $v
	);
}

return $properties;