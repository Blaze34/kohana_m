<?php defined('SYSPATH') or die('No direct access allowed.');

abstract class Auth extends Kohana_Auth {

	public function resession($user)
	{
		$this->_session->set($this->_config['session_key'], $user);
		return true;
	}
}