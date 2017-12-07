<?php

/**
 * @var $model cinghie\articles\models\Categories
 */

use kartik\helpers\Html;
use cinghie\articles\assets\ArticlesAsset;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles[ArticlesAsset::class];

// Set Title and Breadcrumbs
$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = $this->title;

/* Render MetaData */
$this->render('@vendor/cinghie/yii2-articles/views/default/_meta_data.php',[ 'model' => $model,]);
$this->render('@vendor/cinghie/yii2-articles/views/default/_meta_facebook.php',[ 'model' => $model,]);
$this->render('@vendor/cinghie/yii2-articles/views/default/_meta_twitter.php',[ 'model' => $model,]);

// Decode Params
$params = json_decode($model->params);

// Render Theme
$themePath = 'themes/'.$model->theme;
echo($this->render($themePath,['model'=>$model,'params'=>$params]));

?>
