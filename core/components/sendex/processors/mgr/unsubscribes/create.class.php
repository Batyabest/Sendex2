<?php
/**
 * Create an User
 */
class sxUnsubscribeQuestionCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'sxUnsubscribeQuestion';
	public $classKey = 'sxUnsubscribeQuestion';
	public $languageTopics = array('sendex');
	public $permission = 'new_document';


	/**
	 * @return bool
	 */
	public function beforeSet() {

		$required = array('question');
		foreach ($required as $tmp) {
			if (!$this->getProperty($tmp)) {
				$this->addFieldError($tmp, $this->modx->lexicon('field_required'));
			}
		}

		if ($this->hasErrors()) {
			return false;
		}

		$unique = array('question');
		foreach ($unique as $tmp) {
			if ($this->modx->getCount($this->classKey, array('question' => $this->getProperty($tmp)))) {
				$this->addFieldError($tmp, $this->modx->lexicon('sendex_newsletter_err_ae'));
			}
		}

		return !$this->hasErrors();
	}

}

return 'sxUnsubscribeQuestionCreateProcessor';