<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo ZURV_BASE_HREF; ?>">
		
		<title>keserowitz.de</title>
		
		<link rel="alternate" type="application/rss+xml" href="feed.rss" title="RSS Feed">
		
		<link rel="stylesheet" href="css/reset.css">
		<link rel="stylesheet" href="css/styles.css">
	</head>
	<body>
		<div id="container" class="light-shadow small-border-radius">
			<?php echo $content; ?>
		</div>
		
		<a href="impressum" id="imprint">Impressum</a>
		
		<script type="text/javascript" src="js/jquery-1.7.min.js"></script>
		<script type="text/javascript" src="js/tooltipsy.min.js"></script>
		<script type="text/javascript" src="js/fileuploader.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
	</body>
</html>