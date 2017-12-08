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

namespace cinghie\articles\models;

use Yii;
use kartik\widgets\Select2;
use yii\base\InvalidParamException;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * Superclass for Yii2 Articles Module
 *
 * @property array $categoriesSelect2
 * @property array $itemsSelect2
 * @property array $tagsIDByItemID
 * @property array $tagsSelect2
 */
class Articles extends ActiveRecord
{

    /**
     * Generate Ordering Form Widget
     *
     * @param \kartik\widgets\ActiveForm $form
     *
     * @return \kartik\form\ActiveField
     */
    public function getOrderingWidget($form)
    {
        $orderingSelect = ['0' => Yii::t('articles', 'In Development')];

        /** @var $this \yii\base\Model */
        return $form->field($this, 'ordering')->widget(Select2::className(), [
            'data' => $orderingSelect,
            'options' => [
                'disabled' => 'disabled'
            ],
            'addon' => [
                'prepend' => [
                    'content'=>'<i class="glyphicon glyphicon-sort"></i>'
                ]
            ],
        ]);
    }

	/**
	 * Generate Tags Form Widget
	 *
	 * @param \kartik\widgets\ActiveForm $form
	 *
	 * @return string
	 */
    public function getTagsWidget($form)
    {
    	return $form->field($this, 'tags')->widget(Select2::className(), [
		    'name' => 'tags',
		    'data' => $this->getTagsSelect2(),
		    'options' => [
			    'placeholder' => Yii::t('articles','Select Tags'),
			    'multiple' => true
		    ],
		    'pluginOptions' => [
			    'tags' => true,
		    ],
		    //'value' => $this->getTagsIDByItemID()
	    ]);
    }

	/**
	 * Upload file to folder
	 *
	 * @param $fileName
	 * @param $fileNameType
	 * @param $filePath
	 * @param $fileField
	 *
	 * @return UploadedFile|bool
	 * @throws \yii\base\Exception
	 */
    public function uploadFile($fileName,$fileNameType,$filePath,$fileField)
    {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $file = UploadedFile::getInstance($this, $fileField);

        // if no file was uploaded abort the upload
        if ($file === null) {
            return false;
        }

	    // set fileName by fileNameType
	    switch($fileNameType)
	    {
		    case 'original':
			    $name = $file->baseName; // get original file name
			    break;
		    case 'casual':
			    $name = Yii::$app->security->generateRandomString(); // generate a unique file name
			    break;
		    default:
			    $name = $fileName; // get item title like filename
			    break;
	    }

	    // file extension
	    $fileExt = $file->extension;
	    // purge filename
	    $fileName = $name;
	    // set field to filename.extensions
	    $this->$fileField = $fileName.".{$fileExt}";
	    // update file->name
	    $file->name = $fileName.".{$fileExt}";
	    // save images to imagePath
	    $file->saveAs($filePath.$fileName.".{$fileExt}");

	    // the uploaded file instance
	    return $file;
    }

    /**
     * Create Thumb Images files
     *
     * @param $image
     * @param $imagePath
     * @param $imgOptions
     * @param $thumbPath
     *
     * @return mixed the uploaded image instance
     * @throws \Imagine\Exception\RuntimeException
     */
	public function createThumbImages($image,$imagePath,$imgOptions,$thumbPath)
	{	
		$imageName = $image->name;
		$imageLink = $imagePath.$image->name;

        // Check thumbPath exist, else create
        $this->createDirectory($thumbPath);
		
		// Save Image Thumbs
		Image::thumbnail($imageLink, $imgOptions['small']['width'], $imgOptions['small']['height'])
			->save( $thumbPath . 'small/' . $imageName, [ 'quality' => $imgOptions['small']['quality']]);
		Image::thumbnail($imageLink, $imgOptions['medium']['width'], $imgOptions['medium']['height'])
			->save( $thumbPath . 'medium/' . $imageName, [ 'quality' => $imgOptions['medium']['quality']]);
		Image::thumbnail($imageLink, $imgOptions['large']['width'], $imgOptions['large']['height'])
			->save( $thumbPath . 'large/' . $imageName, [ 'quality' => $imgOptions['large']['quality']]);
		Image::thumbnail($imageLink, $imgOptions['extra']['width'], $imgOptions['extra']['height'])
			->save( $thumbPath . 'extra/' . $imageName, [ 'quality' => $imgOptions['extra']['quality']]);

		return true;
	}

