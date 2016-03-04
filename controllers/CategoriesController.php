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

namespace cinghie\articles\controllers;

use Yii;
use cinghie\articles\models\Categories;
use cinghie\articles\models\CategoriesSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class CategoriesController extends Controller
{

    public function behaviors()
    {
        return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
                        'allow' => true,
                        'actions' => ['index','create','update','delete','deleteimage','deletemultiple','changestate','activemultiple','deactivemultiple'],
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
                    'changestate' => ['post'],
                    'delete' => ['post'],
					'deleteImage' => ['post'],
                    'deletemultiple' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Categories models.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionIndex()
    {
		// Check RBAC Permission
		if($this->userCanIndex())
		{
			$searchModel  = new CategoriesSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

			return $this->render('index', [
				'searchModel'  => $searchModel,
				'dataProvider' => $dataProvider
			]);
		} else {
			throw new ForbiddenHttpException;
		}
    }

    /**
     * Displays a single Categories model.
     * @param string $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionView($id)
    {
        // Check RBAC Permission
        if($this->userCanView($id))
        {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Categories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionCreate()
    {
        // Check RBAC Permission
        if($this->userCanCreate())
        {
            $model = new Categories();

            if ($model->load(Yii::$app->request->post())) {

                // If alias is not set, generate it
                if ($_POST['Categories']['alias'] == "") {
                    $model->alias = $model->generateAlias($model->name);
                }

                // Genarate Json Params
                $params = array(
                    'categoriesImageWidth' => $_POST['categoriesImageWidth'],
                    'categoriesViewData' => $_POST['categoriesViewData'],
                    'categoryImageWidth' => $_POST['categoryImageWidth'],
                    'categoryViewData' => $_POST['categoryViewData'],
                    'itemImageWidth' => $_POST['itemImageWidth'],
                    'itemViewData' => $_POST['itemViewData']
                );
                $params = $model->generateJsonParams($params);
                $model->params = $params;

                // Upload Image and Thumb if is not Null
                $imagePath = Yii::getAlias(Yii::$app->controller->module->categoryImagePath);
                $thumbPath = Yii::getAlias(Yii::$app->controller->module->categoryThumbPath);
                $imgNameType = Yii::$app->controller->module->imageNameType;
                $imgOptions = Yii::$app->controller->module->thumbOptions;
                $imgName = $model->name;
                $fileField = "image";

                // Create UploadFile Instance
                $image = $model->uploadFile($imgName, $imgNameType, $imagePath, $fileField);

                if ($model->save()) {

                    // upload only if valid uploaded file instance found
                    if ($image !== false) {
                        // save thumbs to thumbPaths
                        $model->createThumbImages($image, $imagePath, $imgOptions, $thumbPath);
                    }

                    // Set Success Message
                    Yii::$app->session->setFlash('success', Yii::t('articles', 'Category has been created!'));

                    return $this->redirect(['index']);

                } else {

                    // Set Error Message
                    Yii::$app->session->setFlash('error', Yii::t('articles', 'Category could not be saved!'));

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
     * Updates an existing Categories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        // Check RBAC Permission
        if($this->userCanUpdate())
        {
            $model    = $this->findModel($id);
            $oldImage = $model->image;

            if ($model->load(Yii::$app->request->post())) {

                // If alias is not set, generate it
                if ($_POST['Categories']['alias']=="")
                {
                    $model->alias = $model->generateAlias($model->name);
                }

                // Genarate Json Params
                $params = array(
                    'categoriesImageWidth' => $_POST['categoriesImageWidth'],
                    'categoriesViewData'   => $_POST['categoriesViewData'],
                    'categoryImageWidth'   => $_POST['categoryImageWidth'],
                    'categoryViewData'     => $_POST['categoryViewData'],
                    'itemImageWidth'       => $_POST['itemImageWidth'],
                    'itemViewData'         => $_POST['itemViewData']
                 );
                $params = $model->generateJsonParams($params);
                $model->params = $params;

                // Upload Image and Thumb if is not Null
                $imagePath   = Yii::getAlias(Yii::$app->controller->module->categoryImagePath);
                $thumbPath   = Yii::getAlias(Yii::$app->controller->module->categoryThumbPath);
                $imgNameType = Yii::$app->controller->module->imageNameType;
                $imgOptions  = Yii::$app->controller->module->thumbOptions;
                $imgName     = $model->name;
                $fileField   = "image";

                // Create UploadFile Instance
                $image = $model->uploadFile($imgName,$imgNameType,$imagePath,$fileField);

                // revert back if no valid file instance uploaded
                if ($image === false) {
                    $model->image = $oldImage;
                }

                if ($model->save()) {

                    // upload only if valid uploaded file instance found
                    if ($image !== false)
                    {
                        // save thumbs to thumbPaths
                        $model->createThumbImages($image,$imagePath,$imgOptions,$thumbPath);
                    }

                    // Set Success Message
                    Yii::$app->session->setFlash('success', Yii::t('articles', 'Category has been updated!'));

                    return $this->redirect(['index']);

                } else {

                    return $this->render('update', [
                        'model' => $model,
                    ]);
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
     * Deletes an existing Categories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        // Check RBAC Permission
        if($this->userCanDelete())
        {
            $model = $this->findModel($id);

            if ($model->delete())
            {
                if (!$model->deleteImage() && !empty($model->image)) {
                    Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting image'));
                } else {
                    Yii::$app->session->setFlash('success', Yii::t('articles', 'Category has been deleted!'));
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
     * Deletes selected Categories models.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionDeletemultiple()
    {
        $ids = Yii::$app->request->post('ids');

        if (!$ids) {
            return;
        }

        foreach ($ids as $id)
        {
            // Check RBAC Permission
            if($this->userCanDelete($id))
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

            } else {
                throw new ForbiddenHttpException;
            }
        }

        // Set Success Message
        Yii::$app->session->setFlash('success', Yii::t('articles', 'Delete Success!'));
    }

    /**
     * Delete the Image from the Categories model
     * @param int $id
     * @return Categories update view
     * @throws ForbiddenHttpException
     */
	public function actionDeleteimage($id) 
	{
        // Check RBAC Permission
        if($this->userCanUpdate())
        {
            $model = $this->findModel($id);

            if ($model->deleteImage())
            {
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
     * Change category state: published or unpublished
     * @param int $id
     * @return Response
     */
    public function actionChangestate($id)
    {
        // Check RBAC Permission
        if($this->userCanPublish())
        {
            $model = $this->findModel($id);

            if ($model->state) {
                $model->unpublish();
                Yii::$app->getSession()->setFlash('warning', Yii::t('articles', 'Category unpublished'));
            } else {
                $model->publish();
                Yii::$app->getSession()->setFlash('success', Yii::t('articles', 'Category published'));
            }

            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Active selected Categories models.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionActivemultiple()
    {
        $ids = Yii::$app->request->post('ids');

        if (!$ids) {
            return;
        }

        foreach ($ids as $id)
        {
            $model = $this->findModel($id);

            if(!$model->state) {
                $model->publish();
                Yii::$app->getSession()->setFlash('success', Yii::t('essentials', 'Rest API actived'));
            }
        }
    }

    /**
     * Active selected Categories models.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionDeactivemultiple()
    {
        $ids = Yii::$app->request->post('ids');

        if (!$ids) {
            return;
        }

        foreach ($ids as $id)
        {
            $model = $this->findModel($id);

            if($model->state) {
                $model->unpublish();
                Yii::$app->getSession()->setFlash('warning', Yii::t('essentials', 'Rest API inactived'));
            }
        }
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
        if (($model = Categories::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Check if user can Index Categories
     * @return bool
     */
    protected function userCanIndex()
    {
        if( Yii::$app->user->can('articles-index-categories'))
            return true;
        else
            return false;
    }

    /**
     * Check if user can view Categories
     * @return bool
     */
    protected function userCanView($id)
    {
        $model = $this->findModel($id);

        if( Yii::$app->user->can('articles-view-categories') || $model->access == "Public" )
            return true;
        else
            return false;
    }

    /**
     * Check if user can create Categories
     * @return bool
     */
    protected function userCanCreate()
    {
        if( Yii::$app->user->can('articles-create-categories') )
            return true;
        else
            return false;
    }

    /**
     * Check if user can update Categories
     * @return bool
     */
    protected function userCanUpdate()
    {
        if( Yii::$app->user->can('articles-update-categories') )
            return true;
        else
            return false;
    }

    /**
     * Check if user can publish Categories
     * @return bool
     */
    protected function userCanPublish()
    {
        if( Yii::$app->user->can('articles-publish-categories') )
            return true;
        else
            return false;
    }

    /**
     * Check if user can delete Categories
     * @return bool
     */
    protected function userCanDelete()
    {
        if( Yii::$app->user->can('articles-delete-categories') )
            return true;
        else
            return false;
    }

}
