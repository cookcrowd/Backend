<h1>Listenansicht</h1>

<table class="table table-striped">
  <thead>
    <tr>
      <th colspan="5">Die letzten Rezepte</th>
    </tr>
    <tr>
      <th></th>
      <th>Titel</th>
      <th>Dauer</th>
      <th>Zutaten</th>
      <th></th>
    </tr>
  </thead>
  <tbody>

    <?php foreach($latestRecipes as $recipe): ?>
    <tr>
      <td class="recipe-image">
        <img src="assets/<?php echo $recipe->getImage(); ?>" alt="<?php echo $recipe->getTitle(); ?>">
      </td>
      <td><?php echo $recipe->getTitle(); ?></td>
      <td><?php echo $recipe->formatPreparationTime(); ?></td>
      <td><?php echo $recipe->getIngredients(', '); ?></td>
      <td class="right">
        <div class="btn-group">
          <button class="btn btn-small btn-danger" data-toggle="modal" data-target="#confirm-delete"><i class="icon-trash icon-white"></i></button>
          <a href="manage/edit/<?php echo $recipe->getId(); ?>" class="btn btn-small"><i class="icon-edit"></i></a>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- delete modal -->
<div id="confirm-delete" class="modal fade" data-backdrop="true">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Löschen</h3>
  </div>
  <div class="modal-body">
    <p>Soll das Rezept wirklich gelöscht werden? Alle zugehörigen Daten gehen verloren!</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Abbrechen</a>
    <a href="#" class="btn btn-danger btn-primary">Löschen</a>
  </div>
</div>