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
     * Upload file
     * @param $fileName
     * @param $fileNameType
     * @param $filePath
     * @param $fileField
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
     * createThumbImages files
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
	}

    /**
     * Generate fileName
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
	 * Generate URL alias
     * @param $name
	 * @return string alias
	 */
	public function generateAlias($name)
    {
        // remove any '-' from the string they will be used as concatonater
		$str = str_replace('-', ' ', $name);
        $str = str_replace('_', ' ', $str);
		
		// remove any duplicate whitespace, and ensure all characters are alphanumeric
		$str = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('-',''), $str);

        // lowercase and trim
        $str = trim(strtolower($str));
		
        return $str;
    }

	/*
	 * Get lang code like en
	 * @return string lang
	 */
	public function getLang() {
		return substr($this->language,0,2);
	}

	/*
	 * Get lang tag like en-GB
	 * @return string lang
	 */
	public function getLangTag() {
		return $this->language;
	}

	/**
	 * Generate JSON for Params
     * @param $params
	 * @return string json encoded
	 */
	public function generateJsonParams($params) {
		return json_encode($params);
	}

	/**
	 * Active the item setting state = 1
	 * @return bool
	 */
	public function publish()
	{
		return (bool)$this->updateAttributes([
			'state' => 1
		]);
	}

	/**
	 * Inactive the item setting state = 0
	 * @return bool
	 */
	public function unpublish()
	{
		return (bool)$this->updateAttributes([
			'state' => 0
		]);
	}

	/**
	 * Return array for User Select2 with current user selected
     * @param $userid
     * @param $username
	 * @return array
	 */
	public function getUsersSelect2($userid,$username)
	{
        $users = User::find()
            ->select(['id','username'])
            ->where(['blocked_at' => null, 'unconfirmed_email' => null])
            ->andWhere(['!=', 'id', $userid])
            ->all();

		$array[$userid] = ucwords($username);

		foreach($users as $user) {
			$array[$user['id']] = ucwords($user['username']);
		}

		return $array;
	}

	/**
	 * Return array with all Items
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
	 * Return an array with the user roles
	 * @return array
	 */
	public function getRoles()
	{
		$roles = Yii::$app->authManager->getRoles();
		$array = ['public' => 'Public'];

		foreach($roles as $role) {
			$array[ucwords($role->name)] = ucwords($role->name);
		}

		return $array;
	}

	/**
	 * Return an array with languages
	 * @return array
	 */
	public function getLanguagesSelect2()
	{
		$languages = Yii::$app->controller->module->languages;
		$languagesSelect = array('All' => Yii::t('articles', 'All'));

		if($languages)
		{
			foreach($languages as $language) {
				$languagesSelect[$language] = ucwords($language);
			}
		}

		return $languagesSelect;
	}

	/**
	 * Return param
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
