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
     * Lists all Items models.
     *
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
     *
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionView($id)
    {
        // Check RBAC Permission
        if($this->userCanView($id) && $this->checkArticleLanguage($id))
        {
            $model = $this->findModel($id);

            return $this->render('view', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Items model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
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
                $image  = $model->uploadFile($imgName,$imgNameType,$imagePath,$fileField);

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
     *
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        // Check RBAC Permission
        if($this->userCanUpdate($id))
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

                if($model->image == false && $image === false) {
                    unset($model->image);
                }

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
     *
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
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

            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Deletes selected Items models.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws \Exception
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
     * Deletes an existing Items Image.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
	public function actionDeleteimage($id) 
	{
        // Check RBAC Permission
        if($this->userCanUpdate($id))
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
     * Change article state: published or unpublished
     *
     * @param $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionChangestate($id)
    {
		// Check RBAC Permission
        if($this->userCanPublish($id))
        {
			$model = $this->findModel($id);

			if($model->state) {
				$model->unpublish();
				Yii::$app->getSession()->setFlash('warning', Yii::t('articles', 'Article unpublished'));
			} else {
				$model->publish();
				Yii::$app->getSession()->setFlash('success', Yii::t('articles', 'Article published'));
			}

			return $this->redirect(['index']);	
		} else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Active selected Items models.
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
                Yii::$app->getSession()->setFlash('success', Yii::t('articles', 'Items actived'));
            }
        }
    }

    /**
     * Active selected Items models.
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
                Yii::$app->getSession()->setFlash('warning', Yii::t('articles', 'Items inactived'));
            }
        }
    }

    /**
     * Finds the Items model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
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
     * Check if user can Index Items
     *
     * @return bool
     */
    protected function userCanIndex()
    {
        return ( Yii::$app->user->can('articles-index-all-items') || Yii::$app->user->can('articles-index-his-items'));
    }

    /**
     * Check if user can view Items
     *
     * @param $id
     * @return bool
     * @throws NotFoundHttpException
     */
    protected function userCanView($id)
    {
        $model = $this->findModel($id);

        return ( Yii::$app->user->can('articles-view-items') || $model->access == "public" );
    }

    /**
     * Check if user can create Items
     *
     * @return bool
     */
    protected function userCanCreate()
    {
        return ( Yii::$app->user->can('articles-create-items') );
    }

    /**
     * Check if user can update Items
     *
     * @param $id
     * @return bool
     */
    protected function userCanUpdate($id)
    {
        $model = $this->findModel($id);

        return ( Yii::$app->user->can('articles-update-all-items') || ( Yii::$app->user->can('articles-update-his-items') && ($model->isUserAuthor()) ) );
    }

    /**
     * Check if user can publish Items
     *
     * @param $id
     * @return bool
     */
    protected function userCanPublish($id)
    {
        $model = $this->findModel($id);

        return ( Yii::$app->user->can('articles-publish-all-items') || ( Yii::$app->user->can('articles-publish-his-items') && ($model->isUserAuthor()) ) );
    }

    /**
     * Check if user can delete Items
     *
     * @param $id
     * @return bool
     */
    protected function userCanDelete($id)
    {
        $model = $this->findModel($id);

        return ( Yii::$app->user->can('articles-delete-all-items') || ( Yii::$app->user->can('articles-delete-his-items') && ($model->isUserAuthor()) ) );
    }

    /**
     * Check article language
     *
     * @param $id
     * @return bool
     */
    protected function checkArticleLanguage($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->language == $model->getLang() || $model->getLangTag() == "All")
        {
            return true;
        } else {
            return false;
        }
    }

}
