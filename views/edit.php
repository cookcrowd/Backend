<h1>Bearbeiten <small>ID: <?php echo $recipe->getId(); ?> - <?php echo $recipe->getTitle(); ?></small></h1>

<form class="form-horizontal">
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
  <fieldset>
    <legend>Schritt <?php echo ++$i; ?></legend>

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
          <input type="text" class="input-mini add-ingredient-amount text-centered"><button class="btn dropdown-toggle" data-toggle="dropdown"><span class="ingredient-unit">g</span> <span class="caret"></span></button>
          <ul class="dropdown-menu pull-right tiny text-right">
            <li><a href="#">l</a></li>
            <li><a href="#">ml</a></li>
          </ul>
        </div>

        <input type="text" class="input-medium add-ingredient">
        <button class="btn"><i class="icon-plus"></i></button>

        <p class="help-block ingredients">
          <?php foreach($step->getIngredients() as $ingr): ?>
          <span class="label">
            <?php echo $ingr->getAmount() . ' ' . $ingr->getUnit() . ' ' . $ingr->getName(); ?>
            <a href="#" class="append"><i class="icon-trash icon-white"></i></a>
          </span>
          <?php endforeach; ?>
        </p>
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
    <button type="submit" class="btn btn-primary">Speichern</button>
    <button class="btn">Abbrechen</button>
  </div>
</form>