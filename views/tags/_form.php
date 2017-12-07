<?php

/**
 * @var $form kartik\widgets\ActiveForm
 * @var $model cinghie\articles\models\Tags
 * @var $this yii\web\View
 */

use kartik\helpers\Html;
use cinghie\articles\assets\ArticlesAsset;

// Load Kartik Libraries
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;

// Load Editors Libraries
use dosamigos\ckeditor\CKEditor;
use dosamigos\tinymce\TinyMce;
use kartik\markdown\MarkdownEditor;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

?>

<div class="tags-form">

	<?php $form = ActiveForm::begin(); ?>

        <div class="row">

            <div class="col-md-6">

                <?= Yii::$app->view->renderFile('@vendor/cinghie/yii2-articles/views/default/_menu.php'); ?>

            </div>

            <div class="col-md-6">

                <?= $model->getExitButton() ?>

                <?= $model->getCancelButton() ?>

                <?= $model->getSaveButton() ?>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-4">

                <?= $model->getNameWidget($form) ?>

                <?= $model->getAliasWidget($form) ?>

                <?= $model->getStateWidget($form) ?>

            </div>

            <div class="col-lg-8">

                <?= $model->getEditorWidget($form,'description') ?>

            </div>

        </div>

    <?php ActiveForm::end(); ?>

</div>
