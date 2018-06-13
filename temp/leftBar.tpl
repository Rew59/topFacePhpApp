<div class="row">
<? if($topFoto): ?>
	<div class="col-md-2 text-center">
		<h3>Фото дня</h3>
		<img src="<?=SITE_URL.UPLOAD_DIR.$topFoto;?>" alt="Лучшая фотография" class="img-thumbnail center-block">
	</div>
<? else: ?>
	<div class="col-md-2 text-center">
		<p>Сегодня лучшей фотографии нету, <a href="<?=SITE_URL;?>load">загрузите фотографию</a> и станьте победителем</p>
	</div>
<? endif; ?>