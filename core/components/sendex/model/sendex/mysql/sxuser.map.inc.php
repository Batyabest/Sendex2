<?php
$xpdo_meta_map['sxUser']= array (
  'package' => 'sendex',
  'version' => '1.1',
  'table' => 'sendex_user',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'email' => '',
    'group' => '',
    'status' => 1,
  ),
  'fieldMeta' => 
  array (
    'email' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'group' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'status' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 1,
    ),
  ),
);
