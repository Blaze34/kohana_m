youtube-video
=============

Youtube video search API for kohana framework. 

Getting started
===============

First off, download and enable the module on your application/bootstrap.php 

Then register your API key on google code: 
https://code.google.com/apis/youtube/dashboard/

And write your API key on config/youtube.php

Search video on Youtube 
=======================

`
$videos = Youtube::factory('videos')
    ->where('q', 'Search query')
    ->limit(10)->offset(1)
    ->find_all();
`
