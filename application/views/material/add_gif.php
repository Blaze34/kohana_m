<div class="sections">
	<h3><?=__('title.material.add_gif')?></h3>
</div>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="add_layout">
			<div class="holder pull-left">
			</div>
			<div class="add_block pull-left">
				<div class="wrapper">
					<form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
						<div class="control-group">
							<label class="control-label"><?=__('material.field.title')?> <sup>*</sup></label>
							<div class="controls">
								<input name="title" type="text" placeholder="Заголовок" value="<?=Arr::get($_POST, 'title')?>">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Выбрать категорию<sup>*</sup></label>
							<div class="controls">
								<?=Form::select('category', array('' => 'Не выбрана') + $category_options, Arr::get($_POST, 'category'))?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Добавить описание</label>
							<div class="controls">
								<textarea name="description" rows="3"><?=Arr::get($_post, 'description')?></textarea>
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