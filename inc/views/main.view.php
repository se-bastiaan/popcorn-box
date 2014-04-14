<?php $this->load_view('templates/head', @$header_data); ?>
	<?php if(isset($template) && !empty($template)) $this->load_view(@$template, @$template_data); ?>
<?php $this->load_view('templates/footer'); ?>