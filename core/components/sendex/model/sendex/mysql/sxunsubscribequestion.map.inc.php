<?php
$xpdo_meta_map['sxUnsubscribeQuestion']= array (
  'package' => 'sendex',
  'version' => '1.1',
  'table' => 'sendex_unsubscribe_question',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'question' => '',
    'description' => '',
  ),
  'fieldMeta' => 
  array (
    'question' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'description' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
  ),
);
