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

	public function prepareQueryBeforeCount(xPDOQuery $c)
	{
		$c->innerJoin('sxUserGroup', 'sxUserGroup', 'sxUserGroup.id = sxUser.usergroup_id');
		$c->select($this->modx->getSelectColumns('sxUser', 'sxUser'));
		$c->select('sxUserGroup.name as group_name');

		$c->prepare();
		$this->modx->log(1 , print_r('=========' ,1));
		$this->modx->log(1 , print_r($c->toSQL() ,1));

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

		$required = array('email', 'usergroup_id');
		foreach ($required as $tmp) {
			if (!$this->getProperty($tmp)) {
				$this->addFieldError($tmp, $this->modx->lexicon('field_required'));
			}
		}

		if ($this->hasErrors()) {
			return false;
		}

		$unique = array('email');
		foreach ($unique as $tmp) {
			if ($this->modx->getCount($this->classKey, array('email' => $this->getProperty($tmp)))) {
				$this->addFieldError($tmp, $this->modx->lexicon('sendex_newsletter_err_ae'));
			}
		}

		return !$this->hasErrors();
	}

}

return 'sxUserCreateProcessor';