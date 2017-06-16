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
    <section id="portfolio-items" class="row isotope">
        <?php foreach($model->getItemsByCategory($model->id,"created DESC") as $article): ?>
            <article class="portfolio-item">
                <div class="item col-md-4 col-sm-6 col-xs-12 filter-design isotope-item">
                    <div class="portfolio-item">
                        <h2>
                            <a href="<?= $article->itemUrl ?>" title="<?= Html::encode($article->title) ?>">
                                <?= Html::encode($article->title) ?>
                            </a>
                        </h2>
                        <a class="image" href="<?= $article->itemUrl ?>" title="<?= Html::encode($article->title) ?>">
                            <?= Html::img($article->getImageThumbUrl($params->categoryImageWidth), [
                                'alt' => Html::encode($article->title),
                                'class' => 'img-rounded',
                                'title' => Html::encode($article->title),
                                'width' => '100%']) ?>
                            <span class="hover-zoom"></span>
                        </a>
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
                </div>
            </article>
        <?php endforeach ?>
    </section>
</main>
