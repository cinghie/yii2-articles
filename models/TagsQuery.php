<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-articles
 * @version 0.6.4
 */

namespace cinghie\articles\models;

/**
 * This is the ActiveQuery class for [[Tags]].
 * @see Tags
 */
class TagsQuery extends \yii\db\ActiveQuery
{

    public function active()
    {
        return $this->andWhere('[[state]]=1');
    }

    /**
     * @inheritdoc
     * @return Tags[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Tags|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
