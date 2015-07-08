<?php

class ReportlocController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','pdf','print'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
            $model=new Reportloc;
            if (isset($_POST['Reportloc'])) {
                $model->attributes = $_POST['Reportloc'];
                $report_name = $model->name;
                $description = $model->description;

                //txt_field_commodity : selected column field names
                //field_commodity : selected row ids;
                //commodity : item_ids
                
                $attributeArray = [];
                $fromTables = [];
                $whereClauses = [];
                /*************COMMODITY*****************/
				
				//print_r($_POST['commodity']);die;
                
                if(isset($_POST['commodity'])){
            
			
                    $rows = isset($_POST['commodity'])?$_POST['commodity']:[];
                    $whereArray1 = [];
                    foreach($rows as $item){
                        $whereArray1[] = $item;
                    }
					//echo $whereArray1;die;
					
                    $whereText1 = implode(',',$whereArray1);
					//print_r ($whereText1);die;
					
					if($whereText1!='all')
						$whereClauses[] = "location.id IN ($whereText1)";
						
					//print_r($whereClauses[0]);die;
					
					$model->query = "SELECT commodity.name,commodity_category.path,consumable.name,location.name FROM commodity,commodity_category,consumable,location
					WHERE commodity.id=commodity_category.id AND 
					commodity_category.path=consumable.category_id AND commodity.id=consumable.commodity_id  AND $whereClauses[0]";
					//echo $model->query;die;
						
                }
            
                if($model->save())
                    $this->redirect(array('view','id'=>$model->rid));
        }
        $this->render('create', array(
            'model' => $model,
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

		if (isset($_POST['Reportloc'])) {
			$model->attributes=$_POST['Reportloc'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->rid));
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
		$dataProvider=new CActiveDataProvider('Reportloc');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Report('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Reportloc'])) {
			$model->attributes=$_GET['Reportloc'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Report the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Reportloc::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Report $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='reportloc-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionPrint() {


        $this->render('print');
    }

    public function actionPdf() {



        //$model = new Report;
        //$this->render('pdf');
        # mPDF



        if (isset($_POST['page_size'])) {
            $page_size = $_POST['page_size'];
        } else {
            $page_size = "A4";
        }

        if (isset($_POST['page_orient'])) {
            if ($_POST['page_orient'] == "L") {
                $pagesize_orient = $page_size . "-" . $_POST['page_orient'];
            } else {
                $pagesize_orient = $page_size;
            }
        } else {
            $pagesize_orient = $page_size;
        }



        //if(isset($page_size))
        //die();

        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', $pagesize_orient, '0', '', '15', '15', '15', '15', '', '', 'P');

        //$mPDF1->SetHeader('Header');
        // $mPDF1->setFooter('footer');


        $mpdf = new mPDF('c', 'A4-L');

        # render (full page)
        //$mPDF1->WriteHTML($this->render('test', array(''=>'',), true));
        # Load a stylesheet
        // $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
        // $mPDF1->WriteHTML($stylesheet, 1);
        # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($this->renderPartial('pdf', array('' => ''), true));

        # Renders image
        // $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));
        # Outputs ready PDF
        $mPDF1->Output();
    }

	public function actionDatepick() {

        $model = new Date;
        $this->renderPartial('_newDate', array(
            'model' => $model,
                ), false, true);
    }

    public function actionDatepickto() {

        $model = new Date;
        $this->renderPartial('_newDateto', array(
            'model' => $model,
                ), false, true);
    }

    public function actionBackbtn() {
        $qry = $_POST['qry'];
        $column = $_POST['hdn_columns'];
        $report_name = $_POST['reportloc_name'];
        $model = new Reportloc;
        $this->render('test', array(
            'model' => $model,));
    }

    public function actionBackbtnview() {
        //$qry=$_POST['qry'];
        //$column=$_POST['hdn_columns'];
        $id = $_POST['id'];
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }
}