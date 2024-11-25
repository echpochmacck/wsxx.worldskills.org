<?php

namespace app\modules\something\controllers;
use app\models\File;
use app\models\Product;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{

    public $gtin_arr;
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

                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => fn() => Yii::$app->user->identity->isAdmin,
                        ],
                    ],
                    'denyCallback' => function () {
                        if (Yii::$app->user->isGuest) {
                            Yii::$app->session->setFlash('error', 'error 401');
                            return Yii::$app->response->redirect('/login');
                        }
                        return Yii::$app->response->redirect('/home'); // Если пользователь не гость, редиректим на домашнюю страницу
                    },
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
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
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
        // var_dump('sds');die;
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
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin) {
            $model = new Product();

            if ($this->request->isPost) {



                if ($model->load($this->request->post())) {
                    $model->file = UploadedFile::getinstance($model, 'file');
                    if ($model->file && $pathFile = $model->upload()) {
                        $model->gross_weight = 12;
                        $model->save(false);
                        $file = new File();
                        $file->product_id = $model->id;
                        $file->name = $pathFile;
                        $file->extension = $model->file->extension;

                        // var_dump($file);die;
                        $file->save(false);
                    }
                    $model->save(false);
                    return $this->redirect("/something/product/$model->GTIN");
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
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

        if ($model->load($this->request->post())) {
            $model->file = UploadedFile::getinstance($model, 'file');
            if ($model->file && $pathFile = $model->upload()) {
                $model->gross_weight = 12;
                $model->save(false);
                if ($file = File::findOne(['product_id' => $model->id])) {
                    if (file_exists('src/' . $file->name)) {
                        unlink('src/' . $file->name);
                    }
                } else {
                    $file = new File();
                }
                $file->product_id = $model->id;
                $file->name = $pathFile;
                $file->extension = $model->file->extension;

                // var_dump($file);die;
                $file->save(false);
            }
            $model->save(false);
            return $this->redirect("/something/product/$model->GTIN");
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
        // var_dump('sd');die;
        $model = $this->findModel($id);

        if ($model->is_hidden) {
            $model->delete();
        }

        return $this->redirect(['/something/product/']);
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


    public function actionDeleteFile($id)
    {
        // var_dump('sdds');die;
        $model = $this->findModel($id);
        if ($model) {
            $file = File::findOne(['product_id' => $model->id]);
            if ($file && file_exists("src/$file->name")) {
                $file->delete();
                unlink("src/$file->name");
                return $this->redirect("/something/product/$model->GTIN");
            }
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        throw new NotFoundHttpException('The requested page does not exist.');

        // return $this->render('update', [
        //     'model' => $model,
        // ]);
    }


    public function actionHide($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            $model->is_hidden = 1;
            $model->save(false);
            return $this->redirect("/product/$model->GTIN");
        }
        throw new NotFoundHttpException('The requested page does not exist.');

        // return $this->render('update', [
        //     'model' => $model,
        // ]);
    }
}
