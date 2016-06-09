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
use yii\helpers\HtmlPurifier;

?>

<!-- main -->
<main class="categories-view categories-<?php echo $model->theme ?>" role="main">
    <!-- header -->
    <header class="page-header">
        <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        <div class="page-description"><?= HtmlPurifier::process($model->description) ?></div>
    </header>
    <!-- section -->
    <section class="blog">
        <?php foreach($model->getItemsByCategory($model->id,"created DESC") as $article): ?>
            <!-- article -->
            <article class="row blog-post">
                <div class="col-md-3 post-thumb">
                    <a href="<?= $article->itemUrl ?>" title="<?= Html::encode($article->title) ?>">
                        <?= Html::img($article->getImageThumbUrl($params->categoryImageWidth), [
                            'alt' => Html::encode($article->title),
                            'class' => 'img-rounded',
                            'title' => Html::encode($article->title),
                            'width' => '100%']) ?>
                        <span class="hover-zoom"></span>
                    </a>
                </div>
                <div class="col-md-9 post-details">
                    <h2>
                        <a href="<?= $article->itemUrl ?>" title="<?= Html::encode($article->title) ?>">
                            <?= Html::encode($article->title) ?>
                        </a>
                    </h2>
                    <div class="post-meta">
                        <?php if($params->categoryViewCreatedData == "Yes"): ?>
                        <div class="meta-info meta-info-created">
                            <i class="glyphicon glyphicon-calendar"></i> <?= $article->getDateFormatted($article->created) ?>
                        </div>
                        <?php endif ?>
                        <?php if($params->categoryViewUser == "Yes"): ?>
                        <div class="meta-info meta-info-user">
                            <i class="glyphicon glyphicon-user"></i> <?= $article->createdby->username ?>
                        </div>
                        <?php endif ?>
                        <?php if($params->categoryViewHits == "Yes"): ?>
                        <div class="meta-info meta-info-hits">
                            <i class="glyphicon glyphicon-eye-open"></i> <?= $article->hits ?>
                        </div>
                        <?php endif ?>
                    </div>
                    <div class="article-description">
                        <?= HtmlPurifier::process($article->introtext) ?>
                    </div>
                </div>
            </article>
        <?php endforeach ?>
    </section>
</main>
