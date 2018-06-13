<? if($name_foto): ?>
<form action="<?=SITE_URL?>" method="post">
	<h3 class="text-center">Кликните на фотографию, которая вам нравится больше</h3>
	<div class="col-md-5">
		<input class="img-thumbnail center-block" type="image" src="<?=SITE_URL.UPLOAD_DIR;?><?=$name_foto[0]['name_foto'];?>">
		<input type="hidden" name="click" value="<?=$name_foto[0]['id'];?>">
		<input type="hidden" name="noClick" value="<?=$name_foto[1]['id'];?>">
		<h4 class="text-center"><a href="<?=SITE_URL;?>comment/id/<?=$name_foto[0]['id'];?>">Комментировать</a></h4>
	</div>
</form>
<form action="<?=SITE_URL?>" method="post">
	<div class="col-md-5">
		<input class="img-thumbnail center-block" type="image" src="<?=SITE_URL.UPLOAD_DIR;?><?=$name_foto[1]['name_foto'];?>">
		<input type="hidden" name="click" value="<?=$name_foto[1]['id'];?>">
		<input type="hidden" name="noClick" value="<?=$name_foto[0]['id'];?>">
		<h4 class="text-center"><a href="<?=SITE_URL;?>comment/id/<?=$name_foto[1]['id'];?>">Комментировать</a></h4>
	</div>
</form>

<? else: ?>
	<p>Пожалуйста, обновите страницу, т.к. фотографии не загрузилась</p>
<? endif; ?>
</div>