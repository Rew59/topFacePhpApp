
	<form enctype="multipart/form-data" class="form-horizontal col-md-10" action="<?=SITE_URL?>load" method="post">
	<? if($mes) :?>
		<div class="alert alert-info alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<?=$mes;?>
		</div>
	<? endif; ?>
	  <h4 class="text-center">Для того, чтобы другие могли оценить вас загрузите свою фотографию и укажите ваш пол</h4>
	  <br>
	  <div class="form-group">
		<label for="exampleInputFоto" class="col-sm-4 control-label">Загрузите фотографию</label>
		<div class="col-sm-4">
		  <input type="hidden" name="MAX_FILE_SIZE" value="5242880">
		  <input type="file" id="exampleInputFоto" name="foto" value="">
		</div>
	  </div>
	  <div class="form-group">
		<label for="inputInputSex" class="col-sm-4 control-label">Выберите пол</label>
		<div class="col-sm-2">
			<select class="selectpicker" name="sex" data-width="160px">
			  <option selected value="">Пол</option>
			  <option value="м">Муж</option>
			  <option value="ж">Жен</option>
			</select>
		</div>
	  </div>
	  <div class="form-group">
		<label for="inputInputSex" class="col-sm-4 control-label">Выберите тег</label>
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
				<input class="form-control" name="new_teg" type="text" placeholder="Если нужного тега нету, введите его">
			</div>
	  </div>
	  <div class="form-group">
		<div class="col-sm-offset-4 col-sm-4">
		  <button type="submit" class="btn btn-primary" name="add" value="">Загрузить</button>
		</div>
	  </div>
	</form>

</div>