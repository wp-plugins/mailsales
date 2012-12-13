<?php
/*
Plugin Name: MailSales
Description: Subscription form for russian users of service E-mail Marketing (Selling mailing)
Version: 1.0
Author: Shchekin Roman
Author URI: http://webstydio.ru/
*/

class MailSales_Widget extends WP_Widget {

	function MailSales_Widget() {
		$widget_ops = array('description' => 'Subscription form for russian users of service E-mail Marketing (Selling mailing)');
		$control_ops = array('id_base' => 'mailsales');
		parent::__construct('mailsales', 'MailSales', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance) {
		if (!empty($instance['subscribe_id']) && $instance['subscribe_id'] > 0) {
			print $args['before_widget'];
			print $args['before_title'].$instance['subscribe_title'].$args['after_title'];
			print "
			<form id='subscribe_form' method='post' action='http://service.mailsales.ru/usr_subscribe.".$instance['subscribe_id'].".html'>
				<div class='subscribe_block'>
					<input name='iehack' type='hidden' value='&#9760;' />
					<input type='text' name='name' id='form_name' value='".$instance['subscribe_name_text']."' onfocus='if (this.value == \"".$instance['subscribe_name_text']."\") { this.value = \"\"; }' onblur='if (this.value == \"\") { this.value=\"".$instance['subscribe_name_text']."\"; }' class='subscribe_field' /></p>
					<input type='text' name='email' id='form_email' value='".$instance['subscribe_email_text']."' onfocus='if (this.value == \"".$instance['subscribe_email_text']."\") { this.value = \"\"; }' onblur='if (this.value == \"\") { this.value = \"".$instance['subscribe_email_text']."\"; }' class='subscribe_field' /></p>
					<input type='submit' name='try' value='".$instance['subscribe_button_text']."' class='subscribe_button' /></p>
				</div>
			</form>
			";
			print $args['after_widget'];
		}
	}

	function update($new_instance, $old_instance) {
		$error = 0;
		if (empty($new_instance['subscribe_id']) || !preg_match("/^[0-9]+$/", $new_instance['subscribe_id'])) {
			$error = 1;
		}
		if (empty($new_instance['subscribe_name_text'])) {
			$new_instance['subscribe_name_text'] = "Your name";
		}
		if (empty($new_instance['subscribe_email_text'])) {
			$new_instance['subscribe_email_text'] = "Your e-mail";
		}
		if (empty($new_instance['subscribe_button_text'])) {
			$new_instance['subscribe_button_text'] = "Subscribe";
		}
		if ($error == 0) {
			return $new_instance;
		} else {
			return false;
		}
	}

	function form( $instance ) {
		print "
		<p><b>".__("Title:")."</b></p>
		<p><input type='text' id='".$this->get_field_id('subscribe_title')."' name='".$this->get_field_name('subscribe_title')."' value='".$instance['subscribe_title']."' /></p>
		<p><b>".__("Subscribe ID:")."<sup style='color: red;'>*</sup></b></p>
		<p><input type='text' id='".$this->get_field_id('subscribe_id')."' name='".$this->get_field_name('subscribe_id')."' value='".$instance['subscribe_id']."' /></p>
		<p><b>".__("Text in the field `Your name`:")."</b></p>
		<p><input type='text' id='".$this->get_field_id('subscribe_name_text')."' name='".$this->get_field_name('subscribe_name_text')."' value='".$instance['subscribe_name_text']."' /></p>
		<p><b>".__("Text in the field `Your e-mail`:")."</b></p>
		<p><input type='text' id='".$this->get_field_id('subscribe_email_text')."' name='".$this->get_field_name('subscribe_email_text')."' value='".$instance['subscribe_email_text']."' /></p>
		<p><b>".__("Button text:")."</b></p>
		<p><input type='text' id='".$this->get_field_id('subscribe_button_text')."' name='".$this->get_field_name('subscribe_button_text')."' value='".$instance['subscribe_button_text']."' /></p>
		";
	}
}

function load_additional_files()
{
	// Load JQuery
	wp_enqueue_script("jquery");
	// Load client.js
	wp_deregister_script("ms_client");
	wp_register_script("ms_client", "/wp-content/plugins/mailsales/client.js", false, false, false);
	wp_enqueue_script("ms_client");
}

add_action('widgets_init', create_function('', 'return register_widget("MailSales_Widget");'));
add_action('wp_enqueue_scripts', 'load_additional_files');
?>