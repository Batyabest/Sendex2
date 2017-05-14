<?php
$xpdo_meta_map['sxUser']= array (
  'package' => 'sendex',
  'version' => '1.1',
  'table' => 'sendex_user',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'usergroup_id' => 0,
    'email' => '',
    'status' => 1,
  ),
  'fieldMeta' => 
  array (
    'usergroup_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
    ),
    'email' => 
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
