<?php

namespace app\controllers;

use Yii;

class AdminController extends \yii\web\Controller
{
	public function beforeAction($action)
	{

		if(Yii::$app->user->isGuest) {
			return $this->redirect(['site/index']);
		}

		return parent::beforeAction($action);
	}

    public function actionIndex()
    {
        return $this->render('index');
    }

}
