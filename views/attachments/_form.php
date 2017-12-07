<?php

/**
 * @var $form kartik\widgets\ActiveForm
 * @var $model cinghie\articles\models\Attachments
 * @var $this yii\web\View
 */

use cinghie\articles\assets\ArticlesAsset;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles[ArticlesAsset::class];

// Load info
$attachType = Yii::$app->controller->module->attachType;
$attachTypeString = implode(', ', $attachType);
$attachURL = Yii::$app->controller->module->attachURL;

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

                <div class="col-md-9">

                    <p class="bg-info">
                        <?= Yii::t('traits', 'Allowed Extensions')?>: <?= $attachTypeString ?>
                    </p>

                </div>

                <div class="col-md-3">

                    <?= $model->getExitButton() ?>

                    <?= $model->getCancelButton() ?>

                    <?= $model->getSaveButton() ?>

                </div>

            </div>

            <div class="separator"></div>

            <div class="row">

                <div class="col-lg-4">

                    <?= $model->getFileWidget($form,$attachType) ?>

                </div>

                <div class="col-lg-4">

                    <?= $model->getTitleWidget($form) ?>

                    <?= $model->getAliasWidget($form) ?>

                    <?= $form->field($model, 'item_id')->widget(Select2::className(), [
                        'data' => $model->getItemsSelect2(),
                        'addon' => [
                            'prepend' => [
                                'content'=>'<i class="fa fa-file-text-o"></i>'
                            ]
                        ],
                    ]); ?>

                </div>

                <div class="col-lg-4">

                    <div class="row">

                        <div class="col-md-12">

                            <?= $form->field($model, 'titleAttribute')->textarea(['rows' => 1]) ?>

                            <?= $model->getMimeTypeWidget($form) ?>

                        </div>

                        <div class="col-md-4">

                            <?= $form->field($model, 'hits',[
                                'addon' => [
                                    'prepend' => [
                                        'content'=>'<i class="glyphicon glyphicon-eye-open"></i>'
                                    ]
                                ],
                            ])->textInput(['disabled' => true]) ?>

                        </div>

                        <div class="col-md-4">

                            <?= $model->getExtensionWidget($form) ?>

                        </div>


                        <div class="col-md-4">

                            <?= $model->getSizeWidget($form) ?>

                        </div>

                </div>

            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
