<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-articles
 * @version 0.6.3
 */

use cinghie\articles\assets\ArticlesAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

/* Render MetaData */
//$this->render('@vendor/cinghie/yii2-articles/views/default/_meta_data.php',[ 'model' => $model,]);

/* Facebook Open Graph */
//$this->render('@vendor/cinghie/yii2-articles/views/default/_meta_facebook.php',[ 'model' => $model,]);

/* Twitter Card */
//$this->render('@vendor/cinghie/yii2-articles/views/default/_meta_twitter.php',[ 'model' => $model,]);

?>
<div class="tags-view">

    <header>
        <h1><?= Html::encode($this->title) ?></h1>
    </header>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'alias',
            'description:ntext',
        ],
    ]) ?>

</div>
