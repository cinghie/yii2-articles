<?php

use kartik\widgets\Select2;

?>

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
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
                ],
            ]);
            echo '</div>';

            // Show Intro Text
            echo '<div class="form-group field-categories-categoriesFullText">';
            echo '<label class="control-label">'.Yii::t('articles', 'Show FullText').'</label>';
            echo Select2::widget([
                'name' => 'categoriesFullText',
                'data' => [
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
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
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
                ],
            ]);
            echo '</div>';

            // Categories Data Modified
            echo '<div class="form-group field-categories-categoriesModifiedData">';
            echo '<label class="control-label">'.Yii::t('articles', 'Show Modified Data').'</label>';
            echo Select2::widget([
                'name' => 'categoriesModifiedData',
                'data' => [
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
                ],
            ]);
            echo '</div>';

            // Category User
            echo '<div class="form-group field-categories-categoriesUser">';
            echo '<label class="control-label">'.Yii::t('articles', 'Show User').'</label>';
            echo Select2::widget([
                'name' => 'categoriesUser',
                'data' => [
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
                ],
            ]);
            echo '</div>';

            // Category Hits
            echo '<div class="form-group field-categories-categoriesHits">';
            echo '<label class="control-label">'.Yii::t('articles', 'Show Hits').'</label>';
            echo Select2::widget([
                'name' => 'categoriesHits',
                'data' => [
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
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
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
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
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
                ],
            ]);
            echo '</div>';

            // Show Intro Text
            echo '<div class="form-group field-categories-categoryFullText">';
            echo '<label class="control-label">'.Yii::t('articles', 'Show FullText').'</label>';
            echo Select2::widget([
                'name' => 'categoryFullText',
                'data' => [
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
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
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
                ],
            ]);
            echo '</div>';

            // Category Data Modified
            echo '<div class="form-group field-categories-categoryModifiedData">';
            echo '<label class="control-label">'.Yii::t('articles', 'Show Modified Data').'</label>';
            echo Select2::widget([
                'name' => 'categoryModifiedData',
                'data' => [
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
                ],
            ]);
            echo '</div>';

            // Category User
            echo '<div class="form-group field-categories-categoryUser">';
            echo '<label class="control-label">'.Yii::t('articles', 'Show User').'</label>';
            echo Select2::widget([
                'name' => 'categoryUser',
                'data' => [
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
                ],
            ]);
            echo '</div>';

            // Category Hits
            echo '<div class="form-group field-categories-categoryHits">';
            echo '<label class="control-label">'.Yii::t('articles', 'Show Hits').'</label>';
            echo Select2::widget([
                'name' => 'categoryHits',
                'data' => [
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
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
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
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
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
                ],
            ]);
            echo '</div>';

            // Show Intro Text
            echo '<div class="form-group field-categories-itemFullText">';
            echo '<label class="control-label">'.Yii::t('articles', 'Show FullText').'</label>';
            echo Select2::widget([
                'name' => 'itemFullText',
                'data' => [
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
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
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
                ],
            ]);
            echo '</div>';

            // Show Data Modified
            echo '<div class="form-group field-categories-itemModifiedData">';
            echo '<label class="control-label">'.Yii::t('articles', 'Show Modified Data').'</label>';
            echo Select2::widget([
                'name' => 'itemModifiedData',
                'data' => [
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
                ],
            ]);
            echo '</div>';

            // Item User
            echo '<div class="form-group field-categories-itemUser">';
            echo '<label class="control-label">'.Yii::t('articles', 'Show User').'</label>';
            echo Select2::widget([
                'name' => 'itemUser',
                'data' => [
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
                ],
            ]);
            echo '</div>';

            // Category Hits
            echo '<div class="form-group field-categories-itemHits">';
            echo '<label class="control-label">'.Yii::t('articles', 'Show Hits').'</label>';
            echo Select2::widget([
                'name' => 'itemHits',
                'data' => [
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
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
                    'No' => Yii::t('traits','No'),
                    'Yes' => Yii::t('traits','Yes')
                ],
            ]);
            echo '</div>';

        ?>

    </div> <!-- col-md-4 -->