<?php defined('SYSPATH') OR die('No direct access allowed.');

class Email extends Email_Core {

	/**
	 * Send an email message with template
	 *
	 * @param  string $template
	 * @param  mixed  $params for template
	 * @param  string $recipient
	 * @param  string $layout
	 * @return boolean
	 */
	public static function send($template, $params = array(), $recipient = NULL, $subject = NULL, $layout = NULL)
	{
		$config    = Kohana::$config->load('email');

		$layout    = ($layout === NULL) ? $config['layout'] : $layout;
		$recipient = ($recipient === NULL) ? $config['mail_to'] : $recipient;

		$subject = ($subject === NULL) ? I18n::get('email.subject.'.$template) : $subject;

		$message  = View::factory('emails/layouts/'. $layout)
			->set('content', View::factory('emails/'. $template)->set('params', $params))
			->set('title', $subject);

		return parent::send($recipient, $config['from'], $subject, $message->render(), TRUE);
	}

}
