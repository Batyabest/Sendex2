<?php
$Sendex = $modx->getService('sendex','Sendex',$modx->getOption('sendex_core_path',null,$modx->getOption('core_path').'components/sendex/').'model/sendex/',$scriptProperties);
if (!($Sendex instanceof Sendex)) return '';
if (isset($_POST["id"]) && isset($_POST["email"]) ) {

		if ($user = $this->xpdo->getObject('sxUser', array('id' => $_POST["id"]))) {
				$user->set('status', 0);
				$user->save();
		}

		// Формируем массив для JSON ответа
		$result = array(
			'id' => $_POST["id"],
			'email' => $_POST["email"]
		);

		// Переводим массив в JSON
		print "Ваш email: $result[email] успешно отписан от рассылки";
}