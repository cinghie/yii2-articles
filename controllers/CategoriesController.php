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
use cinghie\articles\models\Categories;
use cinghie\articles\models\CategoriesSearch;
use Imagine\Exception\RuntimeException;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
                        'actions' => ['index'],
                        'roles' => ['articles-index-categories'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['articles-create-categories'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['articles-update-categories'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['changestate','activemultiple','deactivemultiple'],
                        'roles' => ['articles-publish-categories'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete','deleteimage','deletemultiple'],
                        'roles' => ['articles-delete-categories'],
                    ],
					[
                        'allow' => true,
                        'actions' => ['view'],
                        'matchCallback' => function () {
                            $model = $this->findModel(Yii::$app->request->get('id'));
                            return ( Yii::$app->user->can('articles-view-categories') || $model->access === 'public' );
                        }
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
                    'deleteImage' => ['post'],
                    'deletemultiple' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Categories models
     *
     * @return mixed
     * @throws InvalidParamException
     */
    public function actionIndex()
    {
        $searchModel  = new CategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Categories model
     *
     * @param int $id
     *
     * @return mixed
     * @throws InvalidParamException
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if($model->state) {
            return $this->render('view', [
                'model' => $model,
            ]);

        }

	    throw new NotFoundHttpException;
    }

	/**
	 * Creates a new Categories model
	 *
	 * @return mixed
	 * @throws Exception
	 * @throws InvalidParamException
	 * @throws RuntimeException
	 */
    public function actionCreate()
    {
        $post  = Yii::$app->request->post();
        $model = new Categories();

        if ($model->load($post))
        {
            // If user can publish, set state = 1
            if($model->state = ( 1 && Yii::$app->user->can( 'articles-publish-categories' ) ) ) {
                $model->state = 1;
            }

            // If alias is not set, generate it
	        $model->setAlias($post['Categories'],'name');

            // Genarate Json Params
            $params = [
                'categoriesImageWidth' => $post['categoriesImageWidth'],
                'categoriesIntroText' => $post['categoriesIntroText'],
                'categoriesFullText' => $post['categoriesFullText'],
                'categoriesCreatedData' => $post['categoriesCreatedData'],
                'categoriesModifiedData' => $post['categoriesModifiedData'],
                'categoriesUser' => $post['categoriesUser'],
                'categoriesHits' => $post['categoriesHits'],
                'categoriesDebug' => $post['categoriesDebug'],
                'categoryImageWidth' => $post['categoryImageWidth'],
                'categoryIntroText' => $post['categoryIntroText'],
                'categoryFullText' => $post['categoryFullText'],
                'categoryCreatedData' => $post['categoryCreatedData'],
                'categoryModifiedData' => $post['categoryModifiedData'],
                'categoryUser' => $post['categoryUser'],
                'categoryHits' => $post['categoryHits'],
                'categoryDebug' => $post['categoryDebug'],
                'itemImageWidth' => $post['itemImageWidth'],
                'itemIntroText' => $post['itemIntroText'],
                'itemFullText' => $post['itemFullText'],
                'itemCreatedData' => $post['itemCreatedData'],
                'itemModifiedData' => $post['itemModifiedData'],
                'itemUser' => $post['itemUser'],
                'itemHits' => $post['itemHits'],
                'itemDebug' => $post['itemDebug']
            ];
            $params = $model->generateJsonParams($params);
            $model->params = $params;

            // Upload Image and Thumb if is not Null
            $imagePath   = Yii::getAlias(Yii::$app->controller->module->categoryImagePath);
            $thumbPath   = Yii::getAlias(Yii::$app->controller->module->categoryThumbPath);
            $imgNameType = Yii::$app->controller->module->imageNameType;
            $imgOptions  = Yii::$app->controller->module->thumbOptions;
            $imgName     = $model->name;
            $fileField   = 'image';

            // Create UploadFile Instance
            $image = $model->uploadFile($imgName, $imgNameType, $imagePath, $fileField);

            // Upload only if valid uploaded file instance found
            if ($image !== false) {
                // save thumbs to thumbPaths
                $model->createThumbImages($image,$imagePath,$imgOptions,$thumbPath);
            }

            if ($model->save()) {
                // Set Success Message
                Yii::$app->session->setFlash('success', Yii::t('articles', 'Category has been created!'));

                return $this->redirect(['index']);
            }

	        // Set Error Message
	        Yii::$app->session->setFlash('error', Yii::t('articles', 'Category could not be saved!'));

	        return $this->render('create', ['model' => $model]);

        }

	    return $this->render('create', ['model' => $model]);
    }

	/**
	 * Updates an existing Categories model
	 *
	 * @param int $id
	 *
	 * @return mixed
	 * @throws Exception
	 * @throws InvalidParamException
	 * @throws NotFoundHttpException
	 * @throws RuntimeException
	 */
    public function actionUpdate($id)
    {
        $post  = Yii::$app->request->post();
        $model = $this->findModel($id);

        if ($model->load($post))
        {
            // If user can publish, set state = 1
            if( $model->state = (1 && Yii::$app->user->can( 'articles-publish-categories')) ) {
                $model->state = 1;
            }

	        // If alias is not set, generate it
	        $model->setAlias($post['Categories'],'name');

            // Genarate Json Params
            $params = [
                'categoriesImageWidth' => $post['categoriesImageWidth'],
                'categoriesIntroText' => $post['categoriesIntroText'],
                'categoriesFullText' => $post['categoriesFullText'],
                'categoriesCreatedData' => $post['categoriesCreatedData'],
                'categoriesModifiedData' => $post['categoriesModifiedData'],
                'categoriesUser' => $post['categoriesUser'],
                'categoriesHits' => $post['categoriesHits'],
                'categoriesDebug' => $post['categoriesDebug'],
                'categoryImageWidth' => $post['categoryImageWidth'],
                'categoryIntroText' => $post['categoryIntroText'],
                'categoryFullText' => $post['categoryFullText'],
                'categoryCreatedData' => $post['categoryCreatedData'],
                'categoryModifiedData' => $post['categoryModifiedData'],
                'categoryUser' => $post['categoryUser'],
                'categoryHits' => $post['categoryHits'],
                'categoryDebug' => $post['categoryDebug'],
                'itemImageWidth' => $post['itemImageWidth'],
                'itemIntroText' => $post['itemIntroText'],
                'itemFullText' => $post['itemFullText'],
                'itemCreatedData' => $post['itemCreatedData'],
                'itemModifiedData' => $post['itemModifiedData'],
                'itemUser' => $post['itemUser'],
                'itemHits' => $post['itemHits'],
                'itemDebug' => $post['itemDebug']
            ];
            $params = $model->generateJsonParams($params);
            $model->params = $params;

            // Upload Image and Thumb if is not Null
            $imagePath   = Yii::getAlias(Yii::$app->controller->module->categoryImagePath);
            $thumbPath   = Yii::getAlias(Yii::$app->controller->module->categoryThumbPath);
            $imgNameType = Yii::$app->controller->module->imageNameType;
            $imgOptions  = Yii::$app->controller->module->thumbOptions;
            $imgName     = $model->name;
            $fileField   = 'image';

            // Create UploadFile Instance
            $image = $model->uploadFile($imgName,$imgNameType,$imagePath,$fileField);

	        // If image is false delete from db
	        if($model->image === false && $image === false) {
		        unset($model->image);
	        }

            // Upload only if valid uploaded file instance found
            if ($image !== false) {
                // save thumbs to thumbPaths
                $model->createThumbImages($image,$imagePath,$imgOptions,$thumbPath);
            }

            if ($model->save()) {
                // Set Success Message
                Yii::$app->session->setFlash('success', Yii::t('articles', 'Category has been updated!'));

                return $this->redirect(['index']);
            }

	        // Set Error Message
	        Yii::$app->session->setFlash('error', Yii::t('articles', 'Category could not be saved!'));

	        return $this->render('update', [
		        'model' => $model,
	        ]);
        }

	    // Set Error Message
	    Yii::$app->session->setFlash('error', Yii::t('articles', 'Category could not be saved!'));

	    return $this->render('update', [
		    'model' => $model,
	    ]);
    }

	/**
	 * Deletes an existing Categories model
	 *
	 * @param int $id
	 *
	 * @return mixed
	 * @throws \Exception
	 * @throws NotFoundHttpException
	 * @throws StaleObjectException
	 * @throws \Throwable
	 */
    public function actionDelete($id)
    {
	    /** @var Categories $model */
        $model = $this->findModel($id);

	    if ($model->delete()) {
		    // Set Success Message
		    Yii::$app->session->setFlash('success', Yii::t('articles', 'Category has been deleted!'));
        } else {
		    // Set Error Message
            Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting image'));
        }

        return $this->redirect(['index']);
    }

	/**
	 * Delete the Image from the Categories model
	 *
	 * @param int $id
	 *
	 * @return Response
	 * @throws InvalidParamException
	 * @throws NotFoundHttpException
	 */
	public function actionDeleteimage($id)
	{
        $model = $this->findModel($id);

        if ($model->deleteImage()) {
            $model->image = '';
            $model->save();

	        // Set Success Message
            Yii::$app->session->setFlash('success', Yii::t('articles', 'The image was removed successfully! Now, you can upload another by clicking Browse in the Image Tab.'));

        } else {

        	// Set Error Message
            Yii::$app->session->setFlash('error', Yii::t('articles', 'Error removing image. Please try again later or contact the system admin.'));
        }

        return $this->redirect([
            'update', 'id' => $model->id,
        ]);
	}

	/**
	 * Deletes selected Categories models
	 *
	 * @property array $ids
	 *
	 * @return Response | void
	 * @throws NotFoundHttpException
	 * @throws \Exception
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
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

            if ($model->delete())
            {
	            // Set Success Message
	            Yii::$app->session->setFlash('success', Yii::t('articles', 'Item has been deleted!'));

            } else {

	            // Set Error Message
                Yii::$app->session->setFlash('error', Yii::t('articles', 'Error deleting image'));
            }
        }
    }

	/**
	 * Change category state: active or deactive
	 *
	 * @param int $id
	 *
	 * @return Response
	 * @throws NotFoundHttpException
	 */
    public function actionChangestate($id)
    {
        $model = $this->findModel($id);

        if ($model->state) {
            $model->deactive();
            Yii::$app->getSession()->setFlash('warning', Yii::t('articles', 'Category unpublished'));
        } else {
            $model->active();
            Yii::$app->getSession()->setFlash('success', Yii::t('articles', 'Category published'));
        }

        return $this->redirect(['index']);
    }

	/**
	 * Active selected Categories models
	 *
	 * @property array $ids
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
                Yii::$app->getSession()->setFlash('success', Yii::t('articles', 'Categories published'));
            }
        }
    }

	/**
	 * Deactive selected Categories models
	 *
	 * @property array $ids
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
                Yii::$app->getSession()->setFlash('warning', Yii::t('articles', 'Categories published'));
            }
        }
    }

    /**
     * Finds the Categories model based on its primary key value
     *
     * @param string $id
     *
     * @return Categories
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Categories::findOne($id)) !== null) {
            return $model;
        }

	    throw new NotFoundHttpException('The requested page does not exist.');
    }

}
