<?php if ( ! empty($success)): ?>
<ul style="color: green;">
<?php foreach ($success as $field => $notice): ?>
 <li rel="<?php echo $field ?>"><?php echo ucfirst($notice) ?></li>
<?php endforeach ?>
</ul>
<?php endif ?>