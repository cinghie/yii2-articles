<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.3
*/

namespace cinghie\articles\models;

use Yii;
use dektrium\user\models\User;
use yii\db\ActiveRecord;
use yii\imagine\Image;
use yii\web\UploadedFile;

class Articles extends ActiveRecord
{

    /**
     * Upload file to folder
     *
     * @param $fileName
     * @param $fileNameType
     * @param $filePath
     * @param $fileField
     * @return UploadedFile|bool
     */
    public function uploadFile($fileName,$fileNameType,$filePath,$fileField) 
	{
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $file = UploadedFile::getInstance($this, $fileField);
 
        // if no file was uploaded abort the upload
        if (empty($file)) {

            return false;

        } else {
  		
			// set fileName by fileNameType
			switch($fileNameType) 
			{
				case "original":
					// get original file name
					$name = $file->name;
					break;
				case "casual":
					// generate a unique file name
					$name = Yii::$app->security->generateRandomString();
					break;
				default:
					// get item title like filename
					$name = $fileName;
					break;
			}
			
			// file extension
			$fileExt  = $file->extension;
			// purge filename
			$fileName = $this->generateFileName($name);
			// set field to filename.extensions
			$this->$fileField = $fileName.".{$fileExt}";
			// update file->name
			$file->name = $fileName.".{$fileExt}";
			// save images to imagePath
			$file->saveAs($filePath.$fileName.".{$fileExt}");
	 
			// the uploaded file instance
			return $file;
		}
    }

    /**
     * Create Thumb Images files
     *
     * @param $image
     * @param $imagePath
     * @param $imgOptions
     * @param $thumbPath
     * @return mixed the uploaded image instance
     */
	public function createThumbImages($image,$imagePath,$imgOptions,$thumbPath)
	{	
		$imageName = $image->name;
		$imageLink = $imagePath.$image->name;

        // Check thumbPath exist, else create
        $this->createDirectory($thumbPath);
		
		// Save Image Thumbs
		Image::thumbnail($imageLink, $imgOptions['small']['width'], $imgOptions['small']['height'])
			->save($thumbPath."small/".$imageName, ['quality' => $imgOptions['small']['quality']]);
		Image::thumbnail($imageLink, $imgOptions['medium']['width'], $imgOptions['medium']['height'])
			->save($thumbPath."medium/".$imageName, ['quality' => $imgOptions['medium']['quality']]);
		Image::thumbnail($imageLink, $imgOptions['large']['width'], $imgOptions['large']['height'])
			->save($thumbPath."large/".$imageName, ['quality' => $imgOptions['large']['quality']]);
		Image::thumbnail($imageLink, $imgOptions['extra']['width'], $imgOptions['extra']['height'])
			->save($thumbPath."extra/".$imageName, ['quality' => $imgOptions['extra']['quality']]);

		return;
	}

    /**
     * Generate fileName
     *
     * @param $name
     * @return string fileName
     */
    public function generateFileName($name)
    {
        // remove any duplicate whitespace, and ensure all characters are alphanumeric
        $str = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('-',''), $name);

        // lowercase and trim
        $str = trim(strtolower($str));

        return $str;
    }

    /**
     * Get Items by Category ID
     *
     * @param integer $cat_id
     * @param string $order
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
	 * Generate JSON for Params
     *
     * @param $params
	 * @return string json encoded
	 */
	public function generateJsonParams($params) {
		return json_encode($params);
	}

    /**
     * Return array for Category Select2
     *
     * @return array
     */
    public function getCategoriesSelect2()
    {
        $categories = Categories::find()
            ->orderBy('name')
            ->all();

        $array[0] = Yii::t('articles', 'No Parent');

        foreach($categories as $category)
        {
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
	 * Return param
     *
     * @param $params
     * @param $param
	 * @return $param
	 */
	public function getOption($params,$param)
	{
		$params = json_decode($params);

		return $params->$param;
	}

    /**
     * Function for creating directory to save file
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

        foreach($sizes as $size)
        {
            if(!file_exists($path.$size))
            {
                mkdir($path.$size, 0755, true);
            }
        }
    }

}
