<?if ($errors):?>
<div class="alert alert-error">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
	<?=$errors?>
</div>
<?elseif ($success):?>
	<div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
		<?=$success?>
	</div>
<?endif;?>