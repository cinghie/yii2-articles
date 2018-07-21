<?php

use cinghie\articles\models\AttachmentsSearch;
use cinghie\articles\models\CategoriesSearch;
use cinghie\articles\models\ItemsSearch;
use cinghie\articles\models\TagsSearch;

$this->title = Yii::t('articles', 'Dashboard');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Yii::$app->view->renderFile(\Yii::$app->controller->module->tabMenu) ?>

<div class="site-index">

	<?php if( file_exists(Yii::getAlias('@vendor/cinghie/yii2-admin-lte/AdminLTEAsset.php')) || file_exists(Yii::getAlias('@vendor/cinghie/yii2-admin-lte/AdminLTEMinifyAsset.php')) ): ?>

        <?= $this->render('_dashboard_adminlte', [
                'attachSearch' => new AttachmentsSearch(),
                'categoriesSearch' => new CategoriesSearch(),
                'itemsSearch' => new ItemsSearch(),
                'tagsSearch' => new TagsSearch(),
        ]) ?>

    <?php else: ?>

	    <?= $this->render('_dashboard_default', [
		    'attachSearch' => new AttachmentsSearch(),
		    'categoriesSearch' => new CategoriesSearch(),
		    'itemsSearch' => new ItemsSearch(),
		    'tagsSearch' => new TagsSearch(),
	    ]) ?>

    <?php endif ?>

</div>
