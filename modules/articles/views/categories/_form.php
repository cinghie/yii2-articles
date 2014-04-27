<?php

use yii\helpers\Html;

// Load Kartik Libraries
use kartik\widgets\ActiveField;
use kartik\widgets\Select2;
use kartik\widgets\DateTimePicker;
use kartik\widgets\FileInput;

?>

<div class="categories-form">

    <?php // Init Form
    use kartik\widgets\ActiveForm;
    $form = kartik\widgets\ActiveForm::begin([
		'id' => 'articles-categories-form',
		'enableAjaxValidation' => true,
		'fieldConfig' => [
			'autoPlaceholder'=>true
		]
    ]);
	?>
    
    <div class="row">
    	
        <div class="col-lg-8">
        
        	 <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
             
             <?= $form->field($model, 'alias')->textInput(['maxlength' => 255]) ?>

    		 <?= $form->field($model, 'description')->textarea(['rows' => 10]) ?>
             
             <?= $form->field($model, 'metadesc')->textarea(['rows' => 3]) ?>

    		 <?= $form->field($model, 'metakey')->textarea(['rows' => 1]) ?>
        
        </div>
        
        <div class="col-lg-4">
        
        	<?= $form->field($model, 'parent')->widget(Select2::classname(), [
					'data' => array_merge(["0" => "Nessun Genitore"]),
					'pluginOptions' => [
						'allowClear' => true
					],
				]); ?>
            
            <?= $form->field($model, 'published')->widget(Select2::classname(), [
					'data' => array_merge(["1" => "Pubblicato"],["0" => "Non Pubblicato"],["-1" => "Cestinato"]),
					'pluginOptions' => [
						'allowClear' => true
					],
				]); ?>
                
            <?= $form->field($model, 'access')->widget(Select2::classname(), [
					'data' => array_merge(["0" => "Accesso Pubblico"]),
					'pluginOptions' => [
						'allowClear' => true
					],
				]); ?>

    		<?= $form->field($model, 'ordering')->textInput() ?>
            
            <?= $form->field($model, 'language')->textInput(['maxlength' => 7]) ?>
            
            <?= FileInput::widget([
					'name' => 'image',
					'options' => ['multiple' => true],
					'pluginOptions' => ['previewFileType' => 'any']
				]);?>
            
            <?= $form->field($model, 'image')->textInput(['maxlength' => 255]) ?>

    		<?= $form->field($model, 'image_caption')->textarea(['rows' => 4]) ?>

    		<?= $form->field($model, 'image_credits')->textInput(['maxlength' => 255]) ?>
        
        </div>
        
    </div>

    <?= $form->field($model, 'params')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
