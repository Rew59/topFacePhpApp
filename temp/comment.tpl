<? if($name_foto): ?>
<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="row">
			<img src="<?=SITE_URL.UPLOAD_DIR;?><?=$name_foto['name_foto'];?>" class="img-thumbnail center-block">
			<div id="vk_comments" class="center-block"></div>
		</div>
	</div>

<div class="col-md-1"></div>
<? else: ?>
	<p>Пожалуйста, обновите страницу, т.к. фотографии не загрузилась</p>
<? endif; ?>
</div>