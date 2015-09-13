<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use linslin\yii2\curl;
class ApiController extends Controller
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    /*
     * Check if a cookie is set and if not - set it
     */
    public function actionPerform()
    {
        $request = Yii::$app->request;
        $request = $request->post();

        return print_r($request['message']['chat']['id']);

        //Init curl
        $curl = new curl\Curl();

        //post http://example.com/
        $response = $curl->setOption(
            CURLOPT_POSTFIELDS,
            http_build_query(array(
                    'myPostField' => 'value'
                )
            ))
            ->post('http://example.com/');
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