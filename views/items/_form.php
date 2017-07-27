<?php

/**
 * @var $form kartik\widgets\ActiveForm
 * @var $model cinghie\articles\models\Items
 * @var $this yii\web\View
 */

use kartik\helpers\Html;
use cinghie\articles\assets\ArticlesAsset;

// Load Kartik Libraries
use kartik\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;

// Load Editors Libraries
use dosamigos\ckeditor\CKEditor;
use dosamigos\tinymce\TinyMce;
use kartik\markdown\MarkdownEditor;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

// Get current user
$user     = Yii::$app->user->identity;
$user_id   = $user->id;
$username = $user->username;

// Get Username
if (!$model->isNewRecord) {
    $modified_by = $model->modified_by;
    $modified_by_username = isset($model->modifiedBy->username) ? $model->modifiedBy->username : $username;
    $created_by  = $model->created_by;
    $created_by_username = $model->createdBy->username;
} else {
    $modified_by = 0;
    $modified_by_username = Yii::t('articles', 'Nobody');
    $created_by  = $user_id ;
    $created_by_username = $username;
}

// Get info by Configuration
$editor           = Yii::$app->controller->module->editor;
$language         = substr(Yii::$app->language,0,2);
$imagetype        = Yii::$app->controller->module->imageType;

// Get info by Model
$attachments      = $model->getAttachments()->asArray()->all();
$roles            = $model->getRolesSelect2();
$select2languages = $model->getLanguagesSelect2();
$select2published = $model->getPublishSelect2();
$select2users     = $model->getUsersSelect2($user_id,$username);
$select2videotype = $model->getVideoTypeSelect2();
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

                                    <div class="col-md-6">

                                        <?= $model->getTitleWidget($form) ?>

                                    </div> <!-- end col-md-6 -->

                                    <div class="col-md-6">

                                        <?= $model->getLanguageWidget($form) ?>

                                    </div> <!-- end col-md-6 -->

                                    <div class="col-md-12">

                                        <?= $model->getEditorWidget($form,'introtext') ?>

                                        <?= $model->getEditorWidget($form,'fulltext') ?>

                                    </div> <!-- end col-md-12 -->

                                </div> <!-- end row -->

                            </div> <!-- end col-md-8 -->

                            <div class="col-md-4">

                                <?= $form->field($model, 'cat_id')->widget(Select2::classname(), [
                                    'data' => $model->getCategoriesSelect2(),
                                    'addon' => [
                                        'prepend' => [
                                            'content'=>'<i class="glyphicon glyphicon-folder-open"></i>'
                                        ]
                                    ],
                                ]); ?>

                                <?= $model->getStateWidget($form) ?>

                                <?= $model->getAccessWidget($form) ?>

                                <?= $model->getUserWidget($form) ?>

                                <?= $form->field($model, 'ordering')->widget(Select2::classname(), [
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

                                    <?= $form->field($model, 'hits')->widget(Select2::classname(), [
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

                                    <?= $form->field($model, 'hits')->widget(Select2::classname(), [
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
                                    <?= Yii::t('articles', 'Allowed Extensions'). ": " .implode(", ",$model->getImagesAllowed()) ?>
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

                                <?= $form->field($model, 'video', [
                                    'addon' => [
                                        'prepend' => [
                                            'content'=>'<i class="glyphicon glyphicon-film"></i>'
                                        ]
                                    ]
                                ])->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'video_type')->widget(Select2::classname(), [
                                    'data' => $select2videotype,
                                    'addon' => [
                                        'prepend' => [
                                            'content'=>'<i class="glyphicon glyphicon-film"></i>'
                                        ]
                                    ],
                                ]); ?>

                            </div> <!-- end col-md-6 -->

                            <div class="col-md-6">

                                <?= $form->field($model, 'video_caption', [
                                    'addon' => [
                                        'prepend' => [
                                            'content'=>'<i class="glyphicon glyphicon-facetime-video"></i>'
                                        ]
                                    ]
                                ])->textarea(['maxlength' => 255,'rows' => 6]) ?>

                                <?= $form->field($model, 'video_credits', [
                                    'addon' => [
                                        'prepend' => [
                                            'content'=>'<i class="glyphicon glyphicon-barcode"></i>'
                                        ]
                                    ]
                                ])->textInput(['maxlength' => 255]) ?>

                            </div> <!-- end col-md-6 -->

                        </div> <!-- end video -->

                        <div id="attach" class="row tab-pane fade">

                            <div class="col-md-12">

                                <?php if(!$model->isNewRecord): ?>

                                    <div class="form-group field-items-files">
                                        <label for="items-files" class="control-label"><?= Yii::t('articles', 'Attachments') ?></label>
                                        <?php foreach($attachments as $attach): ?>
                                            <div class="alert alert-info" role="alert">
                                                <?= $attach['filename'] ?>
                                            </div>
                                        <?php endforeach ?>
                                    </div>

                                <?php else: ?>

                                    <div class="form-group field-items-files">
                                        <label for="items-files" class="control-label"><?= Yii::t('articles', 'Attachments') ?></label>
                                        <div class="alert alert-warning" role="alert"><?= Yii::t('articles', 'No Attachment') ?></div>
                                    </div>

                                <?php endif; ?>

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