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
use yii\widgets\DetailView;
use cinghie\articles\assets\ArticlesAsset;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

// Get info by Configuration
$editor    = Yii::$app->controller->module->editor;
$language  = substr(Yii::$app->language,0,2);
$languages = Yii::$app->controller->module->languages;
$imagetype = Yii::$app->controller->module->categoryimagetype;
$imageurl  = Yii::$app->homeUrl.Yii::$app->controller->module->categoryimagepath;

// SEO Parameters
$this->title = $model->name;
$this->registerMetaTag([
	'name' => 'robots',
	'content' => $model->robots,
]);
if ($model->metadesc) {
	$this->registerMetaTag([
		'name' => 'description',
		'content' => $model->metadesc,
	]);
}
if ($model->metakey) {
	$this->registerMetaTag([
		'name' => 'keywords',
		'content' => $model->metakey
	]);
}
if ($model->author) {
	$this->registerMetaTag([
		'name' => 'author',
		'content' => $model->author
	]);
}
if ($model->copyright) {
	$this->registerMetaTag([
		'name' => 'copyright',
		'content' => $model->copyright
	]);
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-actions">
	<div class="row">
    	<div class="col-lg-4 col-sm-4">
			<?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                 ],
            ]) ?>
        </div>
    </div>
</div>
<div class="category-view">    
    <div class="row">
        <div class="col-lg-4 col-sm-4">
            <div class="image">
                <img alt="<?= $imageurl.$model->name ?>" src="<?= $imageurl.$model->image ?>" class="img-responsive" title="<?= $imageurl.$model->name ?>">
                <?php if($model->image_caption) { ?>
                    <div class="caption">
                        <?= $model->image_caption ?>
                    </div>
                <?php } ?>
                <?php if($model->image_credits) { ?>
                    <div class="credits">
                        <small><?= $model->image_credits ?></small>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-8 col-sm-8">
        	<h1><?= Html::encode($this->title) ?></h1>
            <div class="description">
				<?= $model->description ?>
            </div>
        </div>
    </div>
</div>
<div class="category-items"> 
	<div class="row category-item"> 
        <h3>Items 1</h3>
        <div class="col-lg-2 col-sm-2">
            <div class="image">
                <img alt="<?= $imageurl.$model->name ?>" src="<?= $imageurl.$model->image ?>" class="img-responsive" title="<?= $imageurl.$model->name ?>">
            </div>
        </div>
        <div class="col-md-10 col-sm-10">
            <div class="text">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
    </div>
    <div class="row category-item"> 
        <h3>Items 2</h3>
        <div class="col-lg-2 col-sm-2">
            <div class="image">
                <img alt="<?= $imageurl.$model->name ?>" src="<?= $imageurl.$model->image ?>" class="img-responsive" title="<?= $imageurl.$model->name ?>">
            </div>
        </div>
        <div class="col-md-10 col-sm-10">
            <div class="text">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
    </div>
</div>
