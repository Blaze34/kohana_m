<?php if (Arr::get($_REQUEST, 'jinnee')):?>
<script type="text/javascript">
<![CDATA[
<?php if (isset($success)):?>jn.response.success = <?=json_encode($success)?>;<?php endif;?>
<?php if (isset($errors)):?>jn.response.errors = <?=json_encode($errors)?>;<?php endif;?>
<?php if (isset($json)):?>jn.response.json = <?=json_encode($json)?>;<?php endif;?>
jn.response.error = <?=$error?>;
]]>
</script>
<?php endif;?>

<?=$content?>