<?php

use yii\helpers\Html;

// Load Kartik Libraries
use kartik\widgets\ActiveForm;
use kartik\widgets\ActiveField;
use kartik\widgets\Select2;
use kartik\widgets\DateTimePicker;
use kartik\widgets\FileInput;
use kartik\markdown\MarkdownEditor;

// Get info For the Select2 Categories 
$select2categories = $model->getCategoriesSelect2();

?>

<div class="categories-form">

    <?php $form = ActiveForm::begin([
		'options' => [
			'enctype'=>'multipart/form-data',
		]
	]); ?>
    
    <div class="row">
    
    	<div class="col-lg-12">
    
            <div class="bs-example bs-example-tabs">
            
                <ul class="nav nav-tabs" id="myTab">
                  <li class="active"><a data-toggle="tab" href="#item"><?= \Yii::t('articles.message', 'Category') ?></a></li>
                  <li class=""><a data-toggle="tab" href="#image"><?= \Yii::t('articles.message', 'Image') ?></a></li>
                  <li class=""><a data-toggle="tab" href="#seo">SEO</a></li>
                  <li class=""><a data-toggle="tab" href="#params"><?= \Yii::t('articles.message', 'Options') ?></a></li>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    
                    <div id="item" class="tab-pane fade active in">
                    
                        <div class="col-lg-8">
            
                            <?= $form->field($model, 'name', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-plus"></i>']]] )->textInput(['maxlength' => 255]) ?>
                            
                            <?= $form->field($model, 'description')->widget(
									MarkdownEditor::classname(),
									['height' => 250, 'encodeLabels' => true]
								);
//$form->field($model, 'description', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-pencil"></i>']]] )->textarea(['rows' => 12]) ?>
                
                        </div> <!-- col-lg-8 -->
            
                        <div class="col-lg-4">
                        
                            <?= $form->field($model, 'parent')->widget(Select2::classname(), [
								'data' => $select2categories,
								'pluginOptions' => [
									'allowClear' => true
								],
								'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-folder-open"></i>']],
							]); ?>
						
							<?= $form->field($model, 'published')->widget(Select2::classname(), [
                                    'data' => array_merge(["1" => \Yii::t('articles.message', 'Published')],["0" => \Yii::t('articles.message', 'Unpublished')],["-1" => \Yii::t('articles.message', 'Trashed')]),
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-question-sign"></i>']],
                                ]); ?>
                                
                            <?= $form->field($model, 'access')->widget(Select2::classname(), [
                                    'data' => array_merge(["0" => \Yii::t('articles.message', 'Public Access') ]),
									'options' => [
										'disabled' => 'disabled'
									],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-log-in"></i>']],
                                ]); ?>
                            
                            <?php if ($model->isNewRecord){ ?>
                            <?= $form->field($model, 'ordering')->widget(Select2::classname(), [
                                    'data' => array_merge([ "0" =>  \Yii::t('articles.message', 'Automatic') ]),
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
                                    'data' => array_merge([ "0" =>  \Yii::t('articles.message', 'Automatic') ]),
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-sort"></i>']],
                                ]); ?>
                            <?php } ?>
                            
                            <?= $form->field($model, 'language')->widget(Select2::classname(), [
                                    'data' => array_merge(Yii::$app->controller->module->languages),
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
                        
                        </div> <!-- col-lg-6 -->
                        
                        <div class="col-lg-6">
		
							<?= $form->field($model, 'image_caption', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-picture"></i>']]])->textarea(['rows' => 6]) ?>
                            
                            <?= $form->field($model, 'image_credits', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-barcode"></i>']]])->textInput(['maxlength' => 255]) ?>
            
            			</div> <!-- col-lg-6 -->
                        
                            
                    </div> <!-- #image -->
                    
                    <div id="seo" class="tab-pane fade">
                    
                    	<div class="col-lg-5">
                        
                        	<?= $form->field($model, 'alias', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-bookmark"></i>']]] )->textInput(['maxlength' => 255]) ?>
							
                            <?= $form->field($model, 'robots')->widget(Select2::classname(), [
                                    'data' => array_merge(["index, follow" => "index, follow"],["no index, no follow" => "no index, no follow"],["no index, follow" => "no index, follow"],["index, no follow" => "index, no follow"]),
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-globe"></i>']],
                                ]); ?>   
                            
							<?= $form->field($model, 'author', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-user"></i>']]] )->textInput(['maxlength' => 50]) ?>

   							<?= $form->field($model, 'copyright', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-ban-circle"></i>']]] )->textInput(['maxlength' => 50]) ?>
						
                        </div> <!-- col-lg-5 -->
                        
                        <div class="col-lg-7">

							<?= $form->field($model, 'metadesc', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-info-sign"></i>']]] )->textarea(['rows' => 4]) ?>
                            
                            <?= $form->field($model, 'metakey', ['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-tags"></i>']]] )->textarea(['rows' => 4]) ?>
                        
                        </div> <!-- col-lg-7 -->
                        
                    </div> <!-- #seo -->
                    
                    <div id="params" class="tab-pane fade">
                        
                        <?= $form->field($model, 'params')->textarea(['rows' => 6]) ?>  
                         
                    </div> <!-- #params -->
                  
               </div> <!-- tab-content -->
               
            </div> <!-- bs-example -->
    
    	</div> <!-- col-lg-12 -->
        
    </div> <!-- row -->  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ?  \Yii::t('articles.message', 'Save & Exit') : \Yii::t('articles.message', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
