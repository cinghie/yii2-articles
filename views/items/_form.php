<?php

/**
 * @var $form kartik\widgets\ActiveForm
 * @var $model cinghie\articles\models\Items
 * @var $this yii\web\View
 */

use cinghie\articles\assets\ArticlesAsset;

// Load Kartik Libraries
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles[ArticlesAsset::class];

// Load info
$attachType = Yii::$app->controller->module->attachType;
$attachTypeString = implode(', ', $attachType);
$attachURL = Yii::$app->controller->module->attachURL;

// Set Tags
$model->tags = $model->getTagsIDByItemID() ? $model->getTagsIDByItemID() : [];

?>

<div class="items-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype'=>'multipart/form-data'
        ],
    ]); ?>

        <div class="row">

            <div class="col-lg-12">

                <div class="bs-example bs-example-tabs">

                    <div class="row">

                        <div class="col-md-6">

                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active">
                                    <a data-toggle="tab" href="#item">
                                        <?= Yii::t('articles', 'Item') ?>
                                    </a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#seo">
                                        <?= Yii::t('articles', 'SEO') ?>
                                    </a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#image">
                                        <?= Yii::t('traits', 'Image') ?>
                                    </a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#video">
                                        <?= Yii::t('articles', 'Video') ?>
                                    </a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#attach">
                                        <?= Yii::t('articles', 'Attachments') ?>
                                    </a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#params">
                                        <?= Yii::t('articles', 'Options') ?>
                                    </a>
                                </li>
                            </ul>

                        </div>

                        <div class="col-md-6">

                            <?= $model->getExitButton() ?>

                            <?= $model->getCancelButton() ?>

                            <?= $model->getSaveButton() ?>

                        </div>

                    </div>

                    <!-- Tab Contents -->
                    <div class="tab-content" id="myTabContent">

                        <!-- Item -->
                        <div id="item" class="row tab-pane fade active in">

                            <div class="separator"></div>

                            <div class="col-md-8">

                                <div class="row">

                                    <div class="col-md-7">

                                        <?= $model->getTitleWidget($form) ?>

                                        <?= $model->getTagsWidget($form) ?>

                                    </div> <!-- end col-md-8 -->

                                    <div class="col-md-5">

                                        <?= $form->field($model, 'cat_id')->widget(Select2::className(), [
                                            'data' => $model->getCategoriesSelect2(),
                                            'addon' => [
                                                'prepend' => [
                                                    'content'=>'<i class="glyphicon glyphicon-folder-open"></i>'
                                                ]
                                            ],
                                        ]); ?>

                                        <?= $model->getLanguageWidget($form) ?>

                                    </div> <!-- end col-md-4 -->

                                    <div class="col-md-12">

                                        <?= $model->getEditorWidget($form,'introtext') ?>

                                        <?= $model->getEditorWidget($form,'fulltext') ?>

                                    </div> <!-- end col-md-12 -->

                                </div> <!-- end row -->

                            </div> <!-- end col-md-8 -->

                            <div class="col-md-4">

                                <?= $model->getStateWidget($form) ?>

                                <?= $model->getAccessWidget($form) ?>

                                <?= $model->getUserWidget($form) ?>

                                <?= $form->field($model, 'ordering')->widget(Select2::className(), [
                                    'data' => [
                                        "0" =>  Yii::t('articles', 'In Development')
                                    ],
                                    'options' => [
                                        'disabled' => 'disabled',
                                    ],
                                    'addon' => [
                                        'prepend' => [
                                            'content'=>'<i class="glyphicon glyphicon-sort"></i>'
                                        ]
                                    ],
                                ]); ?>

                                <?= $model->getCreatedWidget($form) ?>

                                <?= $model->getModifiedWidget($form) ?>

                                <?= $model->getCreatedByWidget($form) ?>

                                <?= $model->getModifiedByWidget($form) ?>

                                <?php if ($model->isNewRecord): ?>

                                    <?= $form->field($model, 'hits')->widget(Select2::className(), [
                                        'data' => [
                                            "0" => "0"
                                        ],
                                        'options' => [
                                            'disabled' => 'disabled'
                                        ],
                                        'addon' => [
                                            'prepend' => [
                                                'content'=>'<i class="glyphicon glyphicon-eye-open"></i>'
                                            ]
                                        ],
                                    ]); ?>

                                <?php else : ?>

                                    <?= $form->field($model, 'hits')->widget(Select2::className(), [
                                        'data' => [
                                            $model->hits => $model->hits
                                        ],
                                        'options' => [
                                            'disabled' => 'disabled'
                                        ],
                                        'addon' => [
                                            'prepend' => [
                                                'content'=>'<i class="glyphicon glyphicon-eye-open"></i>'
                                            ]
                                        ],
                                    ]); ?>

                                <?php endif ?>

                            </div> <!-- end col-md-3 -->

                        </div> <!-- end #item -->

                        <!-- SEO -->
                        <div id="seo" class="row tab-pane fade">

                            <div class="col-md-5">

                                <?= $model->getAliasWidget($form) ?>

                                <?= $model->getRobotsWidget($form) ?>

                                <?= $model->getAuthorWidget($form) ?>

                                <?= $model->getCopyrightWidget($form) ?>

                            </div> <!-- col-md-5 -->

                            <div class="col-md-7">

                                <?= $model->getMetaDescriptionWidget($form) ?>

                                <?= $model->getMetaKeyWidget($form) ?>

                            </div> <!-- col-md-7 -->

                        </div> <!-- seo -->

                        <!-- Image -->
                        <div id="image" class="row tab-pane fade">

                            <div class="separator"></div>

                            <div class="col-lg-12">

                                <p class="bg-info">
                                    <?= Yii::t('traits', 'Allowed Extensions'). ": " .implode(", ",$model->getImagesAllowed()) ?>
                                    (<?= Yii::t('articles', 'Max Size'). ": " .$model->getUploadMaxSize() ?>)
                                </p>

                            </div> <!-- col-lg-12 -->

                            <div class="col-lg-6">

                                <?= $model->getImageWidget()  ?>

                            </div> <!-- col-lg-6 -->

                            <div class="col-lg-6">

                                <?= $model->getImageCaptionWidget($form) ?>

                                <?= $model->getImageCreditsWidget($form) ?>

                            </div> <!-- col-lg-6 -->

                        </div> <!-- #image -->

                        <!-- video -->
                        <div id="video" class="row tab-pane fade">

                            <div class="col-md-6">

                                <?= $model->getVideoIDWidget($form) ?>

                                <?= $model->getVideoTypeWidget($form) ?>

                            </div> <!-- end col-md-6 -->

                            <div class="col-md-6">

                                <?= $model->getVideoCaptionWidget($form) ?>

                                <?= $model->getVideoCreditsWidget($form) ?>

                            </div> <!-- end col-md-6 -->

                        </div> <!-- end video -->

                        <div id="attach" class="row tab-pane fade">

                            <div class="col-md-12">

                                <p class="bg-info">
		                            <?= Yii::t('traits', 'Allowed Extensions')?>: <?= $attachTypeString ?>
                                </p>

                                <?= $model->getFilesWidget($attachType,$attachURL) ?>

                            </div> <!-- end col-md-12 -->

                        </div> <!-- end attach -->

                        <div id="params" class="row tab-pane fade">

                            <div class="separator"></div>

                            <?= $this->render('_form_params') ?>

                        </div> <!-- #params -->

                    </div> <!-- end bs-example-tabs -->

                </div> <!-- col-lg-12 -->

            </div> <!-- end row -->

        </div>

    <?php ActiveForm::end(); ?>

</div>