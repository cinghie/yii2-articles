<?php

/**
 * @var $form yii\widgets\ActiveForm
 * @var $model cinghie\articles\models\TagsSearch
 * @var $this yii\web\View
 */

use kartik\helpers\Html;
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
            <?= Html::submitButton(Yii::t('traits', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton(Yii::t('traits', 'Reset'), ['class' => 'btn btn-default']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
