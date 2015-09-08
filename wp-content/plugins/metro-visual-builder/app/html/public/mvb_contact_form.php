<?php
if (!empty($effects)) {
	$cr_effect = ' cr-animate-gen"  data-gen="' . $effects . '" data-gen-offset="bottom-in-view';
} else {
	$cr_effect = '';
}

# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}

?>

<div class="module module-contact-form <?php echo (!empty($css)) ? $css : ''; ?> <?php echo $cr_effect; ?>"  <?php echo $addition_css_styles; ?>>
	
	<?php include(dirname(__FILE__).'/_title.php');?>

	<div class="row">
		<div class="column twelve">
	<?php
	$admin_email = $contacts_form_mail;

	if (empty($admin_email)) {
		echo __('You need enter email in options panel', 'crum');
	} else {
		if (isset($_POST['sender_name'])) {
			if (wp_mail($admin_email, "Subject: " . $_POST['letter_subject'] . "\tAuthor: " . $_POST['sender_name'] . "/" . $_POST['sender_email'], $_POST['letter_text']))
				echo '<h2>' . __('Thank you for your message!' . '</h2>', 'crum');
			else
				echo '<h2>' . __('Unknown error, during message sending' . '</h2>', 'crum');
		} else {
			?>
			<form action="<?php echo home_url(add_query_arg(array())); ?>" method="POST" name="page_feedback" id="<?php echo uniqid('page_feedback_'); ?>">
				<div class="input-wrap">
					<input id="<?php echo uniqid('sender_name_'); ?>" name="sender_name" type="text" required="required" placeholder="<?php _e('Name *', 'crum'); ?>" />
					<i class="input-icon moon-user"></i>
				</div>
				<div class="input-wrap">
					<input id="<?php echo uniqid('sender_email_'); ?>" name="sender_email" type="email" required="required" placeholder="<?php _e('Email *', 'crum'); ?>" />
					<i class="input-icon moon-mail-send"></i>
				</div>
				<div class="input-wrap">
					<input id="<?php echo uniqid('letter_subject_'); ?>" name="letter_subject" type="text" required="required" placeholder="<?php _e('Subject *', 'crum'); ?>" />
					<i class="input-icon moon-pencil-2"></i>
				</div>
				<div class="input-wrap">
					<textarea id="<?php echo uniqid('letter_text_'); ?>" rows="5" name="letter_text" required="required" placeholder="<?php _e('Message *', 'crum'); ?>"></textarea>
					<i class="input-icon moon-paragraph-justify-3"></i>
				</div>
				
				<button class="button" name="submit">
					<i class="moon-bubbles-6"></i>
					<?php _e('Leave reply', 'crum'); ?>
				</button>

			</form>
			<?php
		}
	}
	?>
		</div>
	</div>
</div>
