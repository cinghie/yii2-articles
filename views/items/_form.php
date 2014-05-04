<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\modules\articles\models\Items $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="items-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'catid')->textInput() ?>

    <?= $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'modified')->textInput() ?>

    <?= $form->field($model, 'language')->textInput(['maxlength' => 7]) ?>

    <?= $form->field($model, 'published')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'modified_by')->textInput() ?>

    <?= $form->field($model, 'access')->textInput() ?>

    <?= $form->field($model, 'ordering')->textInput() ?>

    <?= $form->field($model, 'hits')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'introtext')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fulltext')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image_caption')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'video')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'video_caption')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'metadesc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'metakey')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'params')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'image_credits')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'video_credits')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'robots')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'copyright')->textInput(['maxlength' => 50]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
