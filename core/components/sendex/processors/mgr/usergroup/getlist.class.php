<?php
/**
 * Get a list of Queues
 */
class sxUserGroupGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'sxUserGroup';
	public $classKey = 'sxUserGroup';
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
				'name:LIKE' => "%$query%",
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

return 'sxUserGroupGetListProcessor';