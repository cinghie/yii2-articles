<?php

/**
 * @copyright Copyright &copy;2014 Giandomenico Olini
 * @company Gogodigital - Wide ICT Solutions 
 * @website http://www.gogodigital.it
 * @package yii2-articles
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 */

use yii\helpers\Html;

// Params
$options = $model->params;
$options = json_decode($options);

// Load Javascript to load Options Data
$script = "
	jQuery('div.field-categories-categoriesImageWidth select').val('".$options->categoriesImageWidth."');
	jQuery('div.field-categories-categoryImageWidth select').val('".$options->categoryImageWidth."');
	jQuery('div.field-categories-itemImageWidth select').val('".$options->itemImageWidth."');
	jQuery('div.field-categories-categoriesViewData select').val('".$options->categoriesViewData."');
	jQuery('div.field-categories-categoryViewData select').val('".$options->categoryViewData."');
	jQuery('div.field-categories-itemViewData select').val('".$options->itemViewData."');
";
$this->registerJs($script);

$this->title = Yii::t('articles.message', 'Update Category: ', [
  'modelClass' => 'Categories',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles.message', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('articles.message', 'Update');
?>
<div class="categories-update">

    <div class="page-header">
    	<h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
