<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="tags-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

        <?= $form->field($model, 'id') ?>

        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'alias') ?>

        <?= $form->field($model, 'description') ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('articles', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton(Yii::t('articles', 'Reset'), ['class' => 'btn btn-default']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
