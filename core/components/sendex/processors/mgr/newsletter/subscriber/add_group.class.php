<?php
/**
 * Add a Subscribers from the UserGroup
 */
class sxSubscriberAddGroupProcessor extends modObjectProcessor {
	public $classKey = 'sxUser';
	public $languageTopics = array('sendex');
	public $permission = '';


	/**
	 * @return bool
	 */
	public function process() {
		if (!$group_id = $this->getProperty('group_id')) {
			return $this->failure($this->modx->lexicon('sendex_subscriber_err_group'));
		}
		elseif (!$newsletter_id = $this->getProperty('newsletter_id')) {
			return $this->failure($this->modx->lexicon('sendex_newsletter_err_ns'));
		}
		$errors = array();

		$c = $this->modx->newQuery($this->classKey);
		$c->select($this->modx->getSelectColumns($this->classKey, $this->classKey, '', array('id', 'email')));
		$c->innerJoin('sxUserGroup', 'sxUserGroup', '`sxUserGroup`.`id` = `sxUser`.`usergroup_id` AND `sxUserGroup`.`id` = ' . $group_id);
		$c->leftJoin('sxSubscriber', 'Subscriber', '`Subscriber`.`user_id` = `sxUser`.`id` AND `Subscriber`.`newsletter_id` = ' . $newsletter_id);
		$c->select($this->modx->getSelectColumns('sxUserGroup', 'sxUserGroup', '',array('name')));
		$c->where(array(
			'Subscriber.user_id' => null
		));

		//$c->prepare();
		//$this->modx->log(1 , print_r($c->toSQL() ,1));

		if ($c->prepare() && $c->stmt->execute()) {
			while ($row = $c->stmt->fetch(PDO::FETCH_ASSOC)) {
				/** @var modProcessorResponse $response */
				$this->modx->error->reset();
				$response = $this->modx->runProcessor(
					'mgr/newsletter/subscriber/create',
					array(
						'newsletter_id' => $newsletter_id,
						'user_id' => $row['id'],
						'email' => $row['email']
					),
					array(
						'processors_path' => MODX_CORE_PATH . 'components/sendex/processors/'
					)
				);
				if ($response->isError()) {
					$errors[] = $row['username'] . ': ' . $response->getMessage();
				}
			}
		}

		return !empty($errors)
			? $this->failure(implode('<br/>', $errors))
			: $this->success();
	}

}

return 'sxSubscriberAddGroupProcessor';