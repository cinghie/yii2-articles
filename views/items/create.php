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

$this->title = Yii::t('articles.message', 'Create Article', ['modelClass' => 'Items',]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles.message', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="items-create">

    <div class="page-header">
    	<h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
