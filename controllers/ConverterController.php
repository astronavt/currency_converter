<?php

namespace app\controllers;

use Yii;
use yii\httpclient\Client;
use yii\web\Response;
use app\models\Currency;
use app\models\ConverterForm;

class ConverterController extends \yii\web\Controller
{
    public $rates = [];
    public $date;
    private $xml;
    const RATES_XML_URL =
        'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';


    public function init()
    {
        parent::init();

        $jsFile = '@app/views/' . $this->id . '/ajax.js';

        // Publish and register the required JS file
        Yii::$app->assetManager->publish($jsFile);
        $this->getView()->registerJsFile(Yii::$app->assetManager->getPublishedUrl($jsFile), ['depends' => [\yii\web\YiiAsset::
            className()]]);
    }


    private function getRemoteRates()
    {
        /**
         * uploading rates from European Central Bank
         */

        $client = new Client();
        $response = $client->createRequest()->setMethod('get')->setFormat(Client::
            FORMAT_XML)->setUrl(self::RATES_XML_URL)->send();
        $this->xml = $response;

        $currency = new Currency(['code' => 'EUR', 'rateToEur' => 1]);
        $this->rates[$currency->code] = $currency;
        foreach ($response->data['Cube']['Cube']['Cube'] as $k => $v)
        {
            $currency = new Currency();
            $currency->code = (string )$v['currency'];
            $currency->rateToEur = (float)$v['rate'];
            $this->rates[$currency->code] = $currency;
        } //foreach
    } //function

    private function parseRates()
    {

    } //function
    public function actionIndex()
    {
        $this->getRemoteRates();

        $model = new ConverterForm();

        if ($model->load(Yii::$app->request->get()))
        {
            $rate = $this->rates[$model->toCurrency]->getRateToEur() / $this->rates[$model->
                fromCurrency]->getRateToEur();
            $model->convert($rate);
        }
        if (Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $res = array(
                'body' => ['toValue' => $model->toValue,
                'fromValue' => $model->fromValue,
                'toCurrency' => $model->toCurrency,
                'fromCurrency' => $model->fromCurrency],
                'success' => true,
                );
            return $res;
        } else
        {
            $currencies = array_keys($this->rates);
            return $this->render('index', ['currencies' => $currencies, 'cfModel' => $model]);
        }
    }

}
