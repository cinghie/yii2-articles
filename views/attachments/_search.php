<?php

/**
 * @var $form yii\widgets\ActiveForm
 * @var $model cinghie\articles\models\AttachmentsSearch
 * @var $this yii\web\View
 */

use kartik\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="attachments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

        <?= $form->field($model, 'id') ?>

        <?= $form->field($model, 'item_id') ?>

        <?= $form->field($model, 'filename') ?>

        <?= $form->field($model, 'title') ?>

        <?= $form->field($model, 'titleAttribute') ?>

        <?php // echo $form->field($model, 'hits') ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('traits', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton(Yii::t('traits', 'Reset'), ['class' => 'btn btn-default']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
