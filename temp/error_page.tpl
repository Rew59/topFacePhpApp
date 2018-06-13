<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
	<title><?=$title?></title>
	<!-- Bootstrap -->
	<? if($styles) :?>
		<? foreach($styles as $style) :?>
			<link href="<?=$style;?>" rel="stylesheet" media="screen">
		<? endforeach; ?>
	<? endif; ?>
	
	<? if($scripts) :?>
		<? foreach($scripts as $script) :?>
			<script type="text/javascript" src="<?=$script;?>"></script>
		<? endforeach; ?>
	<? endif; ?>
  </head>
  
	<body>
		<div class="alert alert-error">
			<? if(isset($error)) :?>
				<? foreach($error as $item) :?>
					<div class="alert alert-danger alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  <strong>Ошибка!</strong>
					  <?=$item.'<br />';?>
					</div>
					
				<? endforeach; ?>
			<? endif; ?>
		</div>
	</body>
</html>