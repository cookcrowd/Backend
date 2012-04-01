<h1>Listenansicht</h1>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Die letzten Rezepte</th>
    </tr>
    <tr>
      <th></th>
      <th>Titel</th>
      <th>Dauer</th>
      <th>Zutaten</th>
      <th>
    </tr>
  </thead>
  <tbody>

    <?php foreach($latestRecipes as $recipe): ?>
    <tr>
      <td>Bild</td>
      <td><?php echo $recipe->getTitle(); ?></td>
      <td><?php echo $recipe->formatPreparationTime(); ?></td>
      <td><?php echo $recipe->getIngredients(', '); ?></td>
      <td class="right">
        <div class="btn-group">
          <button class="btn btn-small btn-danger"><i class="icon-trash icon-white"></i></button>
          <button class="btn btn-small"><i class="icon-edit"></i></button>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>