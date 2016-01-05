<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.0
*/

use yii\helpers\Html;

?>

<div class="yii2articles-admin-menu">

	<div class="row">

		<div class="col-md-12">

			<!-- Dashboard -->
			<?= Html::a('<i class="fa fa-bar-chart-o"></i> '.Yii::t('articles', 'Dashboard'), ['/articles/default'], [
				'class' => 'btn btn-default',
				'role'  => 'button'
			]) ?>

            <!-- Items -->
            <?= Html::a('<i class="fa fa-file-text-o"></i> '.Yii::t('articles', 'Articles'), ['/articles/items'], [
                'class' => 'btn btn-default',
                'role'  => 'button'
            ]) ?>

			<!-- Categories -->
			<?= Html::a('<i class="fa fa-folder-open"></i> '.Yii::t('articles', 'Categories'), ['/articles/categories'], [
				'class' => 'btn btn-default',
				'role'  => 'button'
			]) ?>

			<!-- Attachments -->
			<?= Html::a('<i class="fa fa-paperclip"></i> '.Yii::t('articles', 'Attachments'), ['/articles/attachments'], [
				'class' => 'btn btn-default',
				'role'  => 'button'
			]) ?>

		</div>

	</div>

</div>
