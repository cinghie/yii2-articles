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
$script = "
	jQuery('div.field-categories-categoriesImageWidth select').val('".$options->categoriesImageWidth."');
	jQuery('div.field-categories-categoryImageWidth select').val('".$options->categoryImageWidth."');
	jQuery('div.field-categories-itemImageWidth select').val('".$options->itemImageWidth."');
	jQuery('div.field-categories-categoriesViewData select').val('".$options->categoriesViewData."');
	jQuery('div.field-categories-categoryViewData select').val('".$options->categoryViewData."');
	jQuery('div.field-categories-itemViewData select').val('".$options->itemViewData."');
";
$this->registerJs($script);

// Set Title
$this->title = Yii::t('articles.message', 'Update Category: ', [
  'modelClass' => 'Categories',
]) . ' ' . $model->name;

// Set Breadcrumbs
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles.message', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('articles.message', 'Update');
?>
<div class="categories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
