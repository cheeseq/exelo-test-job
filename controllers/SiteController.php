<?php

namespace app\controllers;

use app\models\ChatMessage;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        if (!\Yii::$app->session->has("chat_username")) {
            $this->redirect('/site/set-username');
        }

        return $this->render('index', ['messages'=>ChatMessage::find()->all()]);
    }

    public function actionSetUsername()
    {
        if (\Yii::$app->request->isPost) {
            $name = \Yii::$app->request->post("chat_username");
            \Yii::$app->session->set("chat_username", $name);
            $this->redirect('/');
        }

        return $this->render('set-username');
    }
}
