<?php
foreach ($errors as $error)
{
	echo $error.'<br />';
}
echo Form::open();
echo __('static.Title').' '.Form::input('title', Arr::get($_POST, 'title', '')).'<br />';
echo __('static.Alias').' '.Form::input('alias', Arr::get($_POST, 'alias', '')).'<br />';
echo __('static.Active').' '.Form::checkbox('active', Arr::get($_POST, 'active', 1)).'<br />';
echo __('static.Body').' '.Form::textarea('body', Arr::get($_POST, 'body', '')).'<br />';
echo Form::submit('submit', __('static.Create'));
echo Form::close();