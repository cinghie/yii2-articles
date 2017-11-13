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

namespace cinghie\articles\widgets;

use cinghie\articles\models\Items;
use kartik\helpers\Html;
use yii\bootstrap\Widget;
use yii\helpers\HtmlPurifier;
use yii\rbac\Item;

class ItemWidget extends Widget
{

    public $id;
    public $classes;
    public $orderby;

    public function init()
    {
        parent::init();

        /*
         * Set id to 1, if not set in widget
         */
        if(!$this->id) {
            $this->id = 1;
        }

        /*
         * Set orderby to id, if not set in widget
         */
        if(!$this->orderby) {
            $this->orderby = 'id';
        }
    }

    public function run()
    {
        /** @var Items $item */
        $item = Items::find()->where(['id' => $this->id])->one();

        return '<div class="articleWidget articleWidget-'.$this->id.' '.$this->classes.'">
                <h3><a href="'.$item->getItemUrl().'" title="'.Html::encode($item->title).'">'.Html::encode($item->title).'</a></h3>
                <div class="widgetText">'.HtmlPurifier::process($item->introtext).'</div>
            </div>';
    }
}
