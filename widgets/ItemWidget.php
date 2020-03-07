<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-articles
 * @version 0.6.6
 */

namespace cinghie\articles\widgets;

use cinghie\articles\models\Items;
use kartik\helpers\Html;
use yii\bootstrap\Widget;
use yii\helpers\HtmlPurifier;

/**
 * Class ItemWidget
 */
class ItemWidget extends Widget
{
	/** @var integer */
    public $id;

	/** @var string */
    public $classes;

	/** @var string */
    public $orderby;

	/**
	 * Widget init
	 */
    public function init()
    {
        if(!$this->id) {
            $this->id = 1;
        }

        if(!$this->orderby) {
            $this->orderby = 'id';
        }

	    parent::init();
    }

	/**
	 * @return string
	 */
    public function run()
    {
        /** @var Items $item */
        $item = Items::find()->where(['id' => $this->id])->one();

        /** @var string $html */
        $html = '<div class="articleWidget articleWidget-'.$this->id.' '.$this->classes.'">';
        $html .= '<h3><a href="'.$item->getItemUrl().'" title="'.Html::encode($item->title).'">'.Html::encode($item->title).'</a></h3>';
        $html .= '<div class="widgetText">'.HtmlPurifier::process($item->introtext).'</div>';
        $html .= '</div>';

        return $html;
    }
}
