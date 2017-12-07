<?php

/**
 * @var \cinghie\articles\models\Items $model
 */

use cinghie\articles\assets\ArticlesAsset;
use kartik\helpers\Html;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles[ArticlesAsset::class];

// Set Title and Breadcrumbs
$this->title = Html::encode($model->title);
$this->params['breadcrumbs'][] = $this->title;

/* Render MetaData */
$this->render('@vendor/cinghie/yii2-articles/views/default/_meta_data.php',[ 'model' => $model,]);

/* Facebook Open Graph */
$this->render('@vendor/cinghie/yii2-articles/views/default/_meta_facebook.php',[ 'model' => $model,]);

/* Twitter Card */
$this->render('@vendor/cinghie/yii2-articles/views/default/_meta_twitter.php',[ 'model' => $model,]);

?>

<article class="item-view">

	<header>

    	<h1><?= Html::encode($this->title) ?></h1>
        <time datetime="<?= $model->created ?>"></time>

        <?php if ($model->image): ?>
            <figure>
                <img class="img-responsive center-block img-rounded" src="<?= $model->getImageUrl() ?>" alt="<?= $this->title ?>" title="<?= $this->title ?>">
                <?php if ($model->image_caption): ?>
                	<figcaption class="center-block">
                		<?= $model->image_caption ?>
                    </figcaption>
                <?php endif; ?>
            </figure>
        <?php endif; ?>

    </header>

    <div class="row item-informations">

        <div class="col-md-12">

            <span class="item-created">
                <?= Yii::t('articles','Published on') ?> <?= $model->created ?>,
            </span>

            <span class="item-created">
                <?= Yii::t('traits','by') ?> <?= $model->createdBy->username ?>
            </span>

        </div>

    </div>

    <?php //if ($model->introtext && $model->getOption($model->category->params,"itemIntroText") == "Yes"): ?>

    <div class="row item-content">

        <div class="col-md-12">

            <?php if ($model->introtext): ?>
                <div class="intro-text">
                    <?= $model->introtext ?>
                </div>
                <hr>
            <?php endif; ?>

            <?php if ($model->fulltext): ?>
                <div class="full-text">
                    <?= $model->fulltext ?>
                </div>
            <?php endif; ?>

        </div>

    </div>

</article>

<?php /* if($model->getOption($model->category->params,"itemDebug") == "Yes"): ?>

<div class="items-view-debug">

    <h2>Item Debug</h2>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'alias',
            'cat_id',
            'user_id',
            'state',
            'access',
            'language',
            'ordering',
            'hits',
            'image:ntext',
            'image_caption',
            'image_credits',
            'video:ntext',
            'video_caption',
            'video_credits',
            'created',
            'created_by',
            'modified',
            'modified_by',
            'params:ntext',
            'metadesc:ntext',
            'metakey:ntext',
            'robots',
            'author',
            'copyright',
        ],
    ]) ?>

</div>

<?php endif; */ ?>
