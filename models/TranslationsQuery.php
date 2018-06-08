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

/**
 * This is the ActiveQuery class for [[Translations]].
 *
 * @see Translations
 */
class TranslationsQuery extends \yii\db\ActiveQuery
{

    /**
     * @inheritdoc
     *
     * @return Translations[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     *
     * @return Translations|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
