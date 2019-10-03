<?php

use Throwable;
use cinghie\articles\controllers\ItemsController as BaseItems;
use yii\base\Exception;
use yii\db\StaleObjectException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ItemsController extends cinghie\articles\controllers\ItemsController
 */
class ItemsController extends BaseItems
{
	/**
	 * @return mixed|void
	 * @throws ForbiddenHttpException
	 */
	public function actionIndex()
	{
		parent::actionIndex();
	}

	/**
	 * @param int $id
	 *
	 * @return mixed|void
	 * @throws NotFoundHttpException
	 */
	public function actionView($id)
	{
		parent::actionView($id);
	}

	/**
	 * @return mixed|void
	 * @throws Exception
	 */
	public function actionCreate()
	{
		parent::actionCreate();
	}

	/**
	 * @param int $id
	 *
	 * @return mixed|void
	 * @throws Exception
	 * @throws NotFoundHttpException
	 */
	public function actionUpdate($id)
	{
		parent::actionUpdate($id);
	}

	/**
	 * @param $id
	 *
	 * @return void|Response
	 * @throws NotFoundHttpException
	 */
	public function actionTranslate($id)
	{
		parent::actionTranslate($id);
	}

	/**
	 * @param int $id
	 *
	 * @throws Exception
	 * @throws NotFoundHttpException
	 * @throws StaleObjectException
	 * @throws Throwable
	 */
	public function actionDelete($id)
	{
		parent::actionDelete($id);
	}

	/**
	 * @throws Exception
	 * @throws NotFoundHttpException
	 * @throws StaleObjectException
	 * @throws Throwable
	 */
	public function actionDeletemultiple()
	{
		parent::actionDeletemultiple();
	}

	/**
	 * @param int $id
	 *
	 * @return bool|void
	 * @throws NotFoundHttpException
	 */
	public function actionDeleteimage($id)
	{
		parent::actionDeleteimage($id);
	}

	/**
	 * @param $id
	 *
	 * @return void|Response
	 * @throws NotFoundHttpException
	 */
	public function actionChangestate($id)
	{
		parent::actionChangestate($id);
	}

	/**
	 * @throws ForbiddenHttpException
	 * @throws NotFoundHttpException
	 */
	public function actionActivemultiple()
	{
		parent::actionActivemultiple();
	}

	/**
	 * @throws NotFoundHttpException
	 */
	public function actionDeactivemultiple()
	{
		parent::actionDeactivemultiple();
	}
}
