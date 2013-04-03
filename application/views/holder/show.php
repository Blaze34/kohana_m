<?if ($holder['wrapper']):?>
<div class="<?=$holder['class']?>" <?=($holder['style']? 'style="'.$holder['style'].'"': '')?>>
    <div style="overflow: hidden"><?=$holder['body']?></div>
</div>
<?else:?>
    <?=$holder['body']?>
<?endif;?>
