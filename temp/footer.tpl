</div>
<hr>
<footer class="text-center">
		<p><a href="<?=SITE_URL;?>">Site.ru</a> &copy; <?=date('Y');?> Все права защищены.</p>
	</footer>
	
	<? if($scripts): ?>
		<? foreach($scripts as $script): ?>
			<script src="<?=$script;?>"></script>
		<? endforeach; ?>
	<? endif; ?>
	<script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script>

	<script type="text/javascript">
	  VK.init({apiId: 4218157, onlyWidgets: true});
	</script>
	<script type="text/javascript">
	VK.Widgets.Comments("vk_comments", {limit: 10, width: "520", attach: "*"});
	</script>

	<script type="text/javascript">
        $(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });

            // $('.selectpicker').selectpicker('hide');
        });
    </script>
  </body>
</html>