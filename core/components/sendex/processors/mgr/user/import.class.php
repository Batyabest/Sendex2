<?php
/**
 * Create an User
 */
class sxUserCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'sxUser';
	public $classKey = 'sxUser';
	public $languageTopics = array('sendex');
	public $permission = 'new_document';


	/**
	 * @return bool
	 */

	/*public function process() {

		print_r($this->getProperties());
		die();
	}*/

	public function prepareQueryBeforeCount(xPDOQuery $c)
	{

		$c->innerJoin('sxUserGroup', 'sxUserGroup', 'sxUserGroup.id = sxUser.usergroup_id');
		$c->select($this->modx->getSelectColumns('sxUser', 'sxUser'));
		$c->select('sxUserGroup.name as group_name');

		if ($usergroup_id = $this->getProperty('usergroup_id')) {
			if (!empty($usergroup_id)) {
				$c->where(array('sxUserGroup.usergroup_id' => $usergroup_id));
			}
		}

		/*$query = trim($this->getProperty('query'));
		if ($query) {
			$c->where(array(
				'category_fabrics:LIKE' => "%{$query}%",
			));
		}*/

		return $c;
	}

	public function beforeSet() {


		$path = $this->modx->getOption('base_path');
	//	$import_source = $this->getProperty('import_source');
		$file_dir = $path . $this->getProperty('import_source'); // Путь к файлу

	//	print_r($file_dir);
	//	print_r('=======');

		//die();

		$file = file_get_contents($file_dir);
		$lines = explode(PHP_EOL, $file);
		//$array = array();
		foreach ($lines as $key => $value) {
			//print_r($key = $value);
			$this->setProperty('email', $value);
			return true;
		}

		/*$required = array('import_source', 'usergroup_id');
		foreach ($required as $tmp) {
			if (!$this->getProperty($tmp)) {
				$this->addFieldError($tmp, $this->modx->lexicon('field_required'));
			}
		}

		if ($this->hasErrors()) {
			return false;
		}*/

		return !$this->hasErrors();
	}

}

return 'sxUserCreateProcessor';