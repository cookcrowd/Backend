<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo ZURV_BASE_HREF; ?>">
		
		<title>Cookielicious Backend</title>
		
		<link rel="stylesheet" href="css/reset.css">
		<link rel="stylesheet" href="css/styles.css">
	</head>
	<body>
		<div id="container" class="light-shadow small-border-radius">
			<a href="#" class="border-radius button" class="new-recipe">Neues Rezept</a>
			<form action="manage" method="post" id="new-recipe">
				<dl>
					<dt><label for="title">Titel</label></dt>
					<dd><input type="text" name="title" id="title" placeholder="Titel des Rezeptes ..."></dd>
					<dt><label for="preparation_time">Zubereitungszeit</label></dt>
					<dd><input type="text" name="preparation_time" id="preparation_time" placeholder="Gesamte Zubereitungsdauer ..."></dd>
					<dt><label for="image">Bild</label></dt>
					<dd><input type="file" name="image" id="image"></dd>
					<dt>
						<a href="#" class="border-radius button" id="new-step">Weiterer Zubereitungsschritt</a>
						<input type="submit" value="Speichern" class="border-radius button sumit">
					</dt>
					<dd id="recipe-steps"></dd>
				</dl>
			</form>
		</div>
		
		<script type="text/javascript" src="js/jquery-1.7.js"></script>
		<script type="text/javascript" src="js/jquery.jqote2.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		
		<!-- jqote templates -->
		<script type="text/x-jqote-template" id="tmpl-new-step">
		<![CDATA[
			<fieldset>
				<legend>Schritt <%= this.step %></legend>
				<dl>
					<dt><label for="step[<%= this.step %>][title]">Titel</label></dt>
					<dd><input type="text" name="step[<%= this.step %>][title]" id="step[<%= this.step %>][title]" placeholder="Schritt ..."></dd>
					<dt><label for="step[<%= this.step %>][duration]">Dauer</label></dt>
					<dd><input type="text" name="step[<%= this.step %>][duration]" id="step[<%= this.step %>][duration]" placeholder="Dauer ..."></dd>
					<dt><label for="step[<%= this.step %>][image]">Bild</label></dt>
					<dd><input type="file" name="step[<%= this.step %>][image]" id="step[<%= this.step %>][image]"></dd>
					<dt><label for="step[<%= this.step %>][description]">Titel</label></dt>
					<dd><textarea name="step[<%= this.step %>][description]" id="step[<%= this.step %>][description]" placeholder="Schritt ..."></textarea></dd>
				</dl>
			</fieldset>
		]]>
		</script>
		<!-- end jqote templates -->
	</body>
</html>