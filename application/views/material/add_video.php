<script type="text/javascript">

	function setLimit(begin, end)
	{
		$("#video_start").val(begin);
		$("#video_end").val(end);
	}

	swfobject.embedSWF("/web/swf/cut.swf", "player", "746", "440", "9.0.0", "/web/swf/expressInstall.swf", {vid: '<?=$material->video?>'});
</script>

<div class="sections">
	<h3><?=__('title.material.add_video')?></h3>
</div>
    <?Holder::show(4)?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="add_layout">
			<div class="holder pull-left">
<!--				<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKMAAAGQCAYAAADC9dA3AAAPwElEQVR4Xu2aB48cRRdFyyRjMtjkYIMRYHLOwkL8bksYEMLknHOOJmeM0W2p5uvtnd2dnW9XuvfplGTJuzM9++47Z6qrambH0aNHjzcGHTDowA5kNKBACUMHkBERbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDqAjDYoKAQZccCmA8hog4JCkBEHbDpgLeOPP/7YnnnmmaFZp59+ervvvvvWbdzPP//cPv7443b06NH2999/t5NOOqmde+65bd++fe3MM8+ce+1vv/3WPvroo+GaP//8s51wwgntrLPOapdeemm78MILtx3Ur7/+2p5++ul27Nix4W89+OCD7dRTT131d/W4sn355Zftjz/+aDt27BgyXXbZZevWuex12x58zh+wlVFNfP7555uEXERGgXrnnXfa8ePHV8UUuJtvvrmdf/75Kx77+uuv26uvvtr+/fffub2/+OKL2w033LBtXPR3n3322fbTTz/N/sY8Gf/555/23HPPNb3Z5g0Jed111616aNnrti3wBi9sKaNEfOmll4bZqo/1ZkbNFpKqD82Iu3btapp1umj63QMPPNBOPvnk4WmaBZ988snZjKQZ8bTTThtmHUHs45prrmlXXHHFtvB5991324cffrjitefJ+Prrr7fPP/989jzVqRr/+uuv2e9uuummVTPkstdtS9gFXtRORs2EaqJEGo+1ZJRsTzzxxAzM2Wef3W677bbhFq0ZR7f5Pltee+217fLLLx9e9oMPPmjvvffe8H8Jetdddw0yCrJmq19++WV4TLdMCbLV44cffhj+znRMZdSbQ/n60JLj6quvHt5Emi37rDrtz7LXbXXOzbyelYwvvvhi+/bbb+fWv5aMutW+/PLLs2sklYTsQzOmwEgq3ab7OlAz0ldffdW0ZtTMt3///tk1ekyzVh+PPPLIsEbbqiHhjxw50n7//fcNZdTy4+233x6epxoOHjw4vNE0VP8rr7wyew2tqdUnjWWv26qMy7yOjYyavQ4dOjTLcN555w1Nl2waa8n45ptvtk8//XR4jmY4wdrM0N/VP92m+xjf3jRb3n///cND33zzzbB86EM13XPPPbNrJbYk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" alt="163x400" data-src="holder.js/163x400" style="width: 163px; height: 400px;">-->
			</div>
			<div class="add_block pull-left">
				<div class="wrapper player" style="margin-left: -179px">
					<div id="player"></div>
				</div>
				<div class="wrapper">
					<form action="" class="form-horizontal" method="post">
						<input name="start" type="hidden" id="video_start" value>
						<input name="end" type="hidden" id="video_end" value>

						<div class="control-group">
							<label class="control-label"><?=__('material.field.title')?> <sup>*</sup></label>
							<div class="controls">
								<input name="title" type="text" placeholder="Заголовок" value="<?=$material->title?>">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Выбрать категорию<sup>*</sup></label>
							<div class="controls">
								<?=Form::select('category', array(0 => 'Не выбрана') + $category_options, Arr::get($_POST, 'category'))?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Добавить описание</label>
							<div class="controls">
								<textarea name="description" rows="3"><?=$material->description?></textarea>
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
							<div class="controls">
								<button type="submit" class="btn">Отправить</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="holder pull-right">
                <?Holder::show(5)?>
			</div>
		</div>
	</div>
</div>

