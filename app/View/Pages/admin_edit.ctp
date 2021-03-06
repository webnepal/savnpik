<!-- TinyMce Plugins -->
<?php echo $this->Html->script('tiny_mce/tiny_mce.js',array('fullBase'=>true));?>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
</script>
<div class="col-lg-6">
<?php echo $this->Form->create('Page',array(
                               'inputDefaults' => array(
                                'class' => 'form-control'
                                )
                                )); 
    ?>
    <fieldset>
        <legend><?php echo __('Update Page'); ?></legend>
        <?php  echo $this->Form->input('title',array('label'=>'Title')); ?> <br/>
        <?php  echo $this->Form->input('title_arabic',array('label'=>'Title Arabic')); ?> <br/>
        <?php  echo $this->Form->input('title_german',array('label'=>'Title Swedish')); ?> <br/>
		<div class="input textarea">
        <label for="PageDesc">Page Description</label>
        <textarea id="PageDesc" class="form-control ckeditor" rows="6" cols="30" name="data[Page][desc]"><?php echo $this->request->data['Page']['desc'];?></textarea>
        </div>
        <br/>
        <div class="input textarea">
        <label for="PageDescArabic">Page Description Arabic</label>
        <textarea id="PageDescArabic" class="form-control ckeditor" rows="6" cols="30" name="data[Page][desc_arabic]"><?php echo $this->request->data['Page']['desc_arabic'];?></textarea>
        </div>
        <br/>
        <div class="input textarea">
        <label for="PageDescGerman">Page Description Swedish</label>
        <textarea id="PageDescGerman" class="form-control ckeditor" rows="6" cols="30" name="data[Page][desc_german]"><?php echo $this->request->data['Page']['desc_german'];?></textarea>
        </div>
        <br/>
        <?php $options = array('1' => ' Enabled', '0' => 'Disabled');
			  $attributes = array('legend' => 'Status','separator'=>'<br/>');
			echo $this->Form->radio('status', $options, $attributes);?>
			<?php echo $this->Form->input('id', array('type' => 'hidden'));?>
		<?php  echo $this->Form->input('page_category_id',array('label'=>'Category')); ?>
        <br/>
    </fieldset>
<?php echo $this->Form->submit('Update Page',array('class'=>'btn btn-info'))?>
<?php echo $this->Form->end(); ?>
</div>
