<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.1
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
	 * @return array
	 */
	public function getUsersSelect2($userid,$username)
	{
		$sql   = 'SELECT id,username FROM {{%user}} WHERE id != '.$userid;
		$users = Items::findBySql($sql)->asArray()->all();

		$array[$userid] = ucwords($username);

		foreach($users as $user) {
			$array[$user['id']] = ucwords($user['username']);
		}

		return $array;
	}

	/**
	 * Return array for User Select2 with current user selected
	 * @return string
	 */
	public function getArticlesSelect2()
	{
		$sql   = 'SELECT id,title FROM {{%article_items}}';
		$items = Items::findBySql($sql)->asArray()->all();

		foreach($items as $item) {
			$array[$item['id']] = $item['title'];
		}

		return $array;
	}

	/**
	 * Return Username by UserID
	 * @return string
	 */
	public function getUsernameByUserID($id)
	{
		$sql      = 'SELECT username FROM {{%user}} WHERE id='.$id;
		$username = Items::findBySql($sql)->asArray()->one();

		return $username['username'];
	}

	/**
	 * Return an array with the user roles
	 * @return array
	 */
	public function getRoles()
	{
		$sql   = 'SELECT name FROM {{%auth_item}} WHERE type = 1 ORDER BY name ASC';
		$roles = Categories::findBySql($sql)->asArray()->all();
		$array = ['public' => 'Public'];

		foreach($roles as $role) {
			$array[ucwords($role['name'])] = ucwords($role['name']);
		}

		return $array;
	}

	/**
	 * Return languages Select
	 * @return array
	 */
	public function getLanguagesSelect2()
	{
		$languages = Yii::$app->urlManager->languages;
		$languagesSelect = array('All' => Yii::t('essentials', 'All'));

		if($languages)
		{
			foreach($languages as $language) {
				$languagesSelect[$language] = ucwords($language);
			}
		}

		return $languagesSelect;
	}

}
