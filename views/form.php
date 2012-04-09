<?php if($recipe->getId() !== -1): ?>
<h1>Bearbeiten <small>ID: <?php echo $recipe->getId(); ?> - <?php echo $recipe->getTitle(); ?></small></h1>
<?php else: ?>
<h1>Neues Rezept <small>Ein neues Rezept anlegen</small></h1>
<?php endif; ?>

<form class="form-horizontal" method="post" enctype="multipart/form-data">
  <fieldset>
    <legend>Metadaten</legend>
    <div class="control-group">
      <label class="control-label" for="title">Titel</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="title" value="<?php echo $recipe->getTitle(); ?>">
        <!-- <p class="help-block">Supporting help text</p> -->
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="preparation_time">Zubereitungsdauer</label>
      <div class="controls">
        <input type="text" class="input-mini text-centered" id="preparation_time" value="<?php echo $recipe->getPreparationTime(); ?>">
        <span class="help-inline">in Minuten</span>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="image">Vorschau</label>
      <div class="controls">
        <input type="file" class="input-xlarge" id="image" accept="image/jpg,image/jpeg,image/gif,image/png">
        <span class="help-inline">Bilddateien (.jpg, .gif, .png)</span>
      </div>
    </div>
  </fieldset>
  <?php $i = 0; foreach($recipe->getSteps() as $step): ?>
  <fieldset data-step="<?php echo ++$i; ?>">
    <legend>Schritt <?php echo $i; ?></legend>

    <div class="control-group">
      <label class="control-label" for="steps-<?php echo $i; ?>-titel">Titel</label>
      <div class="controls">
        <input type="text" class="input-xlarge" name="steps[<?php echo $i; ?>][titel]" id="steps-<?php echo $i; ?>-titel" value="<?php echo $step->getTitle(); ?>">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="steps-<?php echo $i; ?>-duration">Dauer</label>
      <div class="controls">
        <input type="text" class="input-mini text-centered" name="steps[<?php echo $i; ?>][duration]" id="steps-<?php echo $i; ?>-duration" value="<?php echo $step->getDuration(); ?>">
        <span class="help-inline">in Minuten</span>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="steps-<?php echo $i; ?>-duration">Zutaten</label>
      <div class="controls">
        <div class="input-append dropdown">
          <input type="text" class="input-mini add-ingredient-amount text-centered"><button class="btn dropdown-toggle add-ingredient-amount" data-toggle="dropdown"><span class="ingredient-unit">g</span> <span class="caret"></span></button>
          <ul class="dropdown-menu pull-right tiny text-right add-ingredient-amount">
            <li><a href="#">g</a></li>
            <li><a href="#">l</a></li>
            <li><a href="#">ml</a></li>
          </ul>
        </div>

        <input type="text" class="input-medium add-ingredient" data-provide="typeahead">
        <button class="btn add-ingredient"><i class="icon-plus"></i></button>

        <p class="help-block ingredients">
          <?php foreach($step->getIngredients() as $ingr): ?>
          <span class="label ingredient">
            <input type="hidden" name="steps[<?php echo $i; ?>][ingredients][amount][]" value="<?php echo $ingr->getAmount(); ?>">
            <input type="hidden" name="steps[<?php echo $i; ?>][ingredients][unit][]" value="<?php echo $ingr->getUnit(); ?>">
            <input type="hidden" name="steps[<?php echo $i; ?>][ingredients][ingredient][]" value="<?php echo $ingr->getName(); ?>">
            <?php echo $ingr->getAmount() . ' ' . $ingr->getUnit() . ' ' . $ingr->getName(); ?>
            <a href="#" class="append"><i class="icon-trash icon-white"></i></a>
          </span>
          <?php endforeach; ?>
        </p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="steps-<?php echo $i; ?>-todos">To-Dos</label>
      <div class="controls">
        <textarea class="input-xlarge" name="steps[<?php echo $i; ?>][todos]" id="steps-<?php echo $i; ?>-todos" rows="6"></textarea>
        <span class="help-inline">neue Zeile für neues To-Do</span>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="steps-<?php echo $i; ?>-timeable">Timer setzen?</label>
      <div class="controls">
        <label class="checkbox">
          <input type="checkbox" name="steps[<?php echo $i; ?>][timeable]" id="steps-<?php echo $i; ?>-timeable" <?php echo $step->isTimeable() ? 'checked="checked"' : ''; ?>>
        </label>
      </div>
    </div>  

    <div class="control-group">
      <label class="control-label" for="steps-<?php echo $i; ?>-timername">Timername</label>
      <div class="controls">
        <input type="text" class="input-xlarge" name="steps[<?php echo $i; ?>][timername]" id="steps-<?php echo $i; ?>-timername" value="<?php echo $step->getTimerName(); ?>">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="steps-<?php echo $i; ?>-image">Bild</label>
      <div class="controls">
        <input type="file" class="input-xlarge" name="steps[<?php echo $i; ?>][image]" id="steps-<?php echo $i; ?>-image" accept="image/jpg,image/jpeg,image/gif,image/png">
        <span class="help-inline">Bilddateien (.jpg, .gif, .png)</span>
      </div>
    </div>
      
  </fieldset>
  <?php endforeach; ?>

  <div class="form-actions">
    <div class="btn-toolbar">
      <div class="btn-group">  
        <button class="btn add-step"><i class="icon-plus"></i> Weiterer Schritt</button>
        <button class="btn">Abbrechen</button>
      </div>
      <div class="btn-group">
        <button type="submit" class="btn btn-primary">Speichern</button>
      </div>
    </div>
  </div>
