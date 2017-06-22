<?php

/**
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model cinghie\articles\models\Items
 * @var $searchModel cinghie\articles\models\ItemsSearch
 * @var $this yii\web\View
 */

use cinghie\articles\assets\ArticlesAsset;
use kartik\grid\GridView;
use kartik\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

// Set Title and Breadcrumbs
$this->title = Yii::t('articles', 'Items');
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Articles'), 'url' => ['/articles/default/index']];
$this->params['breadcrumbs'][] = $this->title;

// Register action buttons js
$this->registerJs('$(document).ready(function() 
    {'
    .$searchModel->getUpdateButtonJavascript('#w1')
    .$searchModel->getDeleteButtonJavascript('#w1')
    .$searchModel->getActiveButtonJavascript('#w1')
    .$searchModel->getDeactiveButtonJavascript('#w1')
    .$searchModel->getPreviewButtonJavascript('#w1').
    '});
');

?>

<div class="row">

    <!-- action menu -->
    <div class="col-md-6">

        <?= Yii::$app->view->renderFile('@vendor/cinghie/yii2-articles/views/default/_menu.php'); ?>

    </div>

    <!-- action buttons -->
    <div class="col-md-6">

        <?= $searchModel->getDeactiveButton() ?>

        <?= $searchModel->getActiveButton() ?>

        <?= $searchModel->getResetButton() ?>

        <?= $searchModel->getPreviewButton() ?>

        <?= $searchModel->getDeleteButton() ?>

        <?= $searchModel->getUpdateButton() ?>

        <?= $searchModel->getCreateButton() ?>

    </div>

</div>

<div class="separator"></div>

<div class="items-index">

    <?php if(Yii::$app->getModule('articles')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    <?php endif ?>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- Categories Grid -->
    <div class="categories-grid">

        <?php Pjax::begin() ?>

            <?= GridView::widget([
                'dataProvider'=> $dataProvider,
                'filterModel' => $searchModel,
                'containerOptions' => ['class' => 'articles-pjax-container'],
                'pjaxSettings'=>[
                    'neverTimeout' => true,
                ],
                'columns' => [
                    [
                        'class' => '\kartik\grid\CheckboxColumn'
                    ],
                    [
                        'attribute' => 'title',
                        'format' => 'html',
                        'hAlign' => 'center',
                        'value' => function ($data) {
                            $url = urldecode(Url::toRoute(['items/update',
                                'id' => $data->id,
                                'alias' => $data->alias,
                                'cat' => isset($data->category->alias) ? $data->category->alias : null
                            ]));
                            return Html::a($data->title,$url);
                        }
                    ],
                    [
                        'attribute' => 'cat_id',
                        'format' => 'html',
                        'hAlign' => 'center',
                        'value' => function ($data) {
                            $url = urldecode(Url::toRoute(['categories/update', 'id' => $data->cat_id]));
                            $cat = isset($data->category->name) ? $data->category->name : "";

                            if($cat!="") {
                                return Html::a($cat,$url);
                            } else {
                                return Yii::t('articles', 'Nobody');
                            }
                        }
                    ],
                    [
                        'attribute' => 'access',
                        'hAlign' => 'center',
                    ],
                    [
                        'attribute' => 'created_by',
                        'hAlign' => 'center',
                        'format' => 'html',
                        'value' => function ($data) {
                            $url = urldecode(Url::toRoute(['/user/profile/show', 'id' => $data->created_by]));
                            $createdby = isset($data->createdby->username) ? $data->createdby->username : "";

                            if($data->created_by!=0) {
                                return Html::a($createdby,$url);
                            } else {
                                return Yii::t('articles', 'Nobody');
                            }
                        }
                    ],
                    [
                        'attribute' => 'created',
                        'hAlign' => 'center',
                    ],
                    [
                        'attribute' => 'modified_by',
                        'format' => 'html',
                        'hAlign' => 'center',
                        'value' => function ($data) {
                            $url = urldecode(Url::toRoute(['/user/profile/show', 'id' => $data->modified_by]));
                            $modifiedby = isset($data->modifiedby->username) ? $data->modifiedby->username : "";

                            if($modifiedby!="") {
                                return Html::a($modifiedby,$url);
                            } else {
                                return Yii::t('articles', 'Nobody');
                            }
                        }
                    ],
                    [
                        'attribute' => 'modified',
                        'hAlign' => 'center',
                    ],
                    [
                        'attribute' => 'image',
                        'format' => 'html',
                        'hAlign' => 'center',
                        'value' => function ($model) {
                            if ($model->image) {
                                return Html::img($model->getImageThumbUrl("small"), ['width' => '36px']);
                            } else {
                                return Yii::t('articles', 'Nobody');
                            }
                        },
                        'width' => '6%',
                    ],
                    [
                        'attribute' => 'language',
                        'hAlign' => 'center',
                        'width' => '5%',
                    ],
                    [
                        'attribute' => 'state',
                        'format' => 'raw',
                        'hAlign' => 'center',
                        'width' => '5%',
                        'value' => function ($model) {
                            if($model->state) {
                                return Html::a('<span class="glyphicon glyphicon-ok text-success"></span>', ['changestate', 'id' => $model->id], [
                                    'data-method' => 'post',
                                ]);
                            } else {
                                return Html::a('<span class="glyphicon glyphicon-remove text-danger"></span>', ['changestate', 'id' => $model->id], [
                                    'data-method' => 'post',
                                ]);
                            }
                        }
                    ],
                    [
                        'attribute' => 'id',
                        'width' => '5%',
                        'hAlign' => 'center',
                    ]
                ],
                'responsive' => true,
                'hover' => true,
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="fa fa-folder-open"></i></h3>',
                    'type' => 'success',
                    'footer' => ''
                ],
            ]); ?>

        <?php Pjax::end() ?>

    </div>

</div>
