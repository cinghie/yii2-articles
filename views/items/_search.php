<?php

/**
 * @var $form yii\widgets\ActiveForm
 * @var $model cinghie\articles\models\ItemsSearch
 * @var $this yii\web\View
 */

use kartik\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="items-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

        <?= $form->field($model, 'id') ?>

        <?= $form->field($model, 'title') ?>

        <?= $form->field($model, 'alias') ?>

        <?= $form->field($model, 'cat_id') ?>

        <?= $form->field($model, 'user_id') ?>

        <?php // echo $form->field($model, 'introtext') ?>

        <?php // echo $form->field($model, 'fulltext') ?>

        <?php // echo $form->field($model, 'state') ?>

        <?php // echo $form->field($model, 'access') ?>

        <?php // echo $form->field($model, 'language') ?>

        <?php // echo $form->field($model, 'ordering') ?>

        <?php // echo $form->field($model, 'hits') ?>

        <?php // echo $form->field($model, 'image') ?>

        <?php // echo $form->field($model, 'image_caption') ?>

        <?php // echo $form->field($model, 'image_credits') ?>

        <?php // echo $form->field($model, 'video') ?>

        <?php // echo $form->field($model, 'video_caption') ?>

        <?php // echo $form->field($model, 'video_credits') ?>

        <?php // echo $form->field($model, 'created') ?>

        <?php // echo $form->field($model, 'created_by') ?>

        <?php // echo $form->field($model, 'modified') ?>

        <?php // echo $form->field($model, 'modified_by') ?>

        <?php // echo $form->field($model, 'params') ?>

        <?php // echo $form->field($model, 'metadesc') ?>

        <?php // echo $form->field($model, 'metakey') ?>

        <?php // echo $form->field($model, 'robots') ?>

        <?php // echo $form->field($model, 'author') ?>

        <?php // echo $form->field($model, 'copyright') ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('traits', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton(Yii::t('traits', 'Reset'), ['class' => 'btn btn-default']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
