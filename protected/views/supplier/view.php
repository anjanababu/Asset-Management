<html>
    <style>
        .buttonDesign{
            margin-left : 2px;
            margin-right : 2px;
        }
    </style>
</html>
<?php
/* @var $this SupplierController */
/* @var $model Supplier */
?>

<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('admin'),
	$model->name,
);
?>

<h1>View Supplier <span style="color:#B40431"><?php echo $model->name; ?></span>
<?php echo CHtml::link('<i class="icon-pencil"></i>',array('update', 'id'=>$model->id),array('class'=>'btn-warning btn buttonDesign')); ?>
<?php echo CHtml::link('<i class="icon-trash"></i>','#',array('class'=>'btn-warning btn buttonDesign','submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')); ?>
</h1>
<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'name',
                array('name'=>'suppliertype.name','label'=>'Supplier Type'),
		'add1',
		'add2',
		'pincode',
		'city',
		'state',
		'country',
		'website',
		'phone_no',
		'comment',
		'tax',
		'email',
		'documentFileName',
		'vcardFileName',
	),
)); ?>