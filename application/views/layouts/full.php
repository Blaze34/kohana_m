<!DOCTYPE html>
<html>
	<head>
        <title><?=$meta['title']?></title>
		<?if($meta['keywords']):?><meta name="keywords" content="<?=$meta['keywords']?>"><?endif;?>
		<?if($meta['description']):?><meta name="description" content="<?=$meta['description']?>"><?endif;?>

		<?if (Arr::get($meta, 'og') AND is_array($meta['og'])):?>
			<?foreach ($meta['og'] as $k => $v):?>
				<meta property="og:<?=$k?>" content="<?=$v?>" />
			<?endforeach;?>
		<?endif;?>
		<?if (Arr::get($meta, 'fb:admins')):?><meta property="fb:admins" content="<?=$meta['fb:admins']?>" /><?endif;?>

        <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
        <META HTTP-EQUIV="Content-language" content ="<?=I18n::$lang?>">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

		<?php foreach ($css as $file) echo HTML::style($file), "\n" ?>

		<?php foreach ($js as $file) echo HTML::script($file), "\n" ?>
	</head>
<body>
	<?=$content?>
</body>
</html>