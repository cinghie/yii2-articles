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
$this->title = Yii::t('articles', 'Attachments');
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
                var url = "'.Url::to(['/articles/attachments/update']).'?id="+selectedId[0];
                window.location.href= url;
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
                        url : "'.Url::to(['/articles/attachments/deletemultiple']).'?id="+selectedId,
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
                var url = "'.Url::to(['/articles/attachments/view']).'?id="+selectedId[0];
                window.location.href= url;
            }
        });
    });
');

?>
<div class="attachments-index">

    <?php if(Yii::$app->getModule('articles')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    <?php endif ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin() ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                'value' => function ($model) {
                    $url = urldecode(Url::toRoute(['attachments/update', 'id' => $model->id]));
                    return Html::a($model->title,$url);
                }
            ],
            [
                'attribute' => 'itemid',
                'format' => 'html',
                'hAlign' => 'center',
                'value' => 'item.title',
                'value' => function ($data) {
                    $url  = urldecode(Url::toRoute(['items/update', 'id' => $data->itemid]));
                    $item = isset($data->item->title) ? $data->item->title : "";

                    if($item!="") {
                        return Html::a($item,$url);
                    } else {
                        return Yii::t('articles', 'Nobody');
                    }
                }
            ],
            [
                'attribute' => 'filename',
                'hAlign' => 'center',
            ],
            [
                'attribute' => 'hits',
                'hAlign' => 'center',
                'width' => '8%',
            ],
            [
                'attribute' => 'id',
                'hAlign' => 'center',
                'width' => '8%',
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'panel' => [
            'heading'    => '<h3 class="panel-title"><i class="fa fa-paperclip"></i></h3>',
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
                ).'</span>',
            'after' => Html::a(
                '<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('articles', 'Reset Grid'), ['index'], ['class' => 'btn btn-info']
            ),
            'showFooter' => false
        ],
    ]); ?>

    <?php Pjax::end() ?>

</div>
