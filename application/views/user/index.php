<?=View::factory('user/index/filter');?>

<?if (sizeof($users)):?>
	<table class="table table-hover">
	    <thead>
		    <tr>
		        <th>#</th>
		        <th><?=__('user.field.email')?></th>
		        <th><?=__('user.field.firstname')?></th>
		        <th><?=__('user.field.lastname')?></th>
		        <th><?=__('user.field.mobile')?></th>
		        <th>&nbsp;</th>
		    </tr>
	    </thead>
	    <tbody>
	        <?foreach ($users as $u):?>
		    <tr<?=$u->deleted ? ' class="deleted"' : ''?>>
		        <td><?=$u->id()?></td>
		        <td><a href="<?=Route::url('default', array('controller' => 'user', 'action' => 'edit', 'id' => $u->id()));?>"><?=$u->email ? $u->email : __('global.edit')?></a></td>
		        <td><?=$u->firstname?></td>
		        <td><?=$u->lastname?></td>
		        <td><?=$u->mobile?></td>
                <td>
				    <? if ($u->deleted OR $u->is_me()):?>
	                    &nbsp;
				    <?else:?>
                        <a class="delete_user" href="javascript:;" data-href="<?=Route::url('default', array('controller' => 'user', 'action' => 'delete', 'id' => $u->id()))?>">
	                        <i class="icon-remove"></i>
                        </a>
			        <?endif;?>
			    </td>
		    </tr>
			<?endforeach;?>
	    </tbody>
	</table>

	<div id="modalDelete" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	        <h3 id="myModalLabel"><?=__('user.delete.confirm.title')?></h3>
	    </div>
	    <div class="modal-body">
			<?=__('admin.delete.confirm.text')?>
	    </div>
	    <div class="modal-footer">
	        <button class="btn" data-dismiss="modal" aria-hidden="true"><?=__('global.cancel')?></button>
	        <a href="javascript:;" class="btn btn-primary"><?=__('global.confirm')?></a>
	    </div>
	</div>

	<script type="text/javascript">
		$(function(){
			var modal = $('#modalDelete');

			$('.delete_user').on('click', function(e){
				e.preventDefault();
				var href = $(this).data('href');
				if (href){
                    modal.modal('show');
                    modal.find('.modal-footer a').attr('href', href)
                }
			});

            modal.on('hidden', function (e){
	            $(this).find('.modal-footer a').attr('href', 'javascript:;')
            })
        })
	</script>

<?endif;?>
<?=isset($pagination) ? $pagination : ''?>