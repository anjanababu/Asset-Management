<?php
/* @var $this MonitorController */
/* @var $model Monitor */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'name',array('span'=>5,'maxlength'=>50)); ?>
					
					<?php echo $form->textAreaControlGroup($model,'category_id',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textFieldControlGroup($model,'location_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'technical_incharge_id',array('span'=>5)); ?>

                  

                    <?php echo $form->textFieldControlGroup($model,'status_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'printer_type_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'manufacturer_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'serial_number',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'management_type_id',array('span'=>5)); ?>

                    <?php echo $form->textAreaControlGroup($model,'comments',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textFieldControlGroup($model,'document',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'documentFileName',array('span'=>5,'maxlength'=>100)); ?>

                    <?php echo $form->textFieldControlGroup($model,'documentFileType',array('span'=>5,'maxlength'=>50)); ?>

                    <?php echo $form->textFieldControlGroup($model,'image',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'imageFileName',array('span'=>5,'maxlength'=>100)); ?>

                    <?php echo $form->textFieldControlGroup($model,'imageFileType',array('span'=>5,'maxlength'=>50)); ?>

                    <?php echo $form->textFieldControlGroup($model,'enable_financial',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'available_on_loan',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->