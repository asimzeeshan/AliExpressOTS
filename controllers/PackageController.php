<?php

namespace app\controllers;

use Yii;
use app\models\Package;
use app\models\PackageSearch;
use app\models\Store;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * PackageController implements the CRUD actions for Package model.
 */
class PackageController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Package models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PackageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Package model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Package model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Package();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Import/Scrap a new Package model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionImport()
    {
        $model = new Package();

        if (Yii::$app->request->isPost) {
            $product_url = $_POST['Package']['product_url'];
            $scraped = $this->_scrapAliExpressProduct($product_url);

            if (!empty($scraped['store_id'])) {
                $check_flag = Store::find()->where( [ 'store_number' => $scraped['store_id'] ] )->exists();

                if ($check_flag==false) {
                    $store = new Store();
                    $store->store_number    = $scraped['store_id'];
                    $store->name            = urldecode($scraped['store_name']);
                    $store->location        = $scraped['store_location'];
                    $store->since           = date('Y-m-d', strtotime($scraped['store_since']));
                    $store->notes = "Import request Initiated from IP '".Yii::$app->request->userIP."'\n";
                    $store->save();

                    $data = ArrayHelper::toArray($store->id);
                    $store_internal_id = $data[0];
                } else {
                    // store found so do nothing
                    $primary = Store::find()->where( [ 'store_number' => $scraped['store_id'] ] )->one();
                    $data = ArrayHelper::toArray($primary);

                    if ($primary!=false) {
                        $store_internal_id = $data['id'];
                    } else {
                        $store_internal_id = 0;
                    }
                }
            } else { // if seller (store) information in unavailable
                $store_internal_id = 133;
            }

            // start updating the fields with latest data
            $model->store_id    = $store_internal_id;
            $model->order_id    = $_POST['Package']['order_id'];
            $model->order_date  = date('Y-m-d');                    // lets go with today's date
            $model->paid_with   = "4";                              // lets go with SCB-DebitCard
            $model->product_url = $product_url;
            $model->price       = substr($scraped['price'], 0, 5);
            $model->description = substr($scraped['name'], 0, 75);
            $model->status      = "Awaiting Shipment";
            $model->notes = "Import request Initiated from IP '".Yii::$app->request->userIP."'\n".
                            "Data scrapped from ".$product_url;
            $model->save();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('import', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Private function to Import/Scrap Package/Product data
     * @return array
     */
    function _scrapAliExpressProduct($product_url) {
        $html = file_get_contents(urldecode($product_url));
        $dom = new \DOMDocument();
        //$dom->validateOnParse = false;
        @$dom->loadHTML($html);
        $product_data = array();
        $product_data['url'] = $product_url;

        $ProductName = $dom->getElementsByTagName('h1');
        $product_data['name'] = $ProductName->item(0)->nodeValue;

        $ProductStoreID = $dom->getElementById('hid_storeId');
        $product_data['store_id'] = $ProductStoreID->getAttribute( 'value' );

        $ProductPrice = $dom->getElementById('sku-price');
        $product_data['price'] = $ProductPrice->nodeValue;

        if (isset($product_data['store_id']) && $product_data['store_id']!="") {
            $storeURL = "http://www.aliexpress.com/store/".$product_data['store_id'];
            $data = file_get_contents($storeURL);
            $product_data['store_url'] = $storeURL;

            $regex = array(
                "'<span class=\"store-number\">(.*?)</span>'si",
                "'<a href=\"$storeURL\" title=\"\">(.*?)</a>'si",
                "'<span class=\"store-location\">(.*?)</span>'si",
                "'<span class=\"store-time\">(.*?)<em>(.*?)</em></span>'si",
            );

            $store_items = array(
                'store_number',
                'store_name',
                'store_location',
                'store_since',
            );

            $i = 0;
            foreach ($regex as $re) {
                preg_match($re, $data, $match);

                $result = trim(end($match));
                $product_data[$store_items[$i]] = urldecode(preg_replace('/\s+/', ' ', $result));
                $i++;
            }
        }

        return $product_data;
    }

    /**
     * Updates an existing Package model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Package model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * 'Confirm Received' an existing Package model.
     * If 'received' is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionShipped($id)
    {
        $model = $this->findModel($id);
        if ($model->shipment_date=="0000-00-00") {
            $model->shipment_date = new Expression('NOW()');
            $model->status = "Awaiting delivery";
        } else {
            $model->shipment_date = "0000-00-00";
            $model->status = "Awaiting Shipment";
        }
        $model->save();

        return $this->redirect(['update', 'id' => $model->id]);
    }

    /**
     * 'Confirm Received' an existing Package model.
     * If 'received' is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionReceived($id)
    {
        $model = $this->findModel($id);
        if ($model->delivery_date=="0000-00-00") {
            $model->delivery_date = new Expression('NOW()');
            $model->status = "Delivered";
        } else {
            $model->delivery_date = "0000-00-00";
            $model->status = "Awaiting delivery";
        }
        $model->save();

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Finds the Package model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Package the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Package::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

