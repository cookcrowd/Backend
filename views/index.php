<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="<?php echo ZURV_BASE_HREF; ?>">
    
    <meta charset="utf-8">
    <title>cookielicious - your favorite recipes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">cookielicious</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Rezepte <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Neues Rezept</a></li>
                  <li class="divider"></li>
                  <li><a href="manage/list">Liste</a></li>
                  <li><a href="#">Suche</a></li>
                </ul>
              </li>
              <li><a href="manage/ingredients">Zutatenliste</a></li></li>
              <li><a href="manage/assets">Bilder</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <?php echo $content; ?>

      <hr>

      <footer>
        <p>&copy; cookcrowd 2012</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.7.js"></script>
    <script src="js/bootstrap/bootstrap-transition.js"></script>
    <script src="js/bootstrap/bootstrap-alert.js"></script>
    <script src="js/bootstrap/bootstrap-modal.js"></script>
    <script src="js/bootstrap/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap/bootstrap-tab.js"></script>
    <script src="js/bootstrap/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap/bootstrap-popover.js"></script>
    <script src="js/bootstrap/bootstrap-button.js"></script>
    <script src="js/bootstrap/bootstrap-collapse.js"></script>
    <script src="js/bootstrap/bootstrap-carousel.js"></script>
    <script src="js/bootstrap/bootstrap-typeahead.js"></script>

  </body>
</html>
<!--
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
    
  </body>
</html>
-->