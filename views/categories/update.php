<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.2
*/

use yii\helpers\Html;

// Javascript to load Options Data
$options = json_decode($model->params);
$script  = "
	jQuery('div.field-categories-categoriesImageWidth select').val('".$options->categoriesImageWidth."');
	jQuery('div.field-categories-categoriesViewCreatedData select').val('".$options->categoriesViewCreatedData."');
	jQuery('div.field-categories-categoriesViewModifiedData select').val('".$options->categoriesViewModifiedData."');
	jQuery('div.field-categories-categoriesViewDebug select').val('".$options->categoriesViewDebug."');
	jQuery('div.field-categories-categoryImageWidth select').val('".$options->categoryImageWidth."');
	jQuery('div.field-categories-categoryViewCreatedData select').val('".$options->categoryViewCreatedData."');
	jQuery('div.field-categories-categoryViewModifiedData select').val('".$options->categoryViewModifiedData."');
	jQuery('div.field-categories-categoryViewDebug select').val('".$options->categoryViewDebug."');
	jQuery('div.field-categories-itemImageWidth select').val('".$options->itemImageWidth."');
	jQuery('div.field-categories-itemViewShowIntroText select').val('".$options->itemViewShowIntroText."');
	jQuery('div.field-categories-itemViewCreatedData select').val('".$options->itemViewCreatedData."');
	jQuery('div.field-categories-itemViewModifiedData select').val('".$options->itemViewModifiedData."');
	jQuery('div.field-categories-itemViewDebug select').val('".$options->itemViewDebug."');
";
$this->registerJs($script);

// Set Title and Breadcrumbs
$this->title = Yii::t('articles', 'Update') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Render Yii2-Articles Menu
echo Yii::$app->view->renderFile('@vendor/cinghie/yii2-articles/views/default/_menu.php');

?>
<div class="categories-update">

	<?php if(Yii::$app->getModule('articles')->showTitles): ?>
		<div class="page-header">
			<h1><?= Html::encode($this->title) ?></h1>
		</div>
	<?php endif ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
