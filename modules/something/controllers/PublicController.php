<?php

namespace app\modules\something\controllers;


use app\models\Product;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * PublicController implements the CRUD actions for Product model.
 */
class PublicController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {

        $model = new Product();
        $arr = [];
        $count = 0;
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $arr = explode("\r\n", $model->gtin_arr);
            // var_dump($arr);die;
            $checked = Product::checkGTIN($arr);
            // var_dump($checked);die;
            $ar_of_checked = array_fill_keys(ArrayHelper::getColumn($checked, 'GTIN', $keepKeys = true),'');
            // var_dump($ar_of_checked);die;
            foreach ($arr as $key => $val) {
                if (array_key_exists($val, $ar_of_checked)) {
                    // var_dump($key);die;
                    $arr[$key] =
                        [
                            'status' => 'valid',
                            'GTIN' => $arr[$key],
                        ];
                    $count++;
                } else {
                    $arr[$key] =
                        [
                            'status' => 'inValid',
                            'GTIN' => $arr[$key],
                        ];
                }
            }
            $arr = new ArrayDataProvider([
                'allModels' => $arr
            ]);
        }


        return $this->render('index', [
            'model' => $model,
            'arr' => $arr,
            'count' => $count
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model =  $this->findModel($id);
            
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['GTIN' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

   
}