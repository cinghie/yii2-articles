<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-articles
 * @version 0.6.5
 */

namespace cinghie\articles\controllers;

use Yii;
use cinghie\articles\models\Tags;
use cinghie\articles\models\TagsSearch;
use yii\base\InvalidParamException;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TagsController implements the CRUD actions for Tags model.
 */
class TagsController extends Controller
{
	/**
	 * @inheritdoc
	 * @throws \RuntimeException
	 */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['articles-index-tags'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['articles-create-tags'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update','changestate','activemultiple','deactivemultiple'],
                        'roles' => ['articles-update-tags'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete','deleteimage','deletemultiple'],
                        'roles' => ['articles-delete-tags'],
                    ],
                ],
                'denyCallback' => function () {
                    throw new \RuntimeException('You are not allowed to access this page');
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'activemultiple' => ['post'],
                    'deactivemultiple' => ['post'],
                    'changestate' => ['post'],
                    'delete' => ['post'],
                    'deletemultiple' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Tags models.
     *
     * @return mixed
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
        $searchModel = new TagsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	/**
	 * Displays a single Tags model.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws InvalidParamException
	 * @throws NotFoundHttpException
	 */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

	/**
	 * Creates a new Tags model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 * @throws InvalidParamException
	 */
    public function actionCreate()
    {
        $model = new Tags();
        $post  = Yii::$app->request->post();

        if ( $model->load($post) )
        {
	        // If alias is not set, generate it
	        $model->setAlias($post['Tags'],'name');

            if($model->save()) {
                return $this->redirect(['index']);
            }

	        return $this->render('create', [ 'model' => $model ]);
        }

	    return $this->render('create', [ 'model' => $model ]);
    }

	/**
	 * Updates an existing Tags model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws InvalidParamException
	 * @throws NotFoundHttpException
	 */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post  = Yii::$app->request->post();

        if ( $model->load($post) )
        {
	        // If alias is not set, generate it
	        $model->setAlias($post['Tags'],'name');

            if($model->save()) {
                return $this->redirect(['index']);
            }

	        return $this->render('update', [ 'model' => $model ]);
        }

	    return $this->render('update', [ 'model' => $model ]);
    }

	/**
	 * Deletes an existing Tags model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws \Exception
	 * @throws NotFoundHttpException
	 * @throws StaleObjectException
	 * @throws \Throwable
	 */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	/**
	 * Deletes selected Tags models.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @throws \Exception
	 * @throws NotFoundHttpException
	 * @throws StaleObjectException
	 * @throws \Throwable
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
                Yii::$app->session->setFlash('success', Yii::t('articles', 'Tag has been deleted!'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting tags'));
            }
        }
    }

    /**
     * Change tags state: published or unpublished.
     *
     * @param $id
     *
     * @throws NotFoundHttpException
     */
    public function actionChangestate($id)
    {
        $model = $this->findModel($id);

        if ($model->state) {
            $model->deactive();
            Yii::$app->getSession()->setFlash('warning', Yii::t('articles', 'Tag unpublished'));
        } else {
            $model->active();
            Yii::$app->getSession()->setFlash('success', Yii::t('articles', 'Tag published'));
        }
    }

	/**
	 * Active selected Tags models.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @throws NotFoundHttpException
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
                $model->active();
                Yii::$app->getSession()->setFlash('success', Yii::t('articles', 'Tags published'));
            }
        }
    }

	/**
	 * Active selected Tags models.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
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
                Yii::$app->getSession()->setFlash('warning', Yii::t('articles', 'Tags unpublished'));
            }
        }
    }

    /**
     * Finds the Tags model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Tags
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Tags::findOne($id)) !== null) {
            return $model;
        }

	    throw new NotFoundHttpException('The requested page does not exist.');
    }
    
}
