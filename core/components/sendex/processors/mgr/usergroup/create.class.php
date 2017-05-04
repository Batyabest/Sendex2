<?php
/**
 * Create an User
 */
class sxUserGroupCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'sxUserGroup';
	public $classKey = 'sxUserGroup';
	public $languageTopics = array('sendex');
	public $permission = 'new_document';


	/**
	 * @return bool
	 */
	public function beforeSet() {

		$required = array('name', 'description');
		foreach ($required as $tmp) {
			if (!$this->getProperty($tmp)) {
				$this->addFieldError($tmp, $this->modx->lexicon('field_required'));
			}
		}

		if ($this->hasErrors()) {
			return false;
		}

		$unique = array('name');
		foreach ($unique as $tmp) {
			if ($this->modx->getCount($this->classKey, array('name' => $this->getProperty($tmp)))) {
				$this->addFieldError($tmp, $this->modx->lexicon('sendex_newsletter_err_ae'));
			}
		}

		return !$this->hasErrors();
	}

}

return 'sxUserGroupCreateProcessor';