    /**
     * Creating directory to save file if not exist
     *
     * @param string $path file to create
     */
    protected function createDirectory($path)
    {
        $sizes = array(
            'small',
            'medium',
            'large',
            'extra',
        );

        foreach($sizes as $size) {
            if(!file_exists($path.$size)) {
                mkdir($path.$size, 0755, true);
            }
        }
    }

    /**
     * Get Items by Category ID
     *
     * @param integer $cat_id
     * @param string $order
     *
     * @return Items[]
     */
    public function getItemsByCategory($cat_id,$order = 'title')
    {
        $items = Items::find()
            ->where(['cat_id' => $cat_id])
            ->andWhere(['state' => 1])
            ->andWhere(['or',['language' => 'All'],['SUBSTRING(language,1,2)' => Yii::$app->language]])
            ->orderBy($order)
            ->all();

        return $items;
    }

    /**
     * Return array for Category Select2
     *
     * @return array
     */
    public function getCategoriesSelect2()
    {
	    $categories = Categories::find()->orderBy('name')->all();

        $array[''] = Yii::t('articles', 'No Parent');

        foreach($categories as $category) {
	        $array[$category['id']] = $category['name'];
        }

        return $array;
    }

	/**
	 * Return array with all Items
     *
	 * @return array
	 */
	public function getItemsSelect2()
	{
        $array = array();

        $items = Items::find()
            ->select(['id','title'])
            ->all();

		foreach($items as $item) {
			$array[$item['id']] = $item['title'];
		}

		return $array;
	}

    /**
     * Return array with all Tags
     *
     * @return array
     */
    public function getTagsSelect2()
    {
        $array = array();

        $tags = Tags::find()
            ->select(['id','name'])
            ->orderBy('name')
            ->all();

        foreach($tags as $tag) {
            $array[$tag['name']] = $tag['name'];
        }

        return $array;
    }

    /**
     * Get Tags by Item ID
     *
     * return Integer[]
     */
    public function getTagsIDByItemID()
    {
        $array = array();

        $tagsAssign = Tagsassign::find()
            ->where(['item_id' => $this->id])
            ->all();

        foreach($tagsAssign as $tagAssign) {
        	$tag_name = Tags::find()->select(['name'])->where(['id' => $tagAssign['tag_id']])->one()->name;
            $array[] = $tag_name;
        }

        return $array;
    }

	/**
	 * Return date formatted with Module option dateFormat
	 *
	 * @param $date
	 *
	 * @return string
	 * @throws InvalidConfigException
	 * @throws InvalidParamException
	 */
	public function getDateFormatted($date) {
		return Yii::$app->formatter->asDatetime($date, 'php:' . Yii::$app->controller->module->dateFormat);
	}

	/**
	 * Generate URL alias by string
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public function generateAlias($string)
	{
		// remove any '-' from the string they will be used as concatonater
		$string = str_replace(array('-','_'), ' ', $string);

		// remove any duplicate whitespace, and ensure all characters are alphanumeric
		$string = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('-',''), $string);

		// lowercase and trim
		$string = strtolower(trim($string));

		return $string;
	}

    /**
     * Generate JSON for Params
     *
     * @param $params
     * @return string json encoded
     */
    public function generateJsonParams($params) {
        return json_encode($params);
    }

	/**
	 * Return params json decoded
	 *
	 * @param $params
	 * @param $param
	 *
	 * @return mixed
	 */
	public function getOption($params,$param)
	{
		$params = json_decode($params);

		return $params->$param;
	}

}
