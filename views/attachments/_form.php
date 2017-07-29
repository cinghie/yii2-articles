<?php

/**
 * @var $form kartik\widgets\ActiveForm
 * @var $model cinghie\articles\models\Attachments
 * @var $this yii\web\View
 */

use cinghie\articles\assets\ArticlesAsset;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;

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

            <div class="row">

                <div class="col-md-8">

                    <p class="bg-info">
                        <?= Yii::t('articles', 'Allowed Extensions')?>: <?= $attachType ?>
                    </p>

                </div>

                <div class="col-md-4">

                    <?= $model->getExitButton() ?>

                    <?= $model->getCancelButton() ?>

                    <?= $model->getSaveButton() ?>

                </div>

            </div>

            <div class="separator"></div>

            <div class="row">

                <div class="col-lg-12">



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

                    <?= $form->field($model, 'item_id')->widget(Select2::classname(), [
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

                    <div class="row">

                        <div class="col-md-4">

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

                        <div class="col-md-4">

                            <?= $form->field($model, 'extension')->widget(Select2::classname(), [
                                'data' => [
                                    $hits => $hits
                                ],
                                'options' => [ 'disabled' => 'disabled' ],
                                'addon' => [
                                    'prepend' => [
                                        'content'=>'<i class="fa fa-file"></i>'
                                    ]
                                ],
                            ]); ?>

                        </div>

                        <div class="col-md-4">

                            <?= $form->field($model, 'size')->widget(Select2::classname(), [
                                'data' => [
                                    $hits => $hits
                                ],
                                'options' => [ 'disabled' => 'disabled' ],
                                'addon' => [
                                    'prepend' => [
                                        'content'=>'<i class="fa fa-balance-scale"></i>'
                                    ]
                                ],
                            ]); ?>

                        </div>

                </div>

            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
