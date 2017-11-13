<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.4
*/

namespace cinghie\articles\controllers;

use Yii;
use cinghie\articles\models\Attachments;
use cinghie\articles\models\AttachmentsSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AttachmentsController extends Controller
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
                            return ( Yii::$app->user->can('articles-update-all-items') || ( Yii::$app->user->can('articles-update-his-items') && ($model->item->isCurrentUserCreator()) ) );
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete','deletemultiple'],
                        'matchCallback' => function () {
                            $model = $this->findModel(Yii::$app->request->get('id'));
                            return ( Yii::$app->user->can('articles-delete-all-items') || ( Yii::$app->user->can('articles-delete-his-items') && ($model->item->isCurrentUserCreator()) ) );
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
                    'delete' => ['post'],
                    'deletemultiple' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Attachments models.
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
        $searchModel = new AttachmentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Attachments model
     *
     * @param $id
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new Attachments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidParamException
     */
    public function actionCreate()
    {
        $model = new Attachments();
        $post  = Yii::$app->request->post();

        if ( $model->load($post) )
        {
	        // If alias is not set, generate it
	        $model->setAlias($post['Attachments'],'title');

            // Upload Attachments if is not Null
            $attachPath  = Yii::getAlias(Yii::$app->controller->module->attachPath);
            $attachName  = $model->title;
            $attachType  = "original";
            $attachField = "filename";

            // Create UploadFile Instance
            $attachment = $model->uploadFile($attachName,$attachType,$attachPath,$attachField);
            $model->filename = $attachment->name;
            $model->extension = $attachment->extension;
            $model->mimetype = $attachment->type;
            $model->size = $attachment->size;

            if ( $model->save() ) {

                Yii::$app->session->setFlash('success', Yii::t('articles', 'Attachment has been created!'));

                return $this->redirect(['index']);

            } else {

                Yii::$app->session->setFlash('error', Yii::t('articles', 'Attachment could not be saved!'));

                return $this->render('create', [
                    'model' => $model
                ]);
            }

        } else {

            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing Attachments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidParamException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post  = Yii::$app->request->post();

        $file_name = $model->filename;

        if ( $model->load($post) )
        {
	        // If alias is not set, generate it
	        $model->setAlias($post['Attachments'],'title');

            // Upload Attachments if is not Null
            $attachPath  = Yii::getAlias(Yii::$app->controller->module->attachPath);
            $attachName  = $model->title;
            $attachType  = "original";
            $attachField = "filename";

            // Create UploadFile Instance
            $attachment = $model->uploadFile($attachName,$attachType,$attachPath,$attachField);

            if($attachment) {

                $model->filename = $attachment->name;
                $model->extension = $attachment->extension;
                $model->mimetype = $attachment->type;
                $model->size = $attachment->size;

            } else {

                $model->filename = $file_name;
            }

            if ( $model->save() ) {

                Yii::$app->session->setFlash('success', Yii::t('articles', 'Attachment has been updated!'));

                return $this->redirect(['index']);

            } else {

                Yii::$app->session->setFlash('error', Yii::t('articles', 'Attachment could not be saved!'));

                return $this->render('create', [
                    'model' => $model
                ]);
            }

        } else {

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Attachments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            if (!$model->deleteFile() && !empty($model->filename)) {
                Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting attachment (controller delete)'));
            } else {
                Yii::$app->session->setFlash('success', Yii::t('articles', 'Attachment has been deleted'));
            }
        } else {
            Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting attachment'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes selected Attachments models.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @return void
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
            $model = $this->findModel($id);

            if ($model->delete()) {

                if (!$model->deleteFile() && !empty($model->filename)) {

                    Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting attachment'));

                } else {

                    Yii::$app->session->setFlash('success', Yii::t('articles', 'Attachment has been deleted'));
                }

            } else {

                Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting attachment'));
            }
        }

        // Set Success Message
        Yii::$app->session->setFlash('success', Yii::t('articles', 'Delete Success!'));
    }

    /**
     * Finds the Attachments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Attachments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attachments::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
