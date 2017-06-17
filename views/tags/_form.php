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

// Get info by Module Configuration
$editor = Yii::$app->controller->module->editor;

?>

<div class="tags-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-lg-4">

            <?= $form->field($model, 'name', [
                'addon' => [
                    'prepend' => [
                        'content'=>'<i class="glyphicon glyphicon-plus"></i>'
                    ]
                ]
            ])->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'alias', [
                'addon' => [
                    'prepend' => [
                        'content'=>'<i class="glyphicon glyphicon-bookmark"></i>'
                    ]
                ]
            ])->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'state')->widget(Select2::classname(), [
                'data' => [
                    1 => Yii::t('articles', 'Published'),
                    0 => Yii::t('articles', 'Unpublished'),
                ],
                'addon' => [
                    'prepend' => [
                        'content'=>'<i class="glyphicon glyphicon-check"></i>'
                    ]
                ],
            ]); ?>

        </div>

        <div class="col-lg-8">

            <?php if ($editor=="ckeditor"): ?>
                <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                    'options' => ['rows' => 10],
                    'preset'  => 'basic'
                ]); ?>
            <?php elseif ($editor=="tinymce"): ?>
                <?= $form->field($model, 'description')->widget(TinyMce::className(), [
                    'clientOptions' => [
                        'plugins' => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ],
                    'options' => ['rows' => 12]
                ]); ?>
            <?php elseif ($editor=="markdown"): ?>
                <?= $form->field($model, 'description')->widget(
                    MarkdownEditor::classname(),
                    ['height' => 300, 'encodeLabels' => true]
                ); ?>
            <?php elseif ($editor=="imperavi"): ?>
                <?= $form->field($model, 'description')->widget(yii\imperavi\Widget::className(), [
                    'options' => [
                        'css' => 'wym.css',
                        'minHeight' => 300,
                    ],
                    'plugins' => [
                        'fullscreen',
                        'clips'
                    ]
                ]); ?>
            <?php else: ?>
                <?= $form->field($model, 'description')->textarea(['rows' => 12]); ?>
            <?php endif ?>

        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('articles', 'Create') : Yii::t('articles', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
