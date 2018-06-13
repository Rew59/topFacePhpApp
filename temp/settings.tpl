<form class="form-horizontal col-md-10" action="<?=SITE_URL?>settings" method="post">
	<? if($mes) :?>
		<div class="alert alert-info alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<?=$mes;?>
		</div>
	<? endif; ?>
	  <h4 class="text-center">Здесь можно установить ограничения на показ фотографий</h4>
	  <br>
	  <div class="form-group">
		<label for="inputInputSex" class="col-sm-4 control-label">Показывать только</label>
		<div class="col-sm-2">
			<select class="selectpicker" name="sex" data-width="160px">
			  <option selected value="">Пол</option>
			  <option value="м">Муж</option>
			  <option value="ж">Жен</option>
			</select>
		</div>
	  </div>
	  <div class="form-group">
		<label for="inputInputSex" class="col-sm-4 control-label">Выберите нужные теги</label>
		<div class="col-sm-2">
			<select id="bs3Select" class="selectpicker show-tick form-control" multiple data-live-search="true" data-selected-text-format="count>3" data-width="160px" name="teg[]">
				<? if($tegi) :?>
					<? foreach($tegi as $val) :?>
						<? foreach($val as $val2) :?>
							<option><?=$val2;?></option>
						<? endforeach; ?>
					<? endforeach; ?>
				<? endif; ?>
			</select>
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-sm-offset-4 col-sm-4">
		  <button type="submit" class="btn btn-primary" name="add">Сохранить</button>
		</div>
	  </div>
	</form>

</div>