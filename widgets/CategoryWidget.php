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

namespace cinghie\articles\widgets;

use cinghie\articles\models\Categories;
use yii\bootstrap\Widget;

class CategoryWidget extends Widget
{

    public $id;
    public $classes;

    public function init()
    {
        parent::init();

        if(!$this->id) {
            $this->id = 1;
        }
    }

	/**
	 * @return string|void
	 *
	 * @throws \Exception
	 */
	public function run()
    {
    	$categories = new Categories();
        $items = $categories->getItemsByCategory($this->id);

        echo '<div class="row">';

        foreach($items as $item)
        {
            echo ItemWidget::widget([
                'id' => $item['id'],
                'classes' => $this->classes,
                'orderby' => 'title'
            ]);
        }

        echo '</div>';
    }

}
