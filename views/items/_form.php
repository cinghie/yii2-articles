<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 1.0
*/

use yii\helpers\Html;
use cinghie\articles\assets\ArticlesAsset;

// Load Kartik Libraries
use kartik\widgets\ActiveForm;
use kartik\widgets\ActiveField;
use kartik\widgets\DateTimePicker;
use kartik\widgets\FileInput;
use kartik\widgets\InputWidget;
use kartik\widgets\Select2;

// Load Editors Libraries
use dosamigos\ckeditor\CKEditor;
use dosamigos\tinymce\TinyMce;
use kartik\markdown\MarkdownEditor;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

// Get info For the Select2 Categories 
if ($model->id) { $id = $_REQUEST['id']; } else { $id = 0; }
$select2categories = $model->getCategoriesSelect2($id);

// Get Username
if (!$model->isNewRecord && $model->modified_by) { 
	$modified_by = $model->modified_by; 
} else { 
	$modified_by = 0; 
}

// Get info by Configuration
$editor           = Yii::$app->controller->module->editor;
$language         = substr(Yii::$app->language,0,2);
$languages        = Yii::$app->controller->module->languages;
$imagetype        = Yii::$app->controller->module->imageType;

$select2users     = $model->getUsersSelect2();
$select2videotype = $model->getVideoTypeSelect2();

?>

