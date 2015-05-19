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

namespace cinghie\articles\models;

use Yii;
use yii\imagine\Image;
use yii\web\UploadedFile;

class Articles extends \yii\db\ActiveRecord
{
	
	/**
    * Upload file
    * @return mixed the uploaded image instance
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
			$fileExt = end((explode(".", $file->name)));
			// purge filename
			$fileName = $this->generateFileName($name);
			// set field to filename.extensions
			$this->$fileField = $fileName.".{$fileExt}";
			// update file->name
			$file->name  = $fileName.".{$fileExt}";
			// save images to imagePath
			$file->saveAs($filePath.$fileName.".{$fileExt}");
	 
			// the uploaded file instance
			return $file;
		
		}
    }

	/**
    * createThumbImages files
    * @return mixed the uploaded image instance
    */
	public function createThumbImages($image,$imagePath,$imgOptions,$thumbPath)
	{	
		$imageName = $image->name;
		$imageLink = $imagePath.$image->name;
		
		// Save Image Thumbs
		Image::thumbnail($imageLink, $imgOptions['small']['width'], $imgOptions['small']['height'])
			->save($thumbPath."small/".$imageName, ['quality' => $imgOptions['small']['quality']]);
		Image::thumbnail($imageLink, $imgOptions['medium']['width'], $imgOptions['medium']['height'])
			->save($thumbPath."medium/".$imageName, ['quality' => $imgOptions['medium']['quality']]);
		Image::thumbnail($imageLink, $imgOptions['large']['width'], $imgOptions['large']['height'])
			->save($thumbPath."large/".$imageName, ['quality' => $imgOptions['large']['quality']]);
		Image::thumbnail($imageLink, $imgOptions['extra']['width'], $imgOptions['extra']['height'])
			->save($thumbPath."extra/".$imageName, ['quality' => $imgOptions['extra']['quality']]);		
	}
	
	/**
	* Generate fileName
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
	* Generate URL alias
	* @return string alias
	*/ 
	public function generateAlias($name)
    {
        // remove any '-' from the string they will be used as concatonater
        $str = str_replace('-', ' ', $name);
        $str = str_replace('_', ' ', $name);
		
		// remove any duplicate whitespace, and ensure all characters are alphanumeric
		$str = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('-',''), $str);

        // lowercase and trim
        $str = trim(strtolower($str));
		
        return $str;
    }
	
	/**
	* Generate JSON for Params
	* @return string json encoded
	*/ 
	public function generateJsonParams($params)
	{
		return json_encode($params);
	}

}