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

use cinghie\articles\models\Attachments;
use cinghie\articles\models\Tagsassign;
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
                        'actions' => ['index'],
                        'matchCallback' => function () {
                            return ( Yii::$app->user->can('articles-index-all-items') || Yii::$app->user->can('articles-index-his-items') );
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['articles-create-items'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'matchCallback' => function () {
                            $model = $this->findModel(Yii::$app->request->get('id'));
                            return ( Yii::$app->user->can('articles-update-all-items') || ( Yii::$app->user->can('articles-update-his-items') && ($model->isCurrentUserCreator()) ) );
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['changestate','activemultiple','deactivemultiple'],
                        'matchCallback' => function () {
                            $model = $this->findModel(Yii::$app->request->get('id'));
                            return ( Yii::$app->user->can('articles-publish-all-items') || ( Yii::$app->user->can('articles-publish-his-items') && ($model->isCurrentUserCreator()) ) );
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete','deleteimage','deletemultiple'],
                        'matchCallback' => function () {
                            $model = $this->findModel(Yii::$app->request->get('id'));
                            return ( Yii::$app->user->can('articles-delete-all-items') || ( Yii::$app->user->can('articles-delete-his-items') && ($model->isCurrentUserCreator()) ) );
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'matchCallback' => function () {
                            $model = $this->findModel(Yii::$app->request->get('id'));
                            return ( Yii::$app->user->can('articles-view-items') || $model->access === "public" );
                        }
                    ],
                ],
                'denyCallback' => function () {
                    throw new \Exception('You are not allowed to access this page');
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'activemultiple' => ['post'],
                    'deactivemultiple' => ['post'],
                    'changestate' => ['post'],
                    'delete' => ['post'],
					'deleteImage' => ['post'],
                    'deletemultiple' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Items models
     *
     * @return mixed
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
        $searchModel  = new ItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Items model
     *
     * @param integer $id
     * @return mixed
     * @throws \yii\base\InvalidParamException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Items model
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Items();
        $post  = Yii::$app->request->post();

        if ( $model->load($post) )
        {
            // Set Modified as actual date
            $model->modified = "0000-00-00 00:00:00";

	        // If alias is not set, generate it
	        $model->setAlias($post['Items'],'title');

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

                // Set Tags
                $tags = !empty($post['tags']) ? $post['tags'] : null;

                if(!$tags == null)
                {
                    foreach ($tags as $tag) {
                        $tagsAassign = new Tagsassign();
                        $tagsAassign->item_id = $model->id;
                        $tagsAassign->tag_id = $tag;
                        $tagsAassign->save();
                    }
                }

                // Upload only if valid uploaded file instance found
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
    }

    /**
     * Updates an existing Items model
     *
     * @param integer $id
     * @return mixed
     * @throws \yii\base\InvalidParamException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post  = Yii::$app->request->post();

        if ($model->load($post)) {

            $oldTags = $model->getTagsIDByItemID();

            // Set Modified as actual date
            $model->modified = date("Y-m-d H:i:s");

            // Set Modified by User
            $model->modified_by = Yii::$app->user->identity->id;

	        // If alias is not set, generate it
	        $model->setAlias($post['Items'],'title');

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

                // Set Tags
	            $tags = !empty($post['tags']) ? $post['tags'] : null;

                if($tags !== null) {
                    foreach ($tags as $tag) {
                        $tagsAassign = new Tagsassign();
                        $tagsAassign->item_id = $model->id;
                        $tagsAassign->tag_id = $tag;
                        $tagsAassign->save();
                    }
                }

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
    }

    /**
     * Deletes an existing Items model
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        Attachments::deleteAll([
            'AND', 'item_id = '.$id
        ]);

        Tagsassign::deleteAll([
            'AND', 'item_id = '.$id
        ]);

        if ($model->delete()) {
            if (!$model->deleteImage() && !empty($model->image)) {
                Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting image'));
            } else {
                Yii::$app->session->setFlash('success', Yii::t('articles', 'Item has been deleted!'));
            }
        } else {
            Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting image'));
        }
    }

    /**
     * Deletes selected Items models
     *
     * @throws NotFoundHttpException
     */
    public function actionDeletemultiple()
    {
        $ids = Yii::$app->request->post('ids');

        if (!$ids) {
            return;
        }

        foreach ($ids as $id)
        {
            $model = $this->findModel($id);

            Attachments::deleteAll([
                'AND', 'item_id = '.$id
            ]);

            Tagsassign::deleteAll([
                'AND', 'item_id = '.$id
            ]);

            if ($model->delete()) {
                if (!$model->deleteImage() && !empty($model->image)) {
                    Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting image'));
                } else {
                    Yii::$app->session->setFlash('success', Yii::t('articles', 'Item has been deleted!'));
                }
            } else {
                Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting image'));
            }
        }

        // Set Success Message
        Yii::$app->session->setFlash('success', Yii::t('articles', 'Delete Success!'));
    }
	
	/**
     * Deletes an existing Items Image
     *
     * @param integer $id
     * @return mixed
     */
	public function actionDeleteimage($id) 
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
	}

    /**
     * Change article state: published or unpublished
     *
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionChangestate($id)
    {
        $model = $this->findModel($id);

        if($model->state) {
            $model->deactive();
            Yii::$app->getSession()->setFlash('warning', Yii::t('articles', 'Article unpublished'));
        } else {
            $model->active();
            Yii::$app->getSession()->setFlash('success', Yii::t('articles', 'Article published'));
        }
    }

    /**
     * Active selected Items models
     *
     * @return mixed
     * @throws ForbiddenHttpException
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

            if (!$model->state) {
                $model->active();
                Yii::$app->getSession()->setFlash('success', Yii::t('articles', 'Items actived'));
            } else {
                throw new ForbiddenHttpException;
            }
        }
    }

    /**
     * Active selected Items models
     *
     * @return mixed
     * @throws NotFoundHttpException
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
                $model->deactive();
                Yii::$app->getSession()->setFlash('warning', Yii::t('articles', 'Items inactived'));
            }
        }
    }

    /**
     * Finds the Items model based on its primary key value
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
     * Check article language
     *
     * @param $id
     * @return bool
     */
    protected function checkArticleLanguage($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->language == $model->getLang() || $model->getLangTag() === "all") {
            return true;
        } else {
            return false;
        }
    }

}
