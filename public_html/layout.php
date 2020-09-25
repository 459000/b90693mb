<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="elems/style.css?=kkj">
        <title><?= $title ?></title>
    </head>
    <body>
		<div id="wrapper">
			<div id="header">
				<?= $header ?>
			</div>
			<div id="left">
                    <?= $menu ?>
            </div>                   
			<div id="content">
               <?= $content ?>
			</div>
			<div id="footer">
                <?= $footer ?>
			</div>
		</div>
    </body>
</html>