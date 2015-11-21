<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.4.0
*/

namespace cinghie\articles\controllers;

use Yii;
use cinghie\articles\models\Items;
use cinghie\articles\models\ItemsSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * ItemsController implements the CRUD actions for Items model.
 */
class ItemsController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','create','update','delete','deleteimage'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['?', '@']
                    ],
                ],
                'denyCallback' => function () {
                    throw new \Exception('You are not allowed to access this page');
                }
            ],
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
     * Lists all Items models.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionIndex()
    {
        // Check RBAC Permission
        if($this->userCanIndex())
        {
            $searchModel = new ItemsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Displays a single Items model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionView($id)
    {
        // Check RBAC Permission
        if($this->userCanView())
        {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Items model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionCreate()
    {
        // Check RBAC Permission
        if($this->userCanCreate())
        {
            $model = new Items();

            if ( $model->load(Yii::$app->request->post()) )
            {
                // Set Modified as actual date
                $model->modified = "0000-00-00 00:00:00";

                // If alias is not set, generate it
                if ($_POST['Items']['alias']=="")
                {
                    $model->alias = $model->generateAlias($model->title);
                }

                // Upload Image and Thumb if is not Null
                $imagePath   = Yii::getAlias(Yii::$app->controller->module->itemImagePath);
                $thumbPath   = Yii::getAlias(Yii::$app->controller->module->itemThumbPath);
                $imgNameType = Yii::$app->controller->module->imageNameType;
                $imgOptions  = Yii::$app->controller->module->thumbOptions;
                $imgName     = $model->title;
                $fileField   = "image";

                // Create UploadFile Instance
                $image = $model->uploadFile($imgName,$imgNameType,$imagePath,$fileField);

                if ($model->save()) {

                    // upload only if valid uploaded file instance found
                    if ($image !== false)
                    {
                        // save thumbs to thumbPaths
                        $model->createThumbImages($image,$imagePath,$imgOptions,$thumbPath);
                    }

                    // Set Success Message
                    Yii::$app->session->setFlash('success', Yii::t('articles', 'Item has been created!'));

                    return $this->redirect(['index']);

                } else {

                    // Set Error Message
                    Yii::$app->session->setFlash('error', Yii::t('articles', 'Item could not be saved!'));

                    return $this->render('create', ['model' => $model,]);
                }

            } else {

                return $this->render('create', ['model' => $model,]);
            }
        } else {
            throw new ForbiddenHttpException;
        }
			
    }

    /**
     * Updates an existing Items model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        // Check RBAC Permission
        if($this->userCanUpdate())
        {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {

                // Set Modified as actual date
                $model->modified = date("Y-m-d H:i:s");

                // Set Modified by User
                $model->modified_by = Yii::$app->user->identity->id;

                // If alias is not set, generate it
                if ($_POST['Items']['alias'] == "") {
                    $model->alias = $model->generateAlias($model->title);
                }

                // Upload Image and Thumb if is not Null
                $imagePath = Yii::getAlias(Yii::$app->controller->module->itemImagePath);
                $thumbPath = Yii::getAlias(Yii::$app->controller->module->itemThumbPath);
                $imgNameType = Yii::$app->controller->module->imageNameType;
                $imgOptions = Yii::$app->controller->module->thumbOptions;
                $imgName = $model->title;
                $fileField = "image";

                // Create UploadFile Instance
                $image = $model->uploadFile($imgName, $imgNameType, $imagePath, $fileField);

                if ($model->save()) {

                    // upload only if valid uploaded file instance found
                    if ($image !== false) {
                        // save thumbs to thumbPaths
                        $thumb = $model->createThumbImages($image, $imagePath, $imgOptions, $thumbPath);
                    }

                    // Set Success Message
                    Yii::$app->session->setFlash('success', Yii::t('articles', 'Item has been updated!'));

                    return $this->redirect(['index']);

                } else {

                    // Set Error Message
                    Yii::$app->session->setFlash('error', Yii::t('articles', 'Item could not be saved!'));

                    return $this->render('update', ['model' => $model,]);
                }

            } else {

                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Items model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        // Check RBAC Permission
        if($this->userCanDelete())
        {
            $model = $this->findModel($id);

            if ($model->delete()) {
                if (!$model->deleteImage() && !empty($model->image)) {
                    Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting image'));
                } else {
                    Yii::$app->session->setFlash('success', Yii::t('articles', 'Item has been deleted!'));
                }
            } else {
                Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting image'));
            }

            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException;
        }
    }
	
	/**
     * Deletes an existing Items Image.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
	public function actionDeleteimage($id) 
	{
        // Check RBAC Permission
        if($this->userCanUpdate())
        {
            $model = $this->findModel($id);

            if ($model->deleteImage()) {
                $model->image = "";
                $model->save();
                Yii::$app->session->setFlash('success', Yii::t('articles', 'The image was removed successfully! Now, you can upload another by clicking Browse in the Image Tab.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('articles', 'Error removing image. Please try again later or contact the system admin.'));
            }

            return $this->redirect([
                'update', 'id' => $model->id,
            ]);
        } else {
            throw new ForbiddenHttpException;
        }
	}

    /**
     * Finds the Items model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Items the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Items::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Check if user can Index Articles
     * @return bool
     */
    protected function userCanIndex()
    {
        if( Yii::$app->user->can('index-all-articles') || Yii::$app->user->can('index-his-articles'))
            return true;
        else
            return false;
    }

    /**
     * Check if user can view Articles
     * @return bool
     */
    protected function userCanView()
    {
        if( Yii::$app->user->can('view-articles') )
            return true;
        else
            return false;
    }

    /**
     * Check if user can create Articles
     * @return bool
     */
    protected function userCanCreate()
    {
        if( Yii::$app->user->can('create-articles') )
            return true;
        else
            return false;
    }

    /**
     * Check if user can update Articles
     * @return bool
     */
    protected function userCanUpdate()
    {
        if( Yii::$app->user->can('update-articles') )
            return true;
        else
            return false;
    }

    /**
     * Check if user can delete Articles
     * @return bool
     */
    protected function userCanDelete()
    {
        if( Yii::$app->user->can('delete-all-articles') )
            return true;
        else
            return false;
    }

}
