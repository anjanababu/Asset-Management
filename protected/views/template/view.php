<html>
    <style>
        .buttonDesign{
            margin-left : 2px;
            margin-right : 2px;
        }
    </style>
</html>
<?php
/* @var $this TemplateController */
/* @var $model Template */
?>

<?php
$this->breadcrumbs=array(
	'Templates'=>array('admin'),
	$model->name,
);
?>

<h1>View Template <span style="color:#B40431"><?php echo $model->name; ?></span></h1>
<?php //echo CHtml::link('List All','index',array('class'=>'btn-danger btn buttonDesign')); ?>
<?php echo CHtml::link('Manage All','admin',array('class'=>'btn-inverse btn buttonDesign')); ?>
<?php echo CHtml::link('Add Template','create',array('class'=>'btn-inverse btn buttonDesign')); ?>
<?php echo CHtml::link('Update',array('update', 'id'=>$model->id),array('class'=>'btn-inverse btn buttonDesign')); ?>
<?php echo CHtml::link('Delete','#',array('class'=>'btn-danger btn buttonDesign','submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')); ?>
<?php echo "<br/><br/>";?>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'name',
                array('name'=>'commodity.name','label'=>'Commodity'),
                'organisation_id',
		'description',
		'date_created',
		'path',
	),
)); ?>