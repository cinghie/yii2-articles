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
use cinghie\articles\models\Attachments;
use cinghie\articles\models\AttachmentsSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
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
                        'actions' => ['index','create','update','delete','deletemultiple'],
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
                    //'delete' => ['post'],
                    'deletemultiple' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Attachments models
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionIndex()
    {
        // Check RBAC Permission
        if($this->userCanIndex())
        {
            $searchModel = new AttachmentsSearch();
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
     * Displays a single Attachments model.
     *
     * @param $id
     * @return string
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        // Check RBAC Permission
        if($this->userCanView($id))
        {
            return $this->render('view', ['model' => $this->findModel($id),]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Attachments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     */
    public function actionCreate()
    {
        // Check RBAC Permission
        if($this->userCanCreate())
        {
            $model = new Attachments();

            if ( $model->load(Yii::$app->request->post()) )
            {
                // Upload Attachments if is not Null
                $attachPath  = Yii::getAlias(Yii::$app->controller->module->attachPath);
                $attachName  = $model->title;
                $attachType  = "original";
                $attachField = "filename";

                // Create UploadFile Instance
                $attach = $model->uploadFile($attachName,$attachType,$attachPath,$attachField);
                $model->filename = $attach->name;

                if ( $model->save() )
                {
                    // upload only if valid uploaded file instance found
                    if ($attach !== false)
                    {
                        // Set Success Message
                        Yii::$app->session->setFlash('success', Yii::t('articles', 'Attachment has been created!'));
                    }

                    return $this->redirect(['index']);

                } else {

                    // Set Error Message
                    Yii::$app->session->setFlash('error', Yii::t('articles', 'Attachment could not be saved!'));

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
     * Updates an existing Attachments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        // Check RBAC Permission
        if($this->userCanUpdate($id))
        {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post())) {

                // Upload Attachments if is not Null
                $attachPath  = Yii::getAlias(Yii::$app->controller->module->attachPath);
                $attachName  = $model->title;
                $attachType  = "original";
                $attachField = "filename";

                // Create UploadFile Instance
                $attach = $model->uploadFile($attachName,$attachType,$attachPath,$attachField);
                $model->filename = $attach->name;

                if($model->save())
                {
                    return $this->redirect(['index']);
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
     * Deletes an existing Attachments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        // Check RBAC Permission
        if($this->userCanDelete($id))
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
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Deletes selected Attachments models.
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
                    if (!$model->deleteFile() && !empty($model->filename)) {
                        Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting attachment'));
                    } else {
                        Yii::$app->session->setFlash('success', Yii::t('articles', 'Attachment has been deleted'));
                    }
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting attachment'));
                }

            } else {
                throw new ForbiddenHttpException;
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

    /**
     * Check if user can Index Articles
     *
     * @return bool
     */
    protected function userCanIndex()
    {
        return ( Yii::$app->user->can('articles-index-all-items') || Yii::$app->user->can('articles-index-his-items'));
    }

    /**
     * Check if user can view Articles
     *
     * @param $id
     * @return bool
     */
    protected function userCanView($id)
    {
        $model = $this->findModel($id);

        return ( Yii::$app->user->can('articles-view-items') || $model->access == "public"  );
    }

    /**
     * Check if user can create Articles
     *
     * @return bool
     */
    protected function userCanCreate()
    {
        return ( Yii::$app->user->can('articles-create-items') );
    }

    /**
     * Check if user can update Articles
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
     * Check if user can publish Articles
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
     * Check if user can delete Articles
     *
     * @param $id
     * @return bool
     */
    protected function userCanDelete($id)
    {
        $model = $this->findModel($id);

        return ( Yii::$app->user->can('articles-delete-all-items') || ( Yii::$app->user->can('articles-delete-his-items') && ($model->isUserAuthor()) ) );
    }

}
