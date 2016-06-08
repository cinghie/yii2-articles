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
use cinghie\articles\assets\ArticlesAsset;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

// Set Title and Breadcrumbs
$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;

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
        <?php foreach($model->getItemsByCategory($model->id) as $article): ?>

            <article class="row blog-post">

                <div class="col-md-3 post-thumb">
                    <a href="http://demo.neontheme.com/frontend/blog-post/">
                        <?= Html::img($model->getImageThumbUrl("small"), ['class'=> 'img-rounded', 'width' => '100%']) ?>
                        <img src="http://demo.neontheme.com/assets/frontend/images/blog-thumb-1.png" class="img-rounded">
                        <span class="hover-zoom"></span>
                    </a>
                </div>

                <div class="col-md-9 post-details">
                    <h2><?= Html::encode($article['title']) ?></h2>
                    <div class="post-meta">
                        <div class="meta-info">
                            <i class="glyphicon glyphicon-calendar"></i> <?= $article['created'] ?>
                        </div>
                        <div class="meta-info">
                            <i class="glyphicon glyphicon-user"></i> <?= $article['created_by'] ?>
                        </div>
                    </div>
                    <div class="article-description">
                        <?= HtmlPurifier::process($article['introtext']) ?>
                    </div>
                </div>

            </article>

        <?php endforeach ?>
    </section>

</main>