</form>

<!-- jqote template -->
<script type="text/x-jqote-template" id="tpl-step">
<fieldset data-step="<%= this.step %>">
  <legend>Schritt <%= this.step %></legend>

  <div class="control-group">
    <label class="control-label" for="steps-<%= this.step %>-titel">Titel</label>
    <div class="controls">
      <input type="text" class="input-xlarge" name="steps[<%= this.step %>][titel]" id="steps-<%= this.step %>-titel" value="">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="steps-<%= this.step %>-duration">Dauer</label>
    <div class="controls">
      <input type="text" class="input-mini text-centered" name="steps[<%= this.step %>][duration]" id="steps-<%= this.step %>-duration" value="">
      <span class="help-inline">in Minuten</span>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="steps-<%= this.step %>-duration">Zutaten</label>
    <div class="controls">
      <div class="input-append dropdown">
        <input type="text" class="input-mini add-ingredient-amount text-centered"><button class="btn dropdown-toggle" data-toggle="dropdown"><span class="ingredient-unit">g</span> <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right tiny text-right add-ingredient-amount">
          <li><a href="#">l</a></li>
          <li><a href="#">ml</a></li>
        </ul>
      </div>

      <input type="text" class="input-medium add-ingredient">
      <button class="btn add-ingredient"><i class="icon-plus"></i></button>

      <p class="help-block ingredients"></p>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="steps-<%= this.step %>-todos">To-Dos</label>
    <div class="controls">
      <textarea class="input-xlarge" name="steps[<%= this.step %>][todos]" id="steps-<%= this.step %>-todos" rows="6"></textarea>
      <span class="help-inline">neue Zeile für neues To-Do</span>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="steps-<%= this.step %>-timeable">Timer setzen?</label>
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox" name="steps[<%= this.step %>][timeable]" id="steps-<%= this.step %>-timeable">
      </label>
    </div>
  </div>  

  <div class="control-group">
    <label class="control-label" for="steps-<%= this.step %>-timername">Timername</label>
    <div class="controls">
      <input type="text" class="input-xlarge" name="steps[<%= this.step %>][timername]" id="steps-<%= this.step %>-timername" value="">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="steps-<%= this.step %>-image">Bild</label>
    <div class="controls">
      <input type="file" class="input-xlarge" name="steps[<%= this.step %>][image]" id="steps-<%= this.step %>-image" accept="image/jpg,image/jpeg,image/gif,image/png">
      <span class="help-inline">Bilddateien (.jpg, .gif, .png)</span>
    </div>
  </div>
    
</fieldset>
</script>
<!-- end jqote template -->