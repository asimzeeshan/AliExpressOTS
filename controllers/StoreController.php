<?php

namespace app\controllers;

use Yii;
use app\models\Store;
use app\models\StoreSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StoreController implements the CRUD actions for Store model.
 */
class StoreController extends Controller
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
     * Lists all Store models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StoreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Store model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Store model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Store();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Import/Scrap a new Store model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionImport()
    {
        $model = new Store();

        if (Yii::$app->request->isPost) {
            //print_r(Yii::$app->request->post());
            $store_number = intval($_POST['Store']['store_number']);
            $scraped = $this->_scrapAliExpressStore($store_number);

            // start updating the fields with latest data
            $model->name = $scraped[1];
            $model->location = $scraped[2];
            $model->since = date('Y-m-d', strtotime($scraped[3]));
            $model->notes = "Import request Initiated from IP '".Yii::$app->request->userIP."'\n";
            $model->save();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('import', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Private function to Import/Scrap store data
     * @return array
     */
    function _scrapAliExpressStore($store_number) {
        $storeURL = "http://www.aliexpress.com/store/".$store_number;
        $data = file_get_contents($storeURL);
        $regex = array(
            //"'<div class=\"store-summary\">(.*?)</div>'si",
            "'<span class=\"store-number\">(.*?)</span>'si",
            "'<a href=\"$storeURL\" title=\"\">(.*?)</a>'si",
            "'<span class=\"store-location\">(.*?)</span>'si",
            "'<span class=\"store-time\">(.*?)<em>(.*?)</em></span>'si",
        );

        $data_array  =array();
        foreach ($regex as $re) {
            preg_match($re, $data, $match);

            $result = trim(end($match));
            $data_array[] = preg_replace('/\s+/', ' ', $result);
        }

        return $data_array;
    }

    /**
     * Updates an existing Store model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing Store model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Store model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Store the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Store::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
