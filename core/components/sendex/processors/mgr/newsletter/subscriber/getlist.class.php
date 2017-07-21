<?php
/**
 * Get a list of Subscribers
 */
class sxSubscriberGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'sxSubscriber';
	public $classKey = 'sxSubscriber';
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'DESC';


	/**
	 * @param xPDOQuery $c
	 *
	 * @return xPDOQuery
	 */
	/*public function prepareQueryBeforeCount(xPDOQuery $c) {
		$c->where(array('newsletter_id' => $this->getProperty('newsletter_id')));
		$c->leftJoin('modUser', 'modUser', 'sxSubscriber.user_id = modUser.id');
		$c->leftJoin('modUserProfile', 'modUserProfile', 'sxSubscriber.user_id = modUserProfile.internalKey');

		$c->select($this->modx->getSelectColumns($this->classKey, $this->classKey));
		$c->select('modUser.username, modUserProfile.fullname');

		return $c;
	}*/

	public function prepareQueryBeforeCount(xPDOQuery $c) {
		$c->where(array('newsletter_id' => $this->getProperty('newsletter_id')));
		$c->leftJoin('sxUser', 'sxUser', 'sxSubscriber.user_id = sxUser.id');

		$c->select($this->modx->getSelectColumns($this->classKey, $this->classKey));
		$c->where(array('sxUser.status' => 1 )); // Данное условие позволяет выбрать в окне подписки только тех пользователей, которых статус 1. А мне нужно даже не дать их добавить...
		$c->select('sxUser.email');
		// Проверяем корректность сформированного запроса

		$c->prepare();
		$this->modx->log(1 , print_r('=========' ,1));
		$this->modx->log(1 , print_r($c->toSQL() ,1));
		return $c;


	}


	/** {@inheritDoc} */
	public function prepareRow(xPDOObject $object) {
		$array = $object->toArray();

		if (empty($array['username'])) {
			$array['username'] = 'Guest';
		}
		if (empty($array['fullname'])) {
			$array['fullname'] = 'Anonymous';
		}

		$array['actions'] = array();
		// Remove
		$array['actions'][] = array(
			'class' => '',
			'button' => true,
			'menu' => true,
			'icon' => 'trash-o',
			'type' => 'removeSubscriber',
		);

		return $array;
	}


}

return 'sxSubscriberGetListProcessor';