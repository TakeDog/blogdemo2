<?php

namespace backend\controllers;

use Yii;
use common\models\Adminuser;
use common\models\AdminuserSearch;
use backend\models\SignupForm;
use backend\models\ResetpwdSignupForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\AuthAssignment;
use common\models\AuthItem;

/**
 * AdminuserController implements the CRUD actions for Adminuser model.
 */
class AdminuserController extends Controller
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
     * Lists all Adminuser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminuserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adminuser model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Adminuser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            $user = $model->signup();
            if($user){
                return $this->redirect(['view', 'id' => $user -> id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionResetpwd($id)
    {
        $model = new ResetpwdSignupForm();

        if ($model->load(Yii::$app->request->post())) {
            
            if($model->signup($id)){
                return $this->redirect(['index']);
            }

        }

        return $this->render('resetpwd', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Adminuser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Adminuser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionPrivilege($id){
        $model = $this->findModel($id);


        // $allOption = AuthItem::find() -> select('name,description') -> where(['type'=>1]) -> orderBy('description') -> indexBy('name') -> all();
        // foreach($allOption as $v){
        //     $allOptionArray[$v -> name] = $v -> description;
        // }

        $allOptionArray = AuthItem::find() -> select('description,name') -> where(['type'=>1]) -> orderBy('description') -> indexBy('name') -> column();

        // $curOptionArray = array();
        // $curOption = AuthAssignment::find() -> select('item_name') -> where(['user_id' => $id]) -> all();
        // foreach($curOption as $v){
        //     array_push($curOptionArray,$v -> item_name);
        // }
        $curOptionArray = AuthAssignment::find() -> select('item_name') -> where(['user_id' => $id]) -> column();


        if(isset($_POST['newPri'])){
            AuthAssignment::deleteAll('user_id=:id',[':id'=>$id]);
            $newPri = $_POST['newPri'];
            foreach($newPri as $v){
                $AuthAssignmentModel = new AuthAssignment();
                $AuthAssignmentModel -> item_name = $v;
                $AuthAssignmentModel -> user_id = $id;
                $AuthAssignmentModel -> created_at = time();
                $AuthAssignmentModel -> save();
            }
            return $this -> redirect(['index']);
        }



        return $this -> render('privilege',[
            'allOptionArray' => $allOptionArray,
            'curOptionArray' => $curOptionArray,
            'model' => $model
        ]);

    }


    /**
     * Finds the Adminuser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adminuser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adminuser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
