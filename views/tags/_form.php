<?php

/**
 * @var $form kartik\widgets\ActiveForm
 * @var $model cinghie\articles\models\Tags
 * @var $this yii\web\View
 */

use cinghie\articles\assets\ArticlesAsset;
use kartik\widgets\ActiveForm;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles[ArticlesAsset::class];

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
