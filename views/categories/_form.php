<?php

/**
 * @var $form kartik\widgets\ActiveForm
 * @var $model cinghie\articles\models\Categories
 * @var $this yii\web\View
 */

use cinghie\articles\assets\ArticlesAsset;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

?>

<div class="categories-form">

    <?php $form = ActiveForm::begin([
		'options' => [
			'enctype'=>'multipart/form-data'
		],
	]); ?>
	
        <div class="row">

            <div class="col-lg-12">

                <div class="bs-example bs-example-tabs">

                    <!-- Tab Control -->
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#item">
                                <?= Yii::t('articles', 'Category') ?>
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#seo">
                                <?= Yii::t('articles', 'SEO') ?>
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#image">
                                <?= Yii::t('articles', 'Image') ?>
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#params">
                                <?= Yii::t('articles', 'Options') ?>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Contents -->
                    <div class="tab-content" id="myTabContent">

                        <div class="separator"></div>

                        <!-- Item -->
                        <div id="item" class="row tab-pane fade active in">

                            <div class="col-lg-8">

                                <div class="row">

                                    <div class="col-md-6">

                                        <?= $model->getNameWidget($form) ?>

                                    </div> <!-- col-md-6 -->

                                    <div class="col-md-6">

                                        <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
                                            'data' => $model->getCategoriesSelect2(),
                                            'addon' => [
                                                'prepend' => [
                                                    'content'=>'<i class="glyphicon glyphicon-folder-open"></i>'
                                                ]
                                            ],
                                        ]); ?>

                                    </div> <!-- col-md-6 -->

                                </div> <!-- row -->

                                <?= $model->getEditorWidget($form,'description') ?>

                            </div> <!-- col-lg-8 -->

                            <div class="col-lg-4">

                                <?= $model->getStateWidget($form) ?>

                                <?= $model->getAccessWidget($form) ?>

                                <?= $model->getLanguageWidget($form) ?>

                                <?= $form->field($model, 'theme')->widget(Select2::classname(), [
                                    'data' => $model->getThemesSelect2(),
                                    'addon' => [
                                        'prepend' => [
                                            'content'=>'<i class="glyphicon glyphicon-blackboard"></i>'
                                        ]
                                    ],
                                ]); ?>

                                <?= $model->getOrderingWidget($form) ?>

                            </div> <!-- col-lg-4 -->

                        </div> <!-- #item -->

                        <!-- SEO -->
                        <div id="seo" class="row  tab-pane fade">

                            <div class="col-lg-5">

                                <?= $model->getAliasWidget($form) ?>

                                <?= $model->getRobotsWidget($form) ?>

                                <?= $model->getAuthorWidget($form) ?>

                                <?= $model->getCopyrightWidget($form) ?>

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

                        </div> <!-- #seo -->

                        <!-- Image -->
                        <div id="image" class="row tab-pane fade">

                            <p class="bg-info">
                                <?= Yii::t('articles', 'Allowed Extensions')?>: <?= Yii::$app->controller->module->imageType ?>
                            </p>

                            <div class="col-lg-6">

                                <?= $form->field($model, 'image')->widget(FileInput::classname(), [
                                        'options' => [
                                            'accept' => 'image/'.Yii::$app->controller->module->imageType
                                        ],
                                        'pluginOptions' => [
                                            'previewFileType' => 'image',
                                            'showUpload'      => false,
                                            'browseLabel'     => Yii::t('articles', 'Browse &hellip;'),
                                        ],
                                ]); ?>

                                <?php if ( isset($model->image) && !empty($model->image) ): ?>

                                <div class="thumbnail">
                                    <img alt="200x200" class="img-thumbnail" data-src="holder.js/300x250" style="width: 300px;" src="<?= $model->getImageUrl() ?>">
                                    <div class="caption">
                                        <p></p>
                                        <p>
                                            <?= Html::a(Yii::t('articles', 'Delete Image'), ['deleteimage', 'id' => $model->id], [
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
                                ])->textarea(['rows' => 6]) ?>

                                <?= $form->field($model, 'image_credits', [
                                    'addon' => [
                                        'prepend' => [
                                            'content'=>'<i class="glyphicon glyphicon-barcode"></i>'
                                        ]
                                    ]
                                ])->textInput(['maxlength' => 255]) ?>

                            </div> <!-- col-lg-6 -->

                        </div> <!-- #image -->

                        <!-- Params -->
                        <div id="params" class="row tab-pane fade">

                            <!-- Categories View -->
                            <div class="col-md-4">

                                <h4><?= Yii::t('articles', 'Categories View')?></h4>

                                <?php

                                    // Categories Image Width
                                    echo '<div class="form-group field-categories-categoriesImageWidth">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Image Width').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoriesImageWidth',
                                        'data' => [
                                            'small'  => Yii::t('articles', 'Small'),
                                            'medium' => Yii::t('articles', 'Medium'),
                                            'large'  => Yii::t('articles', 'Large'),
                                            'extra'  => Yii::t('articles', 'Extra')
                                        ],
                                    ]);
                                    echo '</div>';

                                    echo '<hr>';

                                    // Show Intro Text
                                    echo '<div class="form-group field-categories-categoriesIntroText">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show IntroText').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoriesIntroText',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    // Show Intro Text
                                    echo '<div class="form-group field-categories-categoriesFullText">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show FullText').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoriesFullText',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    echo '<hr>';

                                    // Show Categories Data Created
                                    echo '<div class="form-group field-categories-categoriesCreatedData">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show Created Data').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoriesCreatedData',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    // Categories Data Modified
                                    echo '<div class="form-group field-categories-categoriesModifiedData">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show Modified Data').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoriesModifiedData',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    // Category User
                                    echo '<div class="form-group field-categories-categoriesUser">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show User').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoriesUser',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    // Category Hits
                                    echo '<div class="form-group field-categories-categoriesHits">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show Hits').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoriesHits',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    echo '<hr>';

                                    // Categories Item Debug
                                    echo '<div class="form-group field-categories-categoriesDebug">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show Debug').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoriesDebug',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                ?>

                            </div> <!-- col-md-4 -->

                            <!-- Category View -->
                            <div class="col-md-4">

                                <h4><?= Yii::t('articles', 'Category View')?></h4>

                                <?php

                                    // Category Image Width
                                    echo '<div class="form-group field-categories-categoryImageWidth">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Image Width').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoryImageWidth',
                                        'data' => [
                                            'small'  => Yii::t('articles', 'Small'),
                                            'medium' => Yii::t('articles', 'Medium'),
                                            'large'  => Yii::t('articles', 'Large'),
                                            'extra'  => Yii::t('articles', 'Extra')
                                        ],
                                    ]);
                                    echo '</div>';

                                    echo '<hr>';

                                    // Show Intro Text
                                    echo '<div class="form-group field-categories-categoryIntroText">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show IntroText').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoryIntroText',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    // Show Intro Text
                                    echo '<div class="form-group field-categories-categoryFullText">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show FullText').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoryFullText',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    echo '<hr>';

                                    // Category Data Created
                                    echo '<div class="form-group field-categories-categoryCreatedData">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show Created Data').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoryCreatedData',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    // Category Data Modified
                                    echo '<div class="form-group field-categories-categoryModifiedData">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show Modified Data').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoryModifiedData',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    // Category User
                                    echo '<div class="form-group field-categories-categoryUser">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show User').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoryUser',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    // Category Hits
                                    echo '<div class="form-group field-categories-categoryHits">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show Hits').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoryHits',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    echo '<hr>';

                                    // Category Item Debug
                                    echo '<div class="form-group field-categories-categoryDebug">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show Debug').'</label>';
                                    echo Select2::widget([
                                        'name' => 'categoryDebug',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                ?>

                            </div> <!-- col-md-4 -->

                            <!-- Item View -->
                            <div class="col-md-4">

                                <h4><?= Yii::t('articles', 'Item View')?></h4>

                                <?php

                                    // Item Image Width
                                    echo '<div class="form-group field-categories-itemImageWidth">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Image Width').'</label>';
                                    echo Select2::widget([
                                        'name' => 'itemImageWidth',
                                        'data' => [
                                            'small'  => Yii::t('articles', 'Small'),
                                            'medium' => Yii::t('articles', 'Medium'),
                                            'large'  => Yii::t('articles', 'Large'),
                                            'extra'  => Yii::t('articles', 'Extra')
                                        ],
                                    ]);
                                    echo '</div>';

                                    echo '<hr>';

                                    // Show Intro Text
                                    echo '<div class="form-group field-categories-itemIntroText">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show IntroText').'</label>';
                                    echo Select2::widget([
                                        'name' => 'itemIntroText',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    // Show Intro Text
                                    echo '<div class="form-group field-categories-itemFullText">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show FullText').'</label>';
                                    echo Select2::widget([
                                        'name' => 'itemFullText',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    echo '<hr>';

                                    // Show Data Created
                                    echo '<div class="form-group field-categories-itemCreatedData">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show Created Data').'</label>';
                                    echo Select2::widget([
                                        'name' => 'itemCreatedData',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    // Show Data Modified
                                    echo '<div class="form-group field-categories-itemModifiedData">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show Modified Data').'</label>';
                                    echo Select2::widget([
                                        'name' => 'itemModifiedData',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    // Item User
                                    echo '<div class="form-group field-categories-itemUser">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show User').'</label>';
                                    echo Select2::widget([
                                        'name' => 'itemUser',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    // Category Hits
                                    echo '<div class="form-group field-categories-itemHits">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show Hits').'</label>';
                                    echo Select2::widget([
                                        'name' => 'itemHits',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                    echo '<hr>';

                                    // Show Debug
                                    echo '<div class="form-group field-categories-itemDebug">';
                                    echo '<label class="control-label">'.Yii::t('articles', 'Show Debug').'</label>';
                                    echo Select2::widget([
                                        'name' => 'itemDebug',
                                        'data' => [
                                            'No' => Yii::t('articles','No'),
                                            'Yes' => Yii::t('articles','Yes')
                                        ],
                                    ]);
                                    echo '</div>';

                                ?>

                            </div> <!-- col-md-4 -->

                        </div> <!-- #params -->

                    </div> <!-- tab-content -->

                </div> <!-- bs-example -->

                <div class="row">

                    <div class="col-lg-12">

                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ?  Yii::t('traits', 'Create') : Yii::t('traits', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>

                    </div>

                </div> <!-- row -->

            </div> <!-- col-lg-12 -->

        </div> <!-- row -->

    <?php ActiveForm::end(); ?>

</div>
