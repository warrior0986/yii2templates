<?php

namespace app\controllers;

use Yii;
use app\models\Submenu;
use app\models\SubmenuSearch;
use app\models\Menu;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * SubmenuController implements the CRUD actions for Submenu model.
 */
class SubmenuController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Submenu models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('submenu-index')) {
            $searchModel = new SubmenuSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionIndexGrid()
    {
        if (Yii::$app->user->can('submenu-indexgrid')) {
            if (isset($_POST['expandRowKey'])) {
                $searchModel = new SubmenuSearch();
                $dataProvider = $searchModel->searchByMenuId($_POST['expandRowKey']);
                return $this->renderPartial('index-grid', ['dataProvider'=>$dataProvider]);
            } else {
                return '<div class="alert alert-danger">No data found</div>';
            }
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Displays a single Submenu model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can('menu-index')) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Submenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('submenu-create')) {
            $model = new Submenu();
            $model->menu_id = Yii::$app->request->get('menuId');
            // $menu_id = Yii::$app->request->get();
            // $menu = Menu::findOne(['id' => $menu_id]);
    
            if ($model->load(Yii::$app->request->post())) {
                try {
                    $model->save();
                    Yii::$app->getSession()->setFlash('success', [
                        'message' => 'Submenu option created successfully',
                        'title' => 'Success',
                        'type' => 'success'
                    ]);
                } catch (\yii\db\Exception $e) {
                    Yii::$app->getSession()->setFlash('error', [
                        'message' => 'Submenu option can not be created, Error: ' . $e->getName(),
                        'title' => 'Error',
                        'type' => 'error'
                    ]);
                }
                return $this->redirect(['/menu/index']);
            } elseif (Yii::$app->request->isAjax) {
                return $this->renderAjax('create', [
                            'model' => $model
                ]);
            }
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Submenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('submenu-update')) {
            $model = $this->findModel($id);
    
            if ($model->load(Yii::$app->request->post())) {
                try {
                    $model->save();
                    Yii::$app->getSession()->setFlash('success', [
                        'message' => 'Submenu option updated successfully',
                        'title' => 'Success',
                        'type' => 'success'
                    ]);
                } catch (\yii\db\Exception $e) {
                    Yii::$app->getSession()->setFlash('error', [
                        'message' => 'Submenu option can not be updated, Error: ' . $e->getName(),
                        'title' => 'Error',
                        'type' => 'error'
                    ]);
                }
                return $this->redirect(['/menu/index']);
            } elseif (Yii::$app->request->isAjax) {
                return $this->renderAjax('update', [
                            'model' => $model
                ]);
            }
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Submenu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('menu-index')) {
            $this->findModel($id)->delete();
            Yii::$app->getSession()->setFlash('success', [
                'message' => 'Submenu option deleted successfully',
                'title' => 'Success',
                'type' => 'success'
            ]);
    
            return $this->redirect(['/menu/index']);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Finds the Submenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Submenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Submenu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
