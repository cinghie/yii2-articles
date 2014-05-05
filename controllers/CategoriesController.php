<?php

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
			$this->uploadImage($model);
				
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
			$this->uploadCatImage($model);			
			
			Yii::$app->session->setFlash('success', \Yii::t('articles.message', 'Category has been updated!'));
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
	protected function uploadCatImage($model)
	{
		$imagepath = Yii::$app->controller->module->categoryimagepath;
		$thumbpath = Yii::$app->controller->module->categorythumbpath;
		
		$file = \yii\web\UploadedFile::getInstance($model, 'image');
		
		$type = $file->type;
		$type = str_replace("image/","",$type);
		$size = $file->size;
		$name = $model->name.".".$type;
		$path = $imagepath.$name;
		
		$model->image = $name;
		$model->save();
		
		$file->saveAs($path);
		
	}
	
}
