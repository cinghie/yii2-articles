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
use yii\widgets\DetailView;
use cinghie\articles\assets\ArticlesAsset;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

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
        <time pubdate datetime="<?= $model->created ?>"></time>
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
</article>

<div class="items-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'alias',
            'catid',
            'userid',
            'published',
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
        ],
    ]) ?>

</div>
