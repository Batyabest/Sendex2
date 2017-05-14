<?php

if ($object->xpdo) {
	/* @var modX $modx */
	$modx =& $object->xpdo;

	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
			$modelPath = $modx->getOption('sendex_core_path',null,$modx->getOption('core_path').'components/sendex/').'model/';
			$modx->addPackage('sendex', $modelPath);

			$manager = $modx->getManager();
			$objects = array(
				'sxNewsletter',
				'sxSubscriber',
				'sxQueue',
				'sxUser',
				'sxUserGroup',
			);
			foreach ($objects as $tmp) {
				$manager->createObjectContainer($tmp);
			}


			/*$level = $modx->getLogLevel();
			$modx->setLogLevel(xPDO::LOG_LEVEL_FATAL);

			$manager->addField('sxUser', 'usergroup_id');

			$modx->setLogLevel($level);*/

			break;

		case xPDOTransport::ACTION_UPGRADE:
			break;

		case xPDOTransport::ACTION_UNINSTALL:
			break;
	}
}
return true;