<div class="items-form">

    <?php $form = ActiveForm::begin([
		'options' => [
			'enctype'=>'multipart/form-data'
		],
	]); ?>
    
    <div class="row">
    
    	<div class="col-lg-12">
    
            <div class="bs-example bs-example-tabs">
                
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                    	<a data-toggle="tab" href="#item"><?= Yii::t('articles.message', 'Article') ?></a>
                    </li>
                    <li class="">
                    	<a data-toggle="tab" href="#seo"><?= Yii::t('articles.message', 'SEO') ?></a>
                    </li>
                    <li class="">
                    	<a data-toggle="tab" href="#image"><?= Yii::t('articles.message', 'Image') ?></a>
                    </li>
                    <li class="">
                    	<a data-toggle="tab" href="#video"><?= Yii::t('articles.message', 'Video') ?></a>
                    </li>
                    <li class="">
                    	<a data-toggle="tab" href="#params"><?= Yii::t('articles.message', 'Options') ?></a>
                    </li>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    
                    <div class="separator"></div>
                    
                    <div id="item" class="tab-pane fade active in">
                    
                        <div class="col-lg-5">
                    
                            <?= $form->field($model, 'title', [
								'addon' => [
									'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-plus"></i>'
										]
								]
							])->textInput(['maxlength' => true]) ?>
                                
                            
                            <?= $form->field($model, 'catid')->widget(Select2::classname(), [
								'data' => $select2categories,
								'pluginOptions' => [
									'allowClear' => true
								],
								'addon' => [
									'prepend' => [
										'content'=>'<i class="glyphicon glyphicon-folder-open"></i>'
									]
								],
							]); ?>
                            
                            <?= $form->field($model, 'published')->widget(Select2::classname(), [
                                    'data' => [
										1 => Yii::t('articles.message', 'Published'),
										0 => Yii::t('articles.message', 'Unpublished'),
									],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-question-sign"></i>'
										]
									],
                            ]); ?>
                            
                            <?= $form->field($model, 'access')->widget(Select2::classname(), [
                                    'data' => ["0" => Yii::t('articles.message', 'In Development') ],
									'options' => [
										'disabled' => 'disabled'
									],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-log-in"></i>'
										]
									],
                            ]); ?>
                        
                        </div> <!-- end col-lg-5 -->
                        
                        <div class="col-lg-4">
                        
                        	<?php if ($model->isNewRecord): ?>
                        
								<?php echo $form->field($model, 'created')->widget(DateTimePicker::classname(), [
                                        'options' => [
                                            'value' => date("Y-m-d H:i:s"),    
                                        ],
                                        'pluginOptions' => [
                                            'autoclose'      => true,
                                            'format'         => 'yyyy-mm-dd hh:ii:ss',
                                            'todayHighlight' => true,
                                        ]
                                ]); ?>
                                
                            <?php else : ?>
                            
                            	<?php echo $form->field($model, 'created')->widget(DateTimePicker::classname(), [
                                        'options' => [
											'disabled' => 'disabled',
                                            'value'    => $model->created,    
                                        ],
                                        'pluginOptions' => [
                                            'autoclose'      => true,
                                            'format'         => 'yyyy-mm-dd hh:ii:ss',
                                            'todayHighlight' => true,
                                        ]
                                ]); ?>
                            
                            <?php endif; ?>
                            
                            <?= $form->field($model, 'language')->widget(Select2::classname(), [
                                    'data' => $languages,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-globe"></i>'
										]
									],
                            ]); ?>   
                            
                            <?= $form->field($model, 'userid')->widget(Select2::classname(), [
									'data' => $select2users,
									'pluginOptions' => [
										'allowClear' => true
									],
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-user"></i>'
										]
									],
							]); ?>
                            
                            <?= $form->field($model, 'ordering')->widget(Select2::classname(), [
                                    'data' => [ 
										"0" =>  Yii::t('articles.message', 'In Development') 
									],
									'options' => [
										'disabled' => 'disabled',
									],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-sort"></i>'
										]
									],
                            ]); ?>
                        
                        </div> <!-- end col-lg-4 -->
                        
                        <div class="col-lg-3">
                                                       
                            <?php if ($model->isNewRecord): ?>
                        
								<?php echo $form->field($model, 'modified')->widget(DateTimePicker::classname(), [
                                        'options' => [
											'disabled' => 'disabled',
                                            'value'    => date("Y-m-d H:i:s"),    
                                        ],
                                        'pluginOptions' => [
                                            'autoclose'      => true,
                                            'format'         => 'yyyy-mm-dd hh:ii:ss',
                                            'todayHighlight' => true,
                                        ]
                                ]); ?>
                                
                            <?php else: ?>
                            
                            	<?php echo $form->field($model, 'modified')->widget(DateTimePicker::classname(), [
                                        'options' => [
											'disabled' => 'disabled',
                                            'value'    => $model->modified,    
                                        ],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'format'    => 'yyyy-mm-dd hh:ii:ss',
                                        ]
                                ]); ?>
                            
                            <?php endif ?>                            
                            
                            <?= $form->field($model, 'created_by')->widget(Select2::classname(), [
								'data' => [ 
									0 =>  Yii::t('articles.message', 'In Development') 
								],
								'options' => [
									'disabled' => 'disabled'
								],
								'pluginOptions' => [
									'allowClear' => true
								],
								'addon' => [
									'prepend' => [
										'content'=>'<i class="glyphicon glyphicon-user"></i>'
									]
								],
							]); ?>
                            
                            <?= $form->field($model, 'modified_by')->widget(Select2::classname(), [
								'data' => [ 
									0 =>  Yii::t('articles.message', 'In Development') 
								],
								'options' => [
									'disabled' => 'disabled'
								],
								'pluginOptions' => [
									'allowClear' => true
								],
								'addon' => [
									'prepend' => [
										'content'=>'<i class="glyphicon glyphicon-user"></i>'
									]
								],
							]); ?>
                            
                            <?php if ($model->isNewRecord): ?>
						
                            <?= $form->field($model, 'hits')->widget(Select2::classname(), [
                                    'data' => [
										"0" => "0" 
									],
									'options' => [
										'disabled' => 'disabled'
									],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-eye-open"></i>'
										]
									],
                            ]); ?>
                            
                            <?php else : ?>
                            
                            <?= $form->field($model, 'hits')->widget(Select2::classname(), [
                                    'data' => [ 
										$model->hits => $model->hits 
									],
									'options' => [
										'disabled' => 'disabled'
									],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-eye-open"></i>'
										]
									],
                            ]); ?>
                            
                            <?php endif ?>
                        
                        </div> <!-- end col-lg-3 -->
                        
                        <div class="col-lg-6">
                        
                        	<?php if ($editor=="ckeditor"): ?>
                            	<?= $form->field($model, 'introtext')->widget(CKEditor::className(), 
									[
										'options' => ['rows' => 4],
										'preset' => 'advanced'
								]); ?>
                            <?php elseif ($editor=="tinymce"): ?>
                            	<?= $form->field($model, 'introtext')->widget(TinyMce::className(), [
										'options' => ['rows' => 12],
										'clientOptions' => [
											'plugins' => [
												"advlist autolink lists link charmap print preview anchor",
												"searchreplace visualblocks code fullscreen",
												"insertdatetime media table contextmenu paste"
											],			
											'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
										]
								]); ?>
                            <?php elseif ($editor=="markdown"): ?>
                            	<?= $form->field($model, 'introtext')->widget(
										MarkdownEditor::classname(),
										['height' => 150, 'encodeLabels' => true]
								); ?>
                            <?php elseif ($editor=="imperavi"): ?>
                            	<?= $form->field($model, 'introtext')->widget(yii\imperavi\Widget::className(), [
								
									// Some options, see http://imperavi.com/redactor/docs/
									'options' => [
										'css' => 'wym.css',
									],
								]); ?>
                            <?php else: ?>
                            	<?= $form->field($model, 'introtext')->textarea(['rows' => 12]); ?>
                            <?php endif ?>
                        
                        </div> <!-- end col-lg-6 -->
                        
                        <div class="col-lg-6">
                        
                        	<?php if ($editor=="ckeditor"): ?>
                            	<?= $form->field($model, 'fulltext')->widget(CKEditor::className(), 
									[
										'options' => ['rows' => 6],
										'preset' => 'advanced'
								]); ?>
                            <?php elseif ($editor=="tinymce"): ?>
                            	<?= $form->field($model, 'fulltext')->widget(TinyMce::className(), [
										'options' => ['rows' => 12],
										'clientOptions' => [
											'plugins' => [
												"advlist autolink lists link charmap print preview anchor",
												"searchreplace visualblocks code fullscreen",
												"insertdatetime media table contextmenu paste"
											],			
											'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
										]
								]); ?>
                            <?php elseif ($editor=="markdown"): ?>
                            	<?= $form->field($model, 'fulltext')->widget(
										MarkdownEditor::classname(),
										['height' => 150, 'encodeLabels' => true]
								); ?>
                            <?php elseif ($editor=="imperavi"): ?>
                            	<?= $form->field($model, 'fulltext')->widget(yii\imperavi\Widget::className(), [
								
									// Some options, see http://imperavi.com/redactor/docs/
									'options' => [
										'css' => 'wym.css',
									],
								]); ?>
                            <?php else: ?>
                            	<?= $form->field($model, 'fulltext')->textarea(['rows' => 12]); ?>
                            <?php endif ?>
                        
                        </div> <!-- end col-lg-6 -->
                    
                    </div> <!-- end #item -->
                    
                    <div id="seo" class="tab-pane fade">
                    
                    	<div class="col-lg-5">
                            
                            <?= $form->field($model, 'alias', [
							 		'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-bookmark"></i>'
										]
									]
							] )->textInput(['maxlength' => 255]) ?>
							
                            <?= $form->field($model, 'robots')->widget(Select2::classname(), [
                                    'data' => [ 
										"index, follow"       => "index, follow", 
										"no index, no follow" => "no index, no follow", 
										"no index, follow"    => "no index, follow", 
										"index, no follow"    => "index, no follow" 
									],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-globe"></i>'
										]
									]
                            ]); ?>   
                            
							<?= $form->field($model, 'author', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-user"></i>'
										]
									]
							])->textInput(['maxlength' => true]) ?>

   							<?= $form->field($model, 'copyright', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-ban-circle"></i>'
										]
									]
							])->textInput(['maxlength' => true]) ?>
						
                        </div> <!-- col-lg-5 -->
                        
                        <div class="col-lg-7">

							<?= $form->field($model, 'metadesc', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-info-sign"></i>'
										]
									]
								])->textarea(['rows' => 4]) ?>
                            
                            <?= $form->field($model, 'metakey', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-tags"></i>'
										]
									]
								])->textarea(['rows' => 4]) ?>
                        
                        </div> <!-- col-lg-7 -->
                    
                    </div> <!-- seo -->
                    
                    <div id="image" class="tab-pane fade">
                    
                    	<p class="bg-info">
							<?= Yii::t('articles.message', 'Allowed Extensions')?>: <?= $imagetype ?>
                        </p>
                        
                        <div class="col-lg-6">
                        
                        	<?= $form->field($model, 'image')->widget(FileInput::classname(), [
                                	'options' => [
                                    	'accept' => 'image/'.$imagetype
                                    ],
                                    'pluginOptions' => [
                                        'previewFileType' => 'image',
                                        'showUpload'      => false,
                                        'browseLabel'     => Yii::t('articles.message', 'Browse &hellip;'),
                                    ],
                            ]); ?> 
                            
                            <?php if ( isset($model->image) && !empty($model->image) ): ?>
                            
                            <div class="thumbnail">                       	
                            	<img alt="200x200" class="img-thumbnail" data-src="holder.js/300x250" style="width: 300px;" src="<?= $model->getImageUrl() ?>">
                            	<div class="caption">
                            		<p></p>
                            	    <p>
										<?= Html::a(Yii::t('articles.message', 'Delete Image'), ['deleteimage', 'id' => $model->id], [
                                                'class' => 'btn btn-danger',
                                                'data' => [
                                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                                ],
										]) ?>
                            	    </p>
                            	</div>
                            </div>
                            
                            <?php endif ?>
                        
                        </div> <!-- col-lg-6 -->
                        
                        <div class="col-lg-6">
                        
                        	<?= $form->field($model, 'image_caption', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-picture"></i>'
										]
									 ]
							])->textarea(['maxlength' => true,'rows' => 6]) ?>
                            
                            <?= $form->field($model, 'image_credits', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-barcode"></i>'
										]
									]
							])->textInput(['maxlength' => true]) ?>
                        
                        </div> <!-- col-lg-6 -->
                    
                    </div> <!-- #image -->
                    
                    <div id="video" class="tab-pane fade">
                    
                    	<div class="col-lg-6">
                        
                        	<?= $form->field($model, 'video', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-film"></i>'
										]
									]
							])->textInput(['maxlength' => true]) ?>
                        
                        	<?= $form->field($model, 'video_type')->widget(Select2::classname(), [
                                    'data' => $select2videotype,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-film"></i>'
										]
									],
                            ]); ?>   
                            
                        </div> <!-- end col-lg-6 -->
                        
                        <div class="col-lg-6">
                            
                            <?= $form->field($model, 'video_caption', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-facetime-video"></i>'
										]
									 ]
							])->textarea(['maxlength' => 255,'rows' => 6]) ?>
                            
                            <?= $form->field($model, 'video_credits', [
									'addon' => [
										'prepend' => [
											'content'=>'<i class="glyphicon glyphicon-barcode"></i>'
										]
									]
							])->textInput(['maxlength' => 255]) ?>
                            
                        </div> <!-- end col-lg-6 -->
                    
                    </div> <!-- end video -->
                    
                    <div id="params" class="tab-pane fade">
                    	
                        <?= $form->field($model, 'params')->textarea(['rows' => 6]) ?>
                    
                    </div> <!-- #params -->
            
            </div> <!-- end bs-example-tabs -->
            
        </div> <!-- col-lg-12 -->
    
    </div> <!-- end row -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ?  Yii::t('articles.message', 'Save & Exit') : Yii::t('articles.message', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
