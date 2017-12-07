<?php

/**
 * @var $model cinghie\articles\models\Tags
 */

use cinghie\articles\assets\ArticlesAsset;
use kartik\helpers\Html;
use yii\widgets\DetailView;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles[ArticlesAsset::class];

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
