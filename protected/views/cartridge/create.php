<html>
    <style>
        .buttonDesign{
            margin-left : 2px;
            margin-right : 2px;
        }
    </style>
</html>

<?php
/* @var $this CartridgeController */
/* @var $model Cartridge */
?>

<?php
$this->breadcrumbs=array(
	'Cartridge'=>array(''),
        'Manage'=>array('admin'),
	'Create',
);
?>
<h1>Create <span style="color:#B40431">Cartridge</span></h1>
<?php //echo CHtml::link('List All','index',array('class'=>'btn-danger btn buttonDesign')); ?>
<?php //echo CHtml::link('Manage','admin',array('class'=>'btn-inverse btn buttonDesign')); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>