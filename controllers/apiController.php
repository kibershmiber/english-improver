<?php

namespace app\controllers;

use app\models\Level1;
use app\models\Level2;
use Yii;
use yii\base\ErrorException;
use yii\web\Controller;
use yii\filters\VerbFilter;


class ApiController extends Controller
{
    public $enableCsrfValidation = false; // Disable Csrf Validation for our POST request

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'perform' => ['post'], // Grand only post-request for the 'performAction'
                ],
            ],
        ];
    }

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
        return $this->render('index');
    }

    function actionTest(){

        if($_COOKIE['level1'] == true)
        {
            echo 'Hello!';
            exit;
        }else{
            echo 'Not Hello!';
            exit;
        }
    }
    /*
     * Check if a cookie is set and if not - set it
     */
    public function actionPerform($data)
    {






        if($_COOKIE['level1'] == "true" && $_COOKIE['level2'] == "true"){

            if($_COOKIE['level_q'] == "true"){

                $this->fetchSentences('level1', $id, $sentence);

            }else if($_COOKIE['level_q'] == "false"){

                $this->fetchSentences('level2', $id, $sentence);

            }else{
                return $this->returnJSON(['An error has occurred. Level: '.$_COOKIE['level'] ]);
            }

        }else if($_COOKIE['level1'] == "true" && $_COOKIE['level2'] == "false"){

            $this->fetchSentences('level1', $id, $sentence);

        }else if($_COOKIE['level1'] == "false" && $_COOKIE['level2'] == "true"){

            $this->fetchSentences('level2', $id, $sentence);
        }else{
            return $this->returnJSON(['rus_phrase'=>'Выберите уровень сложности вверху']);
        }

    }

    // Perform fetch some random sentence from levelN
    protected function fetchSentences($level, $id, $sentence){
        try{
            if($sentence != NULL) {
                $level = $this->$level($id,$sentence);
                return $this->returnJSON($level);
            }else{
                $level = $this->$level();
                return $this->returnJSON(['id'=>$level['id'],'rus_phrase'=>$level['rus_phrase']]);
            }
        }catch (ErrorException $e){
            return 'An error has occurred: '.$e->getMessage().'. Code: '.$e->getCode();
        }
    }

    // Fetch sentence for level1 and check it if input parameter not NULL
    /**
     * @param null $id
     * @param null $sentence
     * @return array|null|static
     * @throws \yii\db\Exception
     */
    protected function level1($id = NULL, $sentence = NULL)
    {
        if($sentence == NULL)
        {
            $max = Level1::find()->count();
            $model = Level1::findOne(['id'=>rand(1,$max)]);
            return $model;
        }else{
            $model = Level1::findOne(['id' => $id]);
            if(strcmp($this->checkSentence($sentence),$model->eng_phrase) !== 0)
            {
                $model->appeared++;
                $model->wrong++;
                if(!$model->save()) throw new \yii\db\Exception;

                return ['eng_phrase' => ucfirst($model->eng_phrase), 'status' => false];

            }else{
                $model->appeared++;
                if(!$model->save()) throw new \yii\db\Exception;
                return ['eng_phrase' => ucfirst($model->eng_phrase), 'status' => true];
            }
        }
    }
    // Fetch sentence for level1 and check it if input parameter not NULL
    protected function level2($id = NULL, $sentence = NULL)
    {
        if($sentence == NULL)
        {
            $max = Level2::find()->count();
            $model = Level2::findOne(['id'=>rand(1,$max)]);
            return $model;
        }else{
            $model = Level2::findOne(['id' => $id]);
            if(strcmp($this->checkSentence($sentence),$model->eng_phrase) !== 0)
            {
                $model->appeared++;
                $model->wrong++;
                if(!$model->save()) throw new \yii\db\Exception;

                return ['eng_phrase' => ucfirst($model->eng_phrase), 'status' => false];

            }else{
                $model->appeared++;
                if(!$model->save()) throw new \yii\db\Exception;
                return ['eng_phrase' => ucfirst($model->eng_phrase), 'status' => true];
            }
        }
    }

    /*
     * Parse user output sentence and make it more implicit
     */
    protected function checkSentence($sentence)
    {
        $sentence = str_replace(['`','"'],'\'',strtolower(trim($sentence)));
        $contraction = [
            "didn't",
            "doesn't",
            "won't",
            "cann't",
            "shan't",
            "wouldn't",
            "shouldn't",
            "isn't",
            "aren't",
            "haven't",
            "hasn't",
            "hadn't",
            "wasn't",
            "weren't",
            "he'll",
            "she'll",
            "you'll",
            "we'll",
            "i'll",
            "it'll",
            "they'll",
            "i'm",
            "he's",
            "she's",
            "it's",
            "you're",
            "we're",
            "they're"
        ];
        $full = [
            'did not',
            'does not',
            'will not',
            'cannot',
            'shell not',
            'would not',
            'should not',
            'is not',
            'are not',
            'have not',
            'has not',
            'had not',
            'was not',
            'were not',
            'he will',
            'she will',
            'you will',
            'we will',
            'i will',
            'it will',
            'they will',
            'i am',
            'he is',
            'she is',
            'it is',
            'you are',
            'we are',
            'they are'
        ];

        return $sentence = str_replace($contraction,$full,$sentence);
    }
    /*
     * Make JSON
     */
    protected function returnJSON($data = [])
    {
        $this->setHeader(200); // MUST BE TESTING IN PRODUCTION SERVER IF WILL NOT BE WORK PROPER USE \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; // return JSON output format to a client
        if($data === NULL) $data = ['status' => 'error', 'message' => 'You must specify a return function in your method'];

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /* Seting header with status code */

    protected function setHeader($status)
    {

        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        $content_type="application/json; charset=utf-8";

        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "Improver <improver.tk>");
    }
    protected function _getStatusCodeMessage($status)
    {
        $codes = [
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        ];
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

}