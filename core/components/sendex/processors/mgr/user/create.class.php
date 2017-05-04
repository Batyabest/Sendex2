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
	public function beforeSet() {

		$required = array('email', 'group');
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