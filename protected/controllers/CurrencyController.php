<?php

class CurrencyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','loadImage'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','loadImage','view','generatePdf'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','loadImage'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
			
		);
	}
	public function actionloadImage($id)
    {
        $model=$this->loadModel($id);
        $this->renderPartial('image', array(
            'model'=>$model
        ));
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Currency;
 
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
 
        if(isset($_POST['Currency']))
        {
            $model->attributes=$_POST['Currency'];
 
            if(!empty($_FILES['Currency']['tmp_name']['symbol']))
            {
                $file = CUploadedFile::getInstance($model,'symbol');
                $model->filename = $file->name;
                $model->filetype = $file->type;
                $fp = fopen($file->tempName, 'r');
                $content = fread($fp, filesize($file->tempName));
                fclose($fp);
                $model->symbol = $content;
            }
 
            //$model->user = Yii::app()->user->id;
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }
 
        $this->render('create',array(
            'model'=>$model,
            //'types'=>Type::model()->findAll()
        ));

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Currency'])) {
			$model->attributes=$_POST['Currency'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		} else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Currency');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	public function behaviors() {
    return array(
        'exportableGrid' => array(
            'class' => 'application.components.ExportableGridBehavior',
            'filename' => 'file.csv',
            'csvDelimiter' => ',', //i.e. Excel friendly csv delimiter
            ));
}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Currency('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Currency'])) {
			$model->attributes=$_GET['Currency'];
		}
		if ($this->isExportRequest()) { 
            $this->exportCSV($model->search(), array( 
			'name',
		'filename',
			));
        }
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Currency the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Currency::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Currency $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='currency-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionGeneratePdf(){
		
		$this->layout = 'pdf';
		$model=new Currency('search');
		if(isset($_GET['Currency']))
		$model->attributes=$_GET['Currency']; // to execute the filters (if is the case) 
		$dataProvider = $model->search();
		$dataProvider->pagination = false; 
		$mPDF1 = Yii::app()->ePdf->mpdf();
		# You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5');

        # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($this->renderPartial('admin',array('model'=>$model), true));

        # Outputs ready PDF
        $mPDF1->Output();
	}
}