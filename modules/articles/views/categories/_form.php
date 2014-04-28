<?php

use yii\helpers\Html;

// Load Kartik Libraries
use kartik\widgets\ActiveForm;
use kartik\widgets\ActiveField;
use kartik\widgets\Select2;
use kartik\widgets\DateTimePicker;
use kartik\widgets\FileInput;

/**
 * @var yii\web\View $this
 * @var app\modules\articles\models\Categories $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
    
    	<div class="col-lg-12">
    
            <div class="bs-example bs-example-tabs">
            
                <ul class="nav nav-tabs" id="myTab">
                  <li class="active"><a data-toggle="tab" href="#item">Item</a></li>
                  <li class=""><a data-toggle="tab" href="#image">Image</a></li>
                  <li class=""><a data-toggle="tab" href="#seo">SEO</a></li>
                  <li class=""><a data-toggle="tab" href="#params">Params</a></li>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    
                    <div id="item" class="tab-pane fade active in">
                    
                        <div class="col-lg-8">
            
                            <?= $form->field($model, 'name', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-plus"></i>']]] )->textInput(['maxlength' => 255]) ?>
                
                            <?= $form->field($model, 'alias', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-bookmark"></i>']]] )->textInput(['maxlength' => 255]) ?>
                            
                            <?= $form->field($model, 'description', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-pencil"></i>']]] )->textarea(['rows' => 10]) ?>
                
                        </div> <!-- col-lg-8 -->
            
                        <div class="col-lg-4">
                        
                            <?= $form->field($model, 'parent')->widget(Select2::classname(), [
								'data' => array_merge(["0" => "No Parent"]),
								'pluginOptions' => [
									'allowClear' => true
								],
								'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-folder-open"></i>']],
							]); ?>
						
							<?= $form->field($model, 'published')->widget(Select2::classname(), [
                                    'data' => array_merge(["1" => "Published"],["0" => "Unpublished"],["-1" => "Trashed"]),
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-question-sign"></i>']],
                                ]); ?>
                                
                            <?= $form->field($model, 'access')->widget(Select2::classname(), [
                                    'data' => array_merge(["0" => "Public Access"]),
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-log-in"></i>']],
                                ]); ?>
                            
                            <?php if ($model->isNewRecord){ ?>
                            <?= $form->field($model, 'ordering')->widget(Select2::classname(), [
                                    'data' => array_merge([ "0" => "Automatic" ]),
									'options' => [
										'disabled' => 'disabled'
									],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-sort"></i>']],
                                ]); ?>
                            <?php } else { ?>
                            <?= $form->field($model, 'ordering')->widget(Select2::classname(), [
                                    'data' => array_merge([ "0" => "Automatic" ]),
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-sort"></i>']],
                                ]); ?>
                            <?php } ?>
                            
                            <?= $form->field($model, 'language')->widget(Select2::classname(), [
                                    'data' => array_merge(["0" => "en-GB"],["1" => "us-US"],["2" => "it-IT"],["3" => "es-ES"],["4" => "fr-FR"]),
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-globe"></i>']],
                                ]); ?>           
                            
                        </div> <!-- col-lg-4 -->
                        
                    </div> <!-- #item -->
                    
                    <div id="image" class="tab-pane fade">
                    
                    	<div class="col-lg-6">
                    
							<?= $form->field($model, 'image')->widget(FileInput::classname(), [
									'options' => ['accept' => 'image/*'],
								]);?>
                            
                            <?= $form->field($model, 'image_credits', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-barcode"></i>']]])->textInput(['maxlength' => 255]) ?>
                        
                        </div> <!-- col-lg-6 -->
                        
                        <div class="col-lg-6">
		
							<?= $form->field($model, 'image_caption', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-picture"></i>']]])->textarea(['rows' => 6]) ?>
            
            			</div> <!-- col-lg-6 -->
                        
                            
                    </div> <!-- #image -->
                    
                    <div id="seo" class="tab-pane fade">
                    
                    	<div class="col-lg-6">
                        
                        	<?= $form->field($model, 'metadesc', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-info-sign"></i>']]] )->textarea(['rows' => 3]) ?>
                        
                        </div> <!-- col-lg-6 -->
                        
                        <div class="col-lg-6">

    		 				<?= $form->field($model, 'metakey', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-tags"></i>']]] )->textarea(['rows' => 3]) ?>
                        
                        </div> <!-- col-lg-6 -->
                        
                    </div> <!-- #seo -->
                    
                    <div id="params" class="tab-pane fade">
                        
                        <?= $form->field($model, 'params')->textarea(['rows' => 6]) ?>  
                         
                    </div> <!-- #params -->
                  
               </div> <!-- tab-content -->
               
            </div> <!-- bs-example -->
    
    	</div> <!-- col-lg-12 -->
        
    </div> <!-- row -->  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save & Exit') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
