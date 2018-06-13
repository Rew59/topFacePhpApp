<!DOCTYPE html>
<html>
  <head lang="ru">
	<meta charset="UTF-8">
    <title><?=$title;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
	<? if($styles): ?>
		<? foreach($styles as $style): ?>
    <link href="<?=$style;?>" rel="stylesheet">
		<? endforeach; ?>
	<? endif; ?>
  </head>
  <body>
  <div class="container">
    <nav class="navbar navbar-default" role="navigation">
	  <div class="navbar-header">
		<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
			<span class="sr-only">Навигация</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
		<a class="navbar-brand" href="<?=SITE_URL;?>">Brand</a>
	  </div>
		<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="<?=SITE_URL;?>top">Лучшие</a>
				</li>
				<li>
					<a href="<?=SITE_URL;?>settings">Настройки</a>
				</li>
				<li>
					<a href="<?=SITE_URL;?>load">Добавить фото</a>
				</li>
			</ul>
		</nav>
	</nav>