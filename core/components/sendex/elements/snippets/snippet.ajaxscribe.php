<?php
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
		print_r(json_encode($result));
}