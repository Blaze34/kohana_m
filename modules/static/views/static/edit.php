<?php
foreach ($errors as $error)
{
	echo $error.'<br />';
}
echo Form::open();
echo __('static.Title').' '.Form::input('title', $static->title).'<br />';
echo __('static.Alias').' '.Form::input('alias', $static->alias).'<br />';
echo __('static.Active').' '.Form::checkbox('active', $static->active).'<br />';
echo __('static.Body').' '.Form::textarea('body', $static->body).'<br />';
echo Form::submit('submit', __('static.Save'));
echo Form::close();