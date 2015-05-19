<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 1.0
*/

use yii\helpers\Html;

// Javascript to load Options Data
$options = json_decode($model->params);
$script  = "
	jQuery('div.field-categories-categoriesImageWidth select').val('".$options->categoriesImageWidth."');
	jQuery('div.field-categories-categoryImageWidth select').val('".$options->categoryImageWidth."');
	jQuery('div.field-categories-itemImageWidth select').val('".$options->itemImageWidth."');
	jQuery('div.field-categories-categoriesViewData select').val('".$options->categoriesViewData."');
	jQuery('div.field-categories-categoryViewData select').val('".$options->categoryViewData."');
	jQuery('div.field-categories-itemViewData select').val('".$options->itemViewData."');
";
$this->registerJs($script);

// Set Title
$this->title = Yii::t('articles.message', 'Update ', [
  'modelClass' => 'Categories',
]) . ' ' . $model->name;

// Render Yii2-Articles Menu
echo Yii::$app->view->renderFile('@vendor/cinghie/yii2-articles/views/default/_menu.php');

?>
<div class="categories-update">
	
    <div class="page-header">
    	<h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
