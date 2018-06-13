<div class="row">
<? if($error) :?>
<div class="alert alert-danger alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  <strong>Ошибка!</strong>
					  <?=$error;?>
					</div>
<? endif; ?>
	<form class="form-horizontal" action="<?=SITE_URL?>login" method="post">
	  <div class="form-group">
		<label for="inputLogin" class="col-sm-4 control-label">Логин</label>
		<div class="col-sm-4">
		  <input type="text" class="form-control" id="inputLogin" name="login" placeholder="Логин">
		</div>
	  </div>
	  <div class="form-group">
		<label for="inputPassword" class="col-sm-4 control-label">Пароль</label>
		<div class="col-sm-4">
		  <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Пароль">
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-sm-offset-4 col-sm-4">
		  <button type="submit" class="btn btn-default">Войти</button>
		</div>
	  </div>
	</form>
</div>