<?php
/**
 * Get a list of Queues
 */
class sxUnsubscribeQuestionGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'sxUnsubscribeQuestion';
	public $classKey = 'sxUnsubscribeQuestion';
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'DESC';


	/**
	 * @param xPDOQuery $c
	 *
	 * @return xPDOQuery
	 */
	public function prepareQueryBeforeCount(xPDOQuery $c) {

		if ($query = $this->getProperty('query')) {
			$c->where(array(
				'question:LIKE' => "%$query%",
				'OR:description:LIKE' => "%$query%"
			));
		}
		
		return $c;
	}


	/**
	 * @param xPDOObject $object
	 *
	 * @return array
	 */
	public function prepareRow(xPDOObject $object) {
		$array = $object->toArray();
		$array['actions'] = array();

		// Send
		$array['actions'][] = array(
			'class' => '',
			'button' => true,
			'menu' => true,
			'icon' => 'send',
			'type' => 'sendQueue',
		);

		// Remove
		$array['actions'][] = array(
			'class' => '',
			'button' => true,
			'menu' => true,
			'icon' => 'trash-o',
			'type' => 'removeQueue',
		);

		return $array;
	}

}

return 'sxUnsubscribeQuestionGetListProcessor';