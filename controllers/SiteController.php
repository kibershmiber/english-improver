<?php

namespace app\controllers;

use app\models\Level1;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ContactForm;
//use app\models\appInterface;
use yii\base\Response;

class SiteController extends Controller
{
    public $enableCsrfValidation = false; // Disable Csrf Validation for our POST request
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'perform' => ['post','get'], // Grand only post-request for the 'performAction'
                ],
            ],
        ];
    }

    /*
     * Check cookies at the start
     */
    function init(){
    /*
       if(Yii::$app->getRequest()->getCookies()->has('lavel1') && Yii::$app->getRequest()->getCookies()->has('lavel2')){

        }
     */

    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /*
     * Check if a cookie is set and if not - set it
     */

    public function actionPerform($id = null,$sentence = null)
    {
        $this->enableCsrfValidation = false;
        // Set cookie for level1 for test
        if (!isset(Yii::$app->request->cookies['level1'])) {
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'level1',
                'value' => 'true'
            ]));
        }
            // Perform fetch some random sentence from level1

             try{
                 if($sentence != NULL) {
                     $level1 = $this->level1($id,$sentence);
                     return $this->returnJSON($level1);
                 }else{
                     $level1 = $this->level1();
                     return $this->returnJSON(['id'=>$level1['id'],'rus_phrase'=>$level1['rus_phrase']]);
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
    protected function level2($sentence = NULL)
    {

    }

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
        header('X-Powered-By: ' . "HHMC <hhmc.tk>");
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


    /*
     * Fetch the date from the DB
     */

    function fetchData()
    {
        // TODO: Implement fetchData() method.
    }

    //==============================================Common functions========================================//


    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }


}
