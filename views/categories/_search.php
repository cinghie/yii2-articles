<?php

/**
 * @var $form yii\widgets\ActiveForm
 * @var $model cinghie\articles\models\CategoriesSearch
 * @var $this yii\web\View
 */

use kartik\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="categories-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

        <?= $form->field($model, 'id') ?>

        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'alias') ?>

        <?= $form->field($model, 'description') ?>

        <?= $form->field($model, 'parent_id') ?>

        <?php // echo $form->field($model, 'state') ?>

        <?php // echo $form->field($model, 'access') ?>

        <?php // echo $form->field($model, 'ordering') ?>

        <?php // echo $form->field($model, 'image') ?>

        <?php // echo $form->field($model, 'image_caption') ?>

        <?php // echo $form->field($model, 'image_credits') ?>

        <?php // echo $form->field($model, 'params') ?>

        <?php // echo $form->field($model, 'metadesc') ?>

        <?php // echo $form->field($model, 'metakey') ?>

        <?php // echo $form->field($model, 'robots') ?>

        <?php // echo $form->field($model, 'author') ?>

        <?php // echo $form->field($model, 'copyright') ?>

        <?php // echo $form->field($model, 'language') ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('traits', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton(Yii::t('traits', 'Reset'), ['class' => 'btn btn-default']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
