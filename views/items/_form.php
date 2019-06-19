<?php

/**
 * @var $form kartik\widgets\ActiveForm
 * @var $model cinghie\articles\models\Items
 * @var $this yii\web\View
 */

use cinghie\articles\assets\ArticlesAsset;
use cinghie\articles\models\Items;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles[ArticlesAsset::class];

// Set Tags
$model->tags = $model->getTagsIDByItemID() ?: [];

?>

<div class="items-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype'=>'multipart/form-data'
        ],
    ]) ?>

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
                                        <?= Yii::t('traits', 'SEO') ?>
                                    </a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#image">
                                        <?= Yii::t('traits', 'Image') ?>
                                    </a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#video">
                                        <?= Yii::t('traits', 'Video') ?>
                                    </a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#attach">
                                        <?= Yii::t('traits', 'Attachments') ?>
                                    </a>
                                </li>
                                <?php if(Yii::$app->controller->module->advancedTranslation): ?>
                                <li class="">
                                    <a data-toggle="tab" href="#translations">
			                            <?= Yii::t('traits', 'Translations') ?>
                                    </a>
                                </li>
	                            <?php endif ?>
                                <li class="">
                                    <a data-toggle="tab" href="#params">
                                        <?= Yii::t('traits', 'Options') ?>
                                    </a>
                                </li>
                            </ul>

                        </div>

                        <div class="col-md-6">

                            <?= $model->getExitButton() ?>

                            <?= $model->getTranslationButton() ?>

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

                                        <?= $form->field($model, 'cat_id')->widget(Select2::class, [
                                            'data' => $model->getCategoriesSelect2(),
                                            'addon' => [
                                                'prepend' => [
                                                    'content'=>'<i class="glyphicon glyphicon-folder-open"></i>'
                                                ]
                                            ],
                                        ]) ?>

                                        <?= $model->getLanguageWidget($form) ?>

                                    </div> <!-- end col-md-4 -->

                                    <div class="col-md-12">

                                        <?php if(Yii::$app->controller->module->editor === 'imperavi'): ?>


	                                        <?= $model->getEditorWidget($form,'introtext', 'imperavi', $model->introtext ?: '', [
		                                        'lang' => substr(Yii::$app->language, 0, 2),
		                                        'minHeight' => 260,
		                                        'imageUpload' => Url::to(['/articles/items/image-upload']),
		                                        'plugins' => ['counter','fontfamily','fontcolor','fontsize','imagemanager','table','clips','fullscreen'],
	                                        ]) ?>

	                                        <?= $model->getEditorWidget($form,'fulltext', 'imperavi', $model->fulltext ?: '', [
		                                        'lang' => substr(Yii::$app->language, 0, 2),
		                                        'minHeight' => 260,
		                                        'imageUpload' => Url::to(['/articles/items/image-upload']),
		                                        'plugins' => ['counter','fontfamily','fontcolor','fontsize','imagemanager','table','clips','fullscreen'],
	                                        ]) ?>


                                        <?php else: ?>

	                                        <?= $model->getEditorWidget($form,'introtext') ?>

	                                        <?= $model->getEditorWidget($form,'fulltext') ?>

                                        <?php endif ?>

                                    </div> <!-- end col-md-12 -->

                                </div> <!-- end row -->

                            </div> <!-- end col-md-8 -->

                            <div class="col-md-4">

                                <?= $model->getStateWidget($form) ?>

                                <?= $model->getAccessWidget($form) ?>

                                <?= $form->field($model, 'theme')->widget(Select2::class, [
	                                'data' => $model->getThemesSelect2(),
	                                'addon' => [
		                                'prepend' => [
			                                'content'=>'<i class="glyphicon glyphicon-blackboard"></i>'
		                                ]
	                                ],
                                ]) ?>

                                <?= $model->getUserWidget($form) ?>

                                <?= $model->getOrderingWidget($form,Items::class, 'cat_id',['ordering','title'], ['cat_id' => $model->cat_id, 'language' => $model->language])?>

                                <?= $model->getCreatedWidget($form) ?>

                                <?= $model->getModifiedWidget($form) ?>

                                <?= $model->getCreatedByWidget($form) ?>

                                <?= $model->getModifiedByWidget($form) ?>

                                <?php if ($model->isNewRecord): ?>

                                    <?= $form->field($model, 'hits')->widget(Select2::class, [
                                        'data' => [
	                                        '0' => '0'
                                        ],
                                        'addon' => [
                                            'prepend' => [
                                                'content'=>'<i class="glyphicon glyphicon-eye-open"></i>'
                                            ]
                                        ],
                                    ])?>

                                <?php else : ?>

                                    <?= $form->field($model, 'hits')->widget(Select2::class, [
                                        'data' => [
                                            $model->hits => $model->hits
                                        ],
                                        'addon' => [
                                            'prepend' => [
                                                'content'=>'<i class="glyphicon glyphicon-eye-open"></i>'
                                            ]
                                        ],
                                    ])?>

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
                                    <?= Yii::t('traits', 'Allowed Extensions'). ': ' .implode(', ',$model->getImagesAllowed()) ?>
                                    (<?= Yii::t('traits', 'Max Size'). ': ' .$model->getUploadMaxSize() ?>)
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

                        <!-- Video -->
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

                        <!-- Attachments -->

                        <div id="attach" class="row tab-pane fade">

                            <div class="col-md-12">

                                <p class="bg-info">
		                            <?= Yii::t('traits', 'Allowed Extensions')?>: <?= implode(', ', Yii::$app->controller->module->attachType) ?>
                                </p>

                                <?= $model->getFilesWidget(Yii::$app->controller->module->attachType,Yii::$app->controller->module->attachURL) ?>

                            </div> <!-- end col-md-12 -->

                        </div> <!-- end Attachments -->

                        <!-- Translations -->
	                    <?php if(Yii::$app->controller->module->advancedTranslation): ?>

                            <div id="translations" class="row tab-pane fade">

                                <?php

                                    foreach (Yii::$app->controller->module->languages as $langTag):

                                ?>

                                    <?php

                                        $lang = substr($langTag,0,2);

                                        $selectName = 'translation_'.$lang;
                                        $titleName  = 'title_'.$lang;
                                        $aliasName  = 'alias_'.$lang;
                                        $introText  = 'introText_'.$lang;
                                        $fullText   = 'fullText_'.$lang;

                                        if($model->language !== $lang && $langTag !== Yii::$app->controller->module->languageAll):

                                    ?>

                                    <div class="col-md-6 col-sm-12">

                                        <div class="row">

                                            <div class="col-md-6">

                                                <h2><?= Yii::t('traits','Translation') ?> <?= $langTag ?></h2>

                                            </div>

                                            <div class="col-md-6">

                                                <label class="control-label"></label>

                                                <div class="form-group">

                                                    <div class="input-group">

                                                        <?= Select2::widget([
                                                            'name' => $selectName,
                                                            'data' => $model->getItemsLangSelect2($lang),
                                                            'disabled' => true
                                                        ]) ?>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label class="control-label"><?= Yii::t('traits','Title') ?></label>

                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                                                        <?= Html::textInput($titleName, $model->getFieldTranslation($lang,'title'), ['class' => 'form-control']) ?>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label class="control-label"><?= Yii::t('traits','Alias') ?></label>

                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                                                        <?= Html::textInput($aliasName, $model->getFieldTranslation($lang,'alias'), ['class' => 'form-control']) ?>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-12">

                                                <div class="form-group">

                                                    <label class="control-label"><?= Yii::t('articles','Introtext') ?></label>

                                                    <?= $model->getEditorWidget(null, $introText, '', $model->getFieldTranslation($lang,'introtext')) ?>

                                                </div>

                                            </div>

                                            <div class="col-md-12">

                                                <div class="form-group">

                                                    <label class="control-label" for="items-introtext"><?= Yii::t('articles','Fulltext') ?></label>

                                                    <?= $model->getEditorWidget(null, $fullText, '', $model->getFieldTranslation($lang,'fulltext')) ?>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <?php endif ?>

                                <?php endforeach ?>

                            </div> <!-- #translations -->

                        <?php endif ?>

                        <!-- Params -->
                        <div id="params" class="row tab-pane fade">

                            <div class="separator"></div>

                            <?= $this->render('_form_params') ?>

                        </div> <!-- #params -->

                    </div> <!-- end bs-example-tabs -->

                </div> <!-- col-lg-12 -->

            </div> <!-- end row -->

        </div>

    <?php ActiveForm::end()?>

</div>