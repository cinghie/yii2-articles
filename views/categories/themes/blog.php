<?php

use kartik\helpers\Html;
use yii\helpers\HtmlPurifier;

?>

<main class="<?php echo $model->theme ?> categories-view" role="main">
    <header class="page-header">
        <div class="category-image">
             <?= Html::img($model->getImageThumbUrl($params->categoriesImageWidth), [
                'alt' => Html::encode($model->name),
                'class' => 'img-rounded',
                'title' => Html::encode($model->name)
             ]) ?>
        </div>
        <h1 class="category-title">
            <?= Html::encode($this->title) ?>
        </h1>
        <div class="category-description">
            <?= HtmlPurifier::process($model->description) ?>
        </div>
    </header>
    <section class="blog-items">
        <?php foreach($model->getItemsByCategory($model->id,"created DESC") as $article): ?>
            <article class="row blog-post">
                <div class="col-md-3 post-thumb">
                    <a href="<?= $article->itemUrl ?>" title="<?= Html::encode($article->title) ?>">
                        <?= Html::img($article->getImageThumbUrl($params->categoryImageWidth), [
                            'alt' => Html::encode($article->title),
                            'class' => 'img-rounded',
                            'title' => Html::encode($article->title),
                            'width' => '100%'])
                        ?>
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
                        <?php if($params->categoryCreatedData == "Yes"): ?>
                        <div class="meta-info meta-info-created">
                            <i class="glyphicon glyphicon-calendar"></i> <?= $article->getDateFormatted($article->created) ?>
                        </div>
                        <?php endif ?>
                        <?php if($params->categoryUser == "Yes"): ?>
                        <div class="meta-info meta-info-user">
                            <i class="glyphicon glyphicon-user"></i> <?= $article->createdBy->username ?>
                        </div>
                        <?php endif ?>
                        <?php if($params->categoryHits == "Yes"): ?>
                        <div class="meta-info meta-info-hits">
                            <i class="glyphicon glyphicon-eye-open"></i> <?= $article->hits ?>
                        </div>
                        <?php endif ?>
                    </div>
                    <div class="article-description">
                        <div class="article-introtext">
                            <?php if($params->categoryIntroText == "Yes"): ?>
                                <?= HtmlPurifier::process($article->introtext) ?>
                            <?php endif ?>
                        </div>
                        <div class="article-fulltext">
                            <?php if($params->categoryFullText == "Yes"): ?>
                                <?= HtmlPurifier::process($article->fulltext) ?>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </article>
        <?php endforeach ?>
    </section>
</main>
