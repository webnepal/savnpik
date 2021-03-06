<!-- TinyMce Plugins -->
<?php echo $this->Html->script('tiny_mce/tiny_mce.js',array('fullBase'=>true));?>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
    
    function calculatePrice(){
    var discount = document.getElementById('DealDiscount').value;
    var markedPrice =  document.getElementById('DealMarkedPrice').value;    
    var sellingPrice = markedPrice - Math.round((discount*markedPrice/100),2);
    document.getElementById('DealSellingPrice').value = sellingPrice;
    }
</script>
<div class="deals form">
<?php echo $this->Form->create('Deal',array(
                               'inputDefaults' => array(
                                'class' => 'form-control'
                                ),'type'=>'file')); ?>
	<fieldset>
		<legend><?php echo __('Add a new Deal'); ?></legend>
	<?php
		echo $this->Form->input('name');
        echo $this->Form->input('name_arabic');
        echo $this->Form->input('name_german',array('label'=>'Name Swedish'));
		echo $this->Form->input('deal_category_id');
		echo $this->Form->input('company_id');
        ?>
        <div class="input textarea required">
<label for="DealDescription">Description</label>
<textarea id="DealDescription" class="form-control ckeditor" required="required" rows="6" cols="30" name="data[Deal][description]">

</textarea>
</div>
<div class="input textarea required">
<label for="DealDescriptionArabic">Description Arabic</label>
<textarea id="DealDescriptionArabic" class="form-control ckeditor" required="required" rows="6" cols="30" name="data[Deal][description_arabic]">

</textarea>
</div>

<div class="input textarea required">
<label for="DealDescriptionGerman">Description Swedish</label>
<textarea id="DealDescriptionGerman" class="form-control ckeditor" required="required" rows="6" cols="30" name="data[Deal][description_german]">

</textarea>
</div>

<div class="input textarea required">
<label for="DealHighlights">Highlights</label>
<textarea id="DealHighlights" class="form-control ckeditor" required="required" rows="6" cols="30" name="data[Deal][highlights]">

</textarea>
</div>

<div class="input textarea required">
<label for="DealHighlightsArabic">Highlights Arabic</label>
<textarea id="DealHighlightsArabic" class="form-control ckeditor" required="required" rows="6" cols="30" name="data[Deal][highlights_arabic]">

</textarea>
</div>

<div class="input textarea required">
<label for="DealHighlightsGerman">Highlights Swedish</label>
<textarea id="DealHighlightsGerman" class="form-control ckeditor" required="required" rows="6" cols="30" name="data[Deal][highlights_german]">

</textarea>
</div>

<div class="input textarea required">
<label for="DealConditions">Conditions</label>
<textarea id="DealConditions" class="form-control ckeditor" required="required" rows="6" cols="30" name="data[Deal][conditions]">

</textarea>
</div>

<div class="input textarea required">
<label for="DealConditionsArabic">Conditions Arabic</label>
<textarea id="DealConditionsArabic" class="form-control ckeditor" required="required" rows="6" cols="30" name="data[Deal][conditions_arabic]">

</textarea>
</div>

<div class="input textarea required">
<label for="DealConditionsGerman">Conditions Swedish</label>
<textarea id="DealConditionsGerman" class="form-control ckeditor" required="required" rows="6" cols="30" name="data[Deal][conditions_german]">

</textarea>
</div>

        <?php
		//echo $this->Form->input('highlights');
        
		//echo $this->Form->input('conditions');
		echo $this->Form->input('threshold');
        
		echo $this->Form->input('marked_price',array('onchange'=>'calculatePrice()'));
		echo $this->Form->input('discount',array('onchange'=>'calculatePrice()','label'=>'Discount %'));
		echo $this->Form->input('selling_price',array('disabled'=>true));
		echo $this->Form->input('expiry_date');
		echo $this->Form->input('image1',array('type'=>'file','label'=>'Featured Image'));
		echo $this->Form->input('image2',array('type'=>'file'));
		echo $this->Form->input('image3',array('type'=>'file'));
		echo $this->Form->input('image4',array('type'=>'file'));
		echo $this->Form->input('image5',array('type'=>'file'));
		echo $this->Form->input('image6',array('type'=>'file'));
		echo $this->Form->input('image7',array('type'=>'file'));
		echo $this->Form->input('image8',array('type'=>'file'));
		echo $this->Form->input('image9',array('type'=>'file'));
		echo $this->Form->input('image10',array('type'=>'file')); ?>
        <br/>
	<?php $options = array('1' => ' Enabled', '0' => 'Disabled');
			  $attributes = array('legend' => false,'separator'=>'<br/>');
			echo $this->Form->radio('status', $options, $attributes);?>
    <br/>
    <?php echo $this->Form->input('is_featured',array('type'=>'checkbox','label'=>'Featured?'));?>
        
	</fieldset>
    <br/>
<?php echo $this->Form->submit('Add Deal',array('class'=>'btn btn-success','onclick'=>'$("#DealSellingPrice").removeAttr("disabled")'))?>
<?php echo $this->Form->end(); ?>
</div>