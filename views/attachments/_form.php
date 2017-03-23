<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.3
*/

use cinghie\articles\assets\ArticlesAsset;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use yii\helpers\Html;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

// Load info
$attachType       = Yii::$app->controller->module->attachType;
$select2articles = $model->getItemsSelect2();

if ($model->isNewRecord) {
    $hits = "0";
} else {
    $hits = $model->hits;
}

?>

<div class="attachments-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype'=>'multipart/form-data'
        ],
    ]); ?>

    <div class="row">

        <div class="col-lg-12">

            <div class="col-lg-12">

                <p class="bg-info">
                    <?= Yii::t('articles', 'Allowed Extensions')?>: <?= $attachType ?>
                </p>

            </div>

            <div class="col-lg-5">

                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'filename')->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => $attachType
                    ],
                    'pluginOptions' => [
                        'previewFileType' => 'image',
                        'showUpload'      => false,
                        'browseLabel'     => Yii::t('articles', 'Browse &hellip;'),
                    ],
                ]); ?>

                <?= $form->field($model, 'itemid')->widget(Select2::classname(), [
                    'data' => $select2articles,
                    'addon' => [
                        'prepend' => [
                            'content'=>'<i class="fa fa-file-text-o"></i>'
                        ]
                    ],
                ]); ?>

            </div>

            <div class="col-lg-7">

                <?= $form->field($model, 'titleAttribute')->textarea(['rows' => 4]) ?>

                <?= $form->field($model, 'hits')->widget(Select2::classname(), [
                    'data' => [
                        $hits => $hits
                    ],
                    'options' => [ 'disabled' => 'disabled' ],
                    'addon' => [
                        'prepend' => [
                            'content'=>'<i class="glyphicon glyphicon-eye-open"></i>'
                        ]
                    ],
                ]); ?>

            </div>

            <div class="col-lg-12">

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
