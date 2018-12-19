<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.5
*/

namespace cinghie\articles;

use Yii;
use dektrium\user\models\User;
use yii\base\InvalidParamException;
use yii\base\Module;
use yii\i18n\PhpMessageSource;

class Articles extends Module
{
    // Select User Class
	public $userClass = User::class;

	// Select Article Languages
	public $languages = [ 'en-GB' => 'en-GB' ];

	// Select Article Language for all other languages
	public $languageAll = 'en-GB';

	// Set Google Translate API KEY
	public $googleTranslateApiKey = '';

    // Select Date Format
    public $dateFormat = 'd F Y';

	// Select Editor: no-editor, ckeditor, imperavi, tinymce, markdown
	public $editor = 'ckeditor';

	// Select Path To Upload Category Image
	public $categoryImagePath = '@webroot/img/articles/categories/';

	// Select URL To Upload Category Image
	public $categoryImageURL = '@web/img/articles/categories/';

	// Select Path To Upload Category Thumb
	public $categoryThumbPath = '@webroot/img/articles/categories/thumb/';

	// Select URL To Upload Category Image
	public $categoryThumbURL = '@web/img/articles/categories/thumb/';

	// Select Path To Upload Item Image
	public $itemImagePath = '@webroot/img/articles/items/';

	// Select URL To Upload Item Image
	public $itemImageURL = '@web/img/articles/items/';

	// Select Path To Upload Item Thumb
	public $itemThumbPath = '@webroot/img/articles/items/thumb/';

	// Select URL To Upload Item Thumb
	public $itemThumbURL = '@web/img/articles/items/thumb/';

	// Select Image Name: categoryname, original, casual
	public $imageNameType = 'categoryname';

	// Select Image Types allowed
	public $imageType = ['png','jpg','jpeg'];

	// Select Path To Upload Attachments
	public $attachPath = '@webroot/attachments/';

	// Select URL To Upload Attachment
	public $attachURL = '@web/attachments/';

	// Select Attachment Types allowed
	public $attachType = ['jpg','jpeg','gif','png','csv','pdf','txt','doc','docs'];

	// Active AdvancedTranslation
	public $advancedTranslation = true;

	// Tab Menu Source
	public $tabMenu = '@vendor/cinghie/yii2-articles/views/default/_menu.php';

	// Filter Language Default
	public $filterLanguageDefault = 'en';

	// Show Titles in the views
	public $showTitles = true;

	// Slugify Options
	public $slugifyOptions = [
		'separator' => '-',
		'lowercase' => true,
		'trim' => true,
		'rulesets'  => [
			'default'
		]
	];

	// Thumbnails Options
	public $thumbOptions =	[ 
		'small'  => ['quality' => 100, 'width' => 200, 'height' => 150],
		'medium' => ['quality' => 100, 'width' => 300, 'height' => 200],
		'large'  => ['quality' => 100, 'width' => 400, 'height' => 300],
		'extra'  => ['quality' => 100, 'width' => 600, 'height' => 400],
	];

	// Url Rules
	public $urlRules = [
		'<id:\d+>/<alias:[A-Za-z0-9 -_.]+>' => 'articles/categories/view',
		'<cat>/<id:\d+>/<alias:[A-Za-z0-9 -_.]+>' => 'articles/items/view',
		'<tags>/<id:\d+>/<alias:[A-Za-z0-9 -_.]+>' => 'articles/tags/view',
	];

	/**
	 * @inheritdoc
	 *
	 * @throws InvalidParamException
	 */
    public function init()
    {
        parent::init();
		$this->registerTranslations();
        $this->setupImageDirectory();
        Yii::$container->set($this->userClass);
    }

	/**
	 * Translating module message
	 */
	public function registerTranslations()
    {
		if (!isset(Yii::$app->i18n->translations['articles*'])) 
		{
			Yii::$app->i18n->translations['articles*'] = [
				'class' => PhpMessageSource::class,
				'basePath' => __DIR__ . '/messages',
			];
		}
    }

	/**
	 * Setup image directory if it's not exist yet
	 *
	 * @throws InvalidParamException
	 */
    protected function setupImageDirectory()
    {
        if(!file_exists(Yii::getAlias($this->categoryImagePath))) {
	        if ( ! mkdir( Yii::getAlias( $this->categoryImagePath ), 0755, true ) && ! is_dir( Yii::getAlias( $this->categoryImagePath ) ) ) {
		        throw new \RuntimeException( sprintf( 'Directory "%s" was not created', Yii::getAlias( $this->categoryImagePath ) ) );
	        }
        }

        if(!file_exists(Yii::getAlias($this->categoryThumbPath))) {
	        if ( ! mkdir( Yii::getAlias( $this->categoryThumbPath ), 0755, true ) && ! is_dir( Yii::getAlias( $this->categoryThumbPath ) ) ) {
		        throw new \RuntimeException( sprintf( 'Directory "%s" was not created', Yii::getAlias( $this->categoryThumbPath ) ) );
	        }
        }

        if(!file_exists(Yii::getAlias($this->itemImagePath))) {
	        if ( ! mkdir( Yii::getAlias( $this->itemImagePath ), 0755, true ) && ! is_dir( Yii::getAlias( $this->itemImagePath ) ) ) {
		        throw new \RuntimeException( sprintf( 'Directory "%s" was not created', Yii::getAlias( $this->itemImagePath ) ) );
	        }
        }

        if(!file_exists(Yii::getAlias($this->itemThumbPath))) {
	        if ( ! mkdir( Yii::getAlias( $this->itemThumbPath ), 0755, true ) && ! is_dir( Yii::getAlias( $this->itemThumbPath ) ) ) {
		        throw new \RuntimeException( sprintf( 'Directory "%s" was not created', Yii::getAlias( $this->itemThumbPath ) ) );
	        }
        }

        if(!file_exists(Yii::getAlias($this->attachPath))) {
	        if ( ! mkdir( Yii::getAlias( $this->attachPath ), 0755, true ) && ! is_dir( Yii::getAlias( $this->attachPath ) ) ) {
		        throw new \RuntimeException( sprintf( 'Directory "%s" was not created', Yii::getAlias( $this->attachPath ) ) );
	        }
        }
    }

}
