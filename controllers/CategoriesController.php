<?php

/**
 * @copyright Copyright &copy;2014 Giandomenico Olini
 * @company Gogodigital - Wide ICT Solutions 
 * @website http://www.gogodigital.it
 * @package yii2-articles
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 */

namespace cinghie\articles\controllers;

use Yii;
use cinghie\articles\models\Categories;
use cinghie\articles\models\CategoriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class CategoriesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
					'deleteImage' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Categories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoriesSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Categories model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Categories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Categories;

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
		{		
			// Upload Image and Thumb if is not Null
			$imagepath   = \Yii::getAlias('@webroot').Yii::$app->controller->module->categoryimagepath;
			$thumbpath   = \Yii::getAlias('@webroot').Yii::$app->controller->module->categorythumbpath;
			$imgnametype = Yii::$app->controller->module->categoryimgname;
			$imgname     = $model->name;
			
			$file = \yii\web\UploadedFile::getInstance($model, 'image');
			
			// If is set an image, update it
			if ($file->name != "")
			{ 
				$filename = $this->uploadCatImage($file,$imagepath,$thumbpath,$imgname,$imgnametype);
				$model->image = $filename;	
			}
			
			// If alias is not set, generate it
			if ($_POST['Categories']['alias']=="") 
			{
				$model->alias = $this->generateAlias($model->name,"url");
			}
			
			// Save changes
			$model->save();	
				
			Yii::$app->session->setFlash('success', \Yii::t('articles.message', 'Category has been saved!'));
            return $this->redirect([
				'view', 'id' => $model->id,
			]);
        } else {
			//Yii::$app->session->setFlash('error', 'Model could not be saved');
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Categories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
		{
		
			// Upload Image and Thumb if is not Null
			$imagepath   = \Yii::getAlias('@webroot').Yii::$app->controller->module->categoryimagepath;
			$thumbpath   = \Yii::getAlias('@webroot').Yii::$app->controller->module->categorythumbpath;
			$imgnametype = Yii::$app->controller->module->categoryimgname;
			$imgname     = $model->name;
			
			$file = \yii\web\UploadedFile::getInstance($model, 'image');
			
			// If is set an image update it, else show the image and the button to remove it
			if ($file->name != "")
			{ 
				$filename = $this->uploadCatImage($file,$imagepath,$thumbpath,$imgname,$imgnametype);
				$model->image = $filename;	
			}
			
			// If alias is not set, generate it
			if ($_POST['Categories']['alias']=="") 
			{
				$model->alias = $this->generateAlias($model->name,"url");
			}
			
			// Save changes
			$model->save();	
			
			// Set Message
			Yii::$app->session->setFlash('success', \Yii::t('articles.message', 'Category has been updated!'));
			//Yii::$app->session->setFlash('success', var_dump($model));
			//Yii::$app->session->setFlash('success', var_dump($file));
			
            return $this->redirect([
				'view', 'id' => $model->id
			]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Categories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		
		Yii::$app->session->setFlash('success', \Yii::t('articles.message', 'Category has been deleted!'));
        return $this->redirect(['index']);
    }
	
	/* Delete the Image from the Categories model */
	public function actionDeleteimage($id) {
		$model = $this->findModel($id);
		
		if ($model->deleteImage()) {
			Yii::$app->session->setFlash('success', 
		   \Yii::t('articles.message', 'The image was removed successfully! Now, you can upload another by clicking Browse in the Image Tab.'));
		} else {
			Yii::$app->session->setFlash('error', 
		   \Yii::t('articles.message', 'Error removing image. Please try again later or contact the system admin.'));
		}
		
		return $this->redirect([
				'update', 'id' => $model->id,
		]);
	}

    /**
     * Finds the Categories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Categories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categories::findOne($id)) !== null) 
		{
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	// Upload Image in a select Folder
	protected function uploadCatImage($file,$imagepath,$thumbpath,$imgname,$imgnametype)
	{
		
		$type = $file->type;
		$type = str_replace("image/","",$type);
		$size = $file->size;
		
		switch($imgnametype) 
		{
			case "original":
				$name = $this->generateAlias($file->name,"img");
				break;
			
			case "casual":
				$name = uniqid(rand(), true).".".$type;
				break;
			
			default:
				$name = $this->generateAlias($imgname,"img").".".$type;
				break;
		}
		
		// Save the file in the Image Folder
		$path = $imagepath.$name;
		$file->saveAs($path);	
		
		return $name;
	}
	
	// Generate URL or IMG alias
	protected function generateAlias($name,$type)
    {
        // remove any '-' from the string they will be used as concatonater
        $str = str_replace('-', ' ', $name);
        $str = str_replace('_', ' ', $name);

        // remove any duplicate whitespace, and ensure all characters are alphanumeric
		if($type == "img") 
		{
        	$str = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('_',''), $str);
		}
		else 
		{
			$str = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('-',''), $str);
		}

        // lowercase and trim
        $str = trim(strtolower($str));
		
        return $str;
    }
	
}
