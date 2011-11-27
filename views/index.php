<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo ZURV_BASE_HREF; ?>">
		
		<title>Cookielicious Backend</title>
		
		<link rel="stylesheet" href="css/reset.css">
		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/flick/jquery-ui-1.8.16.custom.css">
	</head>
	<body>
		<div id="container" class="light-shadow small-border-radius">
			<a href="#" class="border-radius button" class="new-recipe">Neues Rezept</a>
			<form action="manage" method="post" id="new-recipe" enctype="multipart/form-data">
				<dl>
					<dt><label for="title">Titel</label></dt>
					<dd><input type="text" name="title" id="title" placeholder="Titel des Rezeptes ..."></dd>
					<dt><label for="preparation-time">Zubereitungszeit</label></dt>
					<dd><input type="text" name="preparation-time" id="preparation-time" placeholder="Gesamte Zubereitungsdauer ..."></dd>
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
		<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="js/jquery.jqote2.js"></script>
		<script type="text/javascript" src="js/base64.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		
		<!-- dialogs -->
		<div id="dlg-add-ingredient" style="display: none;">
			<input type="hidden" name="dlg-add-ingredient-id" id="dlg-add-ingredient-id" value="">
			<dl>
				<dt><label for="dlg-add-ingredient-name">Zutat</label></dt>
				<dd><input type="text" name="dlg-add-ingredient-name" id="dlg-add-ingredient-name"></dd>
				<dt><label for="dlg-add-ingredient-amount">Menge</label></dt>
				<dd>
					<input type="text" name="dlg-add-ingredient-amount" id="dlg-add-ingredient-amount">
					<select name="dlg-add-ingredient-amount-unit" id="dlg-add-ingredient-amount-unit" size="1">
						<option>g</option>
						<option>kg</option>
						<option>ml</option>
						<option>dl</option>
						<option>l</option>
						<option>Stk.</option>
						<option>Tl.</option>
						<option>El.</option>
						<option>Msp.</option>
					</select>
				</dd>
			</dl>
		</div>
		
		<!-- jqote templates -->
		<script type="text/x-jqote-template" id="tmpl-new-step">
		<![CDATA[
			<fieldset class="step" data-id="<%= this.step %>">
				<legend>Schritt <%= this.step %></legend>
				<dl>
					<dt><label for="step-<%= this.step %>-title">Titel</label></dt>
					<dd><input type="text" name="step[<%= this.step %>][title]" id="step-<%= this.step %>-title" placeholder="Schritt ..."></dd>

					<dt><label for="step-<%= this.step %>-duration">Dauer</label></dt>
					<dd><input type="text" name="step[<%= this.step %>][duration]" id="step-<%= this.step %>-duration" placeholder="Dauer ..."></dd>

					<dt><label for="step-<%= this.step %>-image">Bild</label></dt>
					<dd><input type="file" name="step[<%= this.step %>][image]" id="step-<%= this.step %>-image"></dd>

					<dt><label for="step-<%= this.step %>-ingredients">Zutaten</label> <a href="#" class="add-ingredient" data-step="<%= this.step %>">Hinzufügen</a></dt>
					<dd><ul id="step-<%= this.step %>-ingredients" class="square"></ul></dd>

					<dt><label for="step-<%= this.step %>-description">Beschreibung</label></dt>
					<dd><textarea name="step[<%= this.step %>][description]" id="step-<%= this.step %>-description" placeholder="Schritt ..."></textarea></dd>
				</dl>
			</fieldset>
		]]>
		</script>
		<!-- end jqote templates -->
	</body>
</html>