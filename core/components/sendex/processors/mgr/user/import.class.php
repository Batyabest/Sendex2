<?php
/**
 * Create an User
 */
class sxUserImportProcessor extends modObjectCreateProcessor {
	public $objectType = 'sxUser';
	public $classKey = 'sxUser';
	public $languageTopics = array('sendex');
	public $permission = 'new_document';


	/**
	 * @return bool
	 */

	public function process() {

$path = $this->modx->getOption('base_path');
		$file_dir = $path . $this->getProperty('import_source'); // Путь к файлу

		$file = file_get_contents($file_dir);
		$lines = explode(PHP_EOL, $file);
		//$array = array();
		foreach ($lines as $value) {
			$this->setProperty('email', $value);

			// Массив, который мы передадим в процессор, там его ловить в $scriptProperties
			$processorProps = array(
				'email' => $value,
				'usergroup_id' => $this->getProperty('usergroup_id')
			);
			// Массив опций для метода runProcessor
			$otherProps = array(
				// Здесь указываем где лежат наши процессоры
				'processors_path' => $this->modx->getOption('base_path') . 'core/components/sendex/processors/'
			);
			// Запускаем
			$response = $this->modx->runProcessor('mgr/user/create', $processorProps, $otherProps);
			//print_r($response->response);
		}


	}



}

return 'sxUserImportProcessor';