<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-articles
 * @version 0.6.5
 */

namespace cinghie\articles\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Items]].
 *
 * @see Items
 */
class ItemsQuery extends ActiveQuery
{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			NestedSetsQueryBehavior::class,
		];
	}

    /**
     * @inheritdoc
     *
     * @param int $limit
     * @param string $orderby
     * @param string $order
     *
     * @return ItemsQuery
     */
    public function last($limit, $orderby = 'id', $order = 'DESC' )
    {
        return $this->orderBy([$orderby => $order])->limit($limit);
    }

    /**
     * @inheritdoc
     *
     * @return Items[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     *
     * @return Items
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
