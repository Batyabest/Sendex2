<?php
/**
 * Get a list of Queues
 */
class sxUserGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'sxUser';
	public $classKey = 'sxUser';
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'DESC';


	/**
	 * @param xPDOQuery $c
	 *
	 * @return xPDOQuery
	 */

	public function prepareQueryBeforeCount(xPDOQuery $c)
	{

		// Выбираем только нужные записи
		//$c->where(array('usergroup_id' => $this->getProperty('usergroup_id')));
		// И присоединяем свойства пользователей
		$c->leftJoin('sxUserGroup', 'sxUserGroup', 'sxUser.usergroup_id = sxUserGroup.id');

		// Выбираем поля подписчика
		$c->select($this->modx->getSelectColumns($this->classKey, $this->classKey));
		// И добавляем псевдоним и имя
		$c->select('sxUserGroup.name');

		// Проверяем корректность сформированного запроса

		//$c->prepare();
		//$this->modx->log(1 , print_r('=========' ,1));
		//$this->modx->log(1 , print_r($c->toSQL() ,1));

		/*if ($query = $this->getProperty('query')) {
			$c->where(array(
				'email:LIKE' => "%$query%",
				'OR:group:LIKE' => "%$query%"
			));
		}*/

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

return 'sxUserGetListProcessor';