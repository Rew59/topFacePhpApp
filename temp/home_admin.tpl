<div class="row">
<? if($mes) :?>
<div class="alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?=$mes;?>
</div>
<? endif; ?>
<? if($massiv_dan): ?>
	<div class="col-md-1">
		<ul class="nav nav-pills nav-stacked">
		  <li><a href="<?=SITE_URL?>login/logout/1">Выход</a></li>
		</ul>
	</div>
	<div class="col-md-offset-1 col-md-9">
	<h3 class="text-center">Сохраните фотографии, которые не противоречат правилам сайта</h3>
	<?php $i=0;?><? foreach($massiv_dan as $item) :?>
		<div class="row">
			<form class="form-horizontal" action="<?=SITE_URL?>admin" method="post">
				<img src="<?=SITE_URL.OLD_UPLOAD_DIR;?><?=$item['name_foto']?>" class="img-thumbnail center-block">
				<br>
			<div class="col-md-offset-4 col-md-3">
			
			<? if($tegi): ?>
				<? foreach($tegi[$i] as $t) :?>
					
						<button type="submit" class="btn btn-default btn-xs" name="del_teg" value="<?=$item['id'].",".$t['name_teg'];?>">
						<?=$t['name_teg'];?> <span class="glyphicon glyphicon-remove"></span>
						</button>
					
				<? endforeach; ?><?php $i++;?>
			<? endif; ?>
			<p></p>
				<select class="selectpicker" name="sex">
				<? if($item['sex'] == 'м'): ?>
				  <option selected value="м">Муж</option>
				  <option value="ж">Жен</option>
				<? endif; ?>
				<? if($item['sex'] == 'ж'): ?>
					<option value="м">Муж</option>
					<option selected value="ж">Жен</option>
				<? endif; ?>
				</select>
				<p></p><br>
				<button type="submit" class="btn btn-primary" name="add" value="<?=$item['id']?>">Добавить</button>
				<button type="submit" class="btn btn-danger" name="del" value="<?=$item['id']?>">Удалить</button>
			</div>
			</form>
		</div>
		<br>
	<? endforeach; ?>
	<? if($navigation) :?>
			    <ul class="pagination">
					<? if($navigation['last_page']) :?>
						<li><a href="<?=SITE_URL;?>admin/page/<?=$navigation['last_page'];?>">Назад</a></li>
					<? endif;?>
					<? if($navigation['previous']) :?>
						<? foreach($navigation['previous'] as $val) :?>
							<li><a href="<?=SITE_URL;?>admin/page/<?=$val;?>"><?=$val;?></a></li>
						<? endforeach; ?>
					<? endif;?>
					<? if($navigation['current']) :?>
						<li class="active"><a href="<?=SITE_URL;?>admin/page/<?=$navigation['current'];?>"><?=$navigation['current'];?></a></li>
					<? endif;?>
					<? if($navigation['next']) :?>
						<? foreach($navigation['next'] as $v) :?>
							<li><a href="<?=SITE_URL;?>admin/page/<?=$v;?>"><?=$v;?></a></li>
						<? endforeach; ?>
					<? endif;?>
					<? if($navigation['next_pages']) :?>
						<li><a href="<?=SITE_URL;?>admin/page/<?=$navigation['next_pages'];?>">Вперед</a></li>
					<? endif;?>
				</ul>
	<? endif; ?>
	</div>
		
	<div class="col-md-1"></div>
	
<? endif; ?>
</div>