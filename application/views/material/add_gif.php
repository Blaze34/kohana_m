<div class="sections">
	<h3><?=__('title.material.add_gif')?></h3>
</div>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="add_layout">
			<div class="holder pull-left">
			</div>
			<div class="add_block pull-left">
				<div class="wrapper  admin material">
					<form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
						<div class="control-group">
							<label class="control-label"><?=__('material.field.title')?> <sup>*</sup></label>
							<div class="controls">
								<input name="title" type="text" placeholder="Заголовок" value="<?=Arr::get($_POST, 'title')?>">
							</div>
						</div>
                        <div class="control-group">
							<label class="control-label"><?=__('material.field.meta_title')?></label>
							<div class="controls">
								<input name="meta_title" type="text" placeholder="Мета" value="<?=Arr::get($_POST, 'meta_title')?>">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Выбрать категорию<sup>*</sup></label>
							<div class="controls">
                                <select name="categories[]" multiple="multiple">
                                    <option value="0" <?=($_POST['categories'] ? '' : 'selected="selected"')?>>Не выбрана</option>
                                    <?foreach ($categories['parent'] as $sid => $s):?>
                                        <option value="<?=$sid?>" <?=(in_array($sid, $_POST['categories'])? 'selected="selected"' : '')?>><?=$s?></option>
                                        <?if(sizeof($categories['children'][$s])):?>
                                            <?foreach ($categories['children'][$s] as $cid =>  $ch):?>
                                                <option value="<?=$cid?>" <?=(in_array($cid, $_POST['categories']) ? 'selected="selected"' : '')?>>&nbsp;&nbsp;&nbsp;<?=$ch?></option>
                                            <?endforeach;?>
                                        <?endif;?>
                                    <?endforeach;?>
                                </select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Добавить описание</label>
							<div class="controls">
								<textarea name="description" rows="3"><?=Arr::get($_POST, 'description')?></textarea>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Теги</label>
							<div class="controls">
								<?=Tags::field($material)?>
								<div class="help-block">Введите теги через запятую</div>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label">Загрузить по URL</label>
							<div class="controls">
								<input name="url" type="text" placeholder="URL файла gif" value="<?=Arr::get($_POST, 'url')?>">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label">Загрузить с компьтера</label>
							<div class="controls">
								<input name="gif" type="file" value="">
							</div>
						</div>

						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn">Отправить</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="holder pull-right">
			</div>
		</div>
	</div>
</div>