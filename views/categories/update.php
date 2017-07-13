<?php

/**
 * @var $model cinghie\articles\models\Categories
 */

use kartik\helpers\Html;

// Javascript to load Options Data
$options = json_decode($model->params);
$script  = "
	jQuery('div.field-categories-categoriesImageWidth select').val('".$options->categoriesImageWidth."');
	jQuery('div.field-categories-categoriesIntroText select').val('".$options->categoriesIntroText."');
	jQuery('div.field-categories-categoriesFullText select').val('".$options->categoriesFullText."');
	jQuery('div.field-categories-categoriesCreatedData select').val('".$options->categoriesCreatedData."');
	jQuery('div.field-categories-categoriesModifiedData select').val('".$options->categoriesModifiedData."');
	jQuery('div.field-categories-categoriesUser select').val('".$options->categoriesUser."');
	jQuery('div.field-categories-categoriesHits select').val('".$options->categoriesHits."');
	jQuery('div.field-categories-categoriesDebug select').val('".$options->categoriesDebug."');
	jQuery('div.field-categories-categoryImageWidth select').val('".$options->categoryImageWidth."');
	jQuery('div.field-categories-categoryIntroText select').val('".$options->categoryIntroText."');
	jQuery('div.field-categories-categoryFullText select').val('".$options->categoryFullText."');
	jQuery('div.field-categories-categoryCreatedData select').val('".$options->categoryCreatedData."');
	jQuery('div.field-categories-categoryModifiedData select').val('".$options->categoryModifiedData."');
	jQuery('div.field-categories-categoryUser select').val('".$options->categoryUser."');
	jQuery('div.field-categories-categoryHits select').val('".$options->categoryHits."');
	jQuery('div.field-categories-categoryDebug select').val('".$options->categoryDebug."');
	jQuery('div.field-categories-itemImageWidth select').val('".$options->itemImageWidth."');
	jQuery('div.field-categories-itemIntroText select').val('".$options->itemIntroText."');
	jQuery('div.field-categories-itemFullText select').val('".$options->itemFullText."');
	jQuery('div.field-categories-itemCreatedData select').val('".$options->itemCreatedData."');
	jQuery('div.field-categories-itemModifiedData select').val('".$options->itemModifiedData."');
	jQuery('div.field-categories-itemUser select').val('".$options->itemUser."');
	jQuery('div.field-categories-itemHits select').val('".$options->itemHits."');
	jQuery('div.field-categories-itemDebug select').val('".$options->itemDebug."');
";
$this->registerJs($script);

// Set Title and Breadcrumbs
$this->title = Yii::t('articles', 'Update Categories') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Articles'), 'url' => ['/articles/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

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
