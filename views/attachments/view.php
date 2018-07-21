<?php

/**
 * @var $model cinghie\articles\models\Attachments
 */

use yii\widgets\DetailView;

// Set Title and Breadcrumbs
$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;

// Register action buttons js
$this->registerJs('$(document).ready(function() 
    {'
	.$model->getUpdateButtonJavascript('#w1')
	.$model->getDeleteButtonJavascript('#w1').
	'});
');

?>

<div class="row">

    <!-- action menu -->
    <div class="col-md-6">

		<?= Yii::$app->view->renderFile(\Yii::$app->controller->module->tabMenu) ?>

    </div>

    <!-- action buttons -->
    <div class="col-md-6">

	    <?= $model->getExitButton() ?>

		<?= $model->getDeleteButton() ?>

		<?= $model->getUpdateButton() ?>

		<?= $model->getCreateButton() ?>

    </div>

</div>

<div class="separator"></div>

<div class="attachments-view">
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'item_id',
            'filename',
            'title',
            'titleAttribute:ntext',
            'hits',
        ],
    ]) ?>

</div>
