<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.1
*/

use cinghie\articles\assets\ArticlesAsset;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

// Set Title and Breadcrumbs
$this->title = Yii::t('articles', 'Articles');
$this->params['breadcrumbs'][] = $this->title;

// Render Yii2-Articles Menu
echo Yii::$app->view->renderFile('@vendor/cinghie/yii2-articles/views/default/_menu.php');

// Register action buttons js
$this->registerJs('
    $(document).ready(function()
    {
        $("a.btn-update").click(function() {
            var selectedId = $("#w2").yiiGridView("getSelectedRows");

            if(selectedId.length == 0) {
                alert("'.Yii::t("articles", "Select at least one item").'");
            } else if(selectedId.length>1){
                alert("'.Yii::t("articles", "Select only 1 item").'");
            } else {
                var url = "'.Url::to(['/articles/items/update']).'?id="+selectedId[0];
                window.location.href= url;
            }
        });
        $("a.btn-active").click(function() {
            var selectedId = $("#w2").yiiGridView("getSelectedRows");

            if(selectedId.length == 0) {
                alert("'.Yii::t("articles", "Select at least one item").'");
            } else {
                $.ajax({
                    type: \'POST\',
                    url : "'.Url::to(['/articles/items/activemultiple']).'?id="+selectedId,
                    data : {ids: selectedId},
                    success : function() {
                        $.pjax.reload({container:"#w2"});
                    }
                });
            }
        });
        $("a.btn-deactive").click(function() {
            var selectedId = $("#w2").yiiGridView("getSelectedRows");

            if(selectedId.length == 0) {
                alert("'.Yii::t("articles", "Select at least one item").'");
            } else {
                $.ajax({
                    type: \'POST\',
                    url : "'.Url::to(['/articles/items/deactivemultiple']).'?id="+selectedId,
                    data : {ids: selectedId},
                    success : function() {
                        $.pjax.reload({container:"#w2"});
                    }
                });
            }
        });
        $("a.btn-delete").click(function() {
            var selectedId = $("#w2").yiiGridView("getSelectedRows");

            if(selectedId.length == 0) {
                alert("'.Yii::t("articles", "Select at least one item").'");
            } else {
                var choose = confirm("'.Yii::t("articles", "Do you want delete selected items?").'");

                if (choose == true) {
                    $.ajax({
                        type: \'POST\',
                        url : "'.Url::to(['/articles/items/deletemultiple']).'?id="+selectedId,
                        data : {ids: selectedId},
                        success : function() {
                            $.pjax.reload({container:"#w2"});
                        }
                    });
                }
            }
        });
        $("a.btn-preview").click(function() {
            var selectedId = $("#w2").yiiGridView("getSelectedRows");

            if(selectedId.length == 0) {
                alert("'.Yii::t("articles", "Select at least one item").'");
            } else if(selectedId.length>1){
                alert("'.Yii::t("articles", "Select only 1 item").'");
            } else {
                var url = "'.Url::to(['/articles/items/view']).'?id="+selectedId[0];
                window.open(url,"_blank");
            }
        });
    });
');

?>
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
                    'attribute' => 'catid',
                    'format' => 'html',
                    'hAlign' => 'center',
                    'value' => 'category.name',
                    'value' => function ($data) {
                        $url = urldecode(Url::toRoute(['categories/update', 'id' => $data->catid]));
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
                    'value' => 'modifiedby.username',
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
                'heading'    => '<h3 class="panel-title"><i class="fa fa-file-text-o"></i></h3>',
                'type'       => 'success',
                'before'     => '<span style="margin-right: 5px;">'.
                    Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('articles', 'New'),
                        ['create'], ['class' => 'btn btn-success']
                    ).'</span><span style="margin-right: 5px;">'.
                    Html::a('<i class="glyphicon glyphicon-pencil"></i> '.Yii::t('articles', 'Update'),
                        '#', ['class' => 'btn btn-update btn-warning']
                    ).'</span><span style="margin-right: 5px;">'.
                    Html::a('<i class="glyphicon glyphicon-minus-sign"></i> '.Yii::t('articles', 'Delete'),
                        '#', ['class' => 'btn btn-delete btn-danger']
                    ).'</span><span style="margin-right: 5px;">'.
                    Html::a('<i class="fa fa-eye"></i> '.Yii::t('articles', 'Preview'),
                        '#', ['class' => 'btn btn-preview btn-info']
                    ).'</span><span style="float: right; margin-right: 5px;">'.
                    Html::a('<i class="glyphicon glyphicon-remove"></i> '.Yii::t('essentials', 'Deactive'),
                        '#', ['class' => 'btn btn-deactive btn-danger']
                    ).'</span><span style="float: right; margin-right: 5px;">'.
                    Html::a('<i class="glyphicon glyphicon-ok"></i> '.Yii::t('essentials', 'Active'),
                        ['#'], ['class' => 'btn btn-active btn-success']
                    ).'</span>',
                'after' => Html::a(
                    '<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('articles', 'Reset Grid'), ['index'], ['class' => 'btn btn-info']
                ),
                'showFooter' => false
            ],
        ]); ?>

        <?php Pjax::end() ?>

    </div>

</div>
