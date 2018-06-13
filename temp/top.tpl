<? if($massiv_dan): ?>
<div class="col-md-1"></div>
<div class="col-md-10">
	<h3 class="text-center">Лучшие фотографии, по мнению пользователей</h3>
	<div class="row">	<? foreach($massiv_dan as $item) :?>
		
			
				<section class="text-center"><?=round($item['raiting']);?></section>
				<img src="<?=SITE_URL.UPLOAD_DIR;?><?=$item['name_foto'];?>" class="img-thumbnail center-block">
			
		
		<br>
	<? endforeach; ?></div>
	<? if($navigation) :?>
			    <ul class="pager">
					<? if($navigation['last_page']) :?>
						<li><a href="<?=SITE_URL;?>top/page/<?=$navigation['last_page'];?>">Назад</a></li>
					<? endif;?>
					<? if($navigation['previous']) :?>
						<? foreach($navigation['previous'] as $val) :?>
							<li><a href="<?=SITE_URL;?>top/page/<?=$val;?>"><?=$val;?></a></li>
						<? endforeach; ?>
					<? endif;?>
					<? if($navigation['current']) :?>
						<li class="disabled"><a href="<?=SITE_URL;?>top/page/<?=$navigation['current'];?>"><?=$navigation['current'];?></a></li>
					<? endif;?>
					<? if($navigation['next']) :?>
						<? foreach($navigation['next'] as $v) :?>
							<li><a href="<?=SITE_URL;?>top/page/<?=$v;?>"><?=$v;?></a></li>
						<? endforeach; ?>
					<? endif;?>
					<? if($navigation['next_pages']) :?>
						<li><a href="<?=SITE_URL;?>top/page/<?=$navigation['next_pages'];?>">Вперед</a></li>
					<? endif;?>
				</ul>
	<? endif; ?>
</div>
		
	<div class="col-md-1"></div>
<? endif; ?>
</div>