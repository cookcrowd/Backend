<h1>Zutatenliste</h1>

<table class="table table-striped">
  <thead>
    <tr>
      <th class="span4">Name</th>
      <th class="span1 text-centered">in Rezepten</th>
      <th class="span1">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($ingredients as $ingr): ?>
    <tr>
      <td><?php echo $ingr->getName(); ?></td>
      <td>&nbsp;</td>
      <td><button class="btn"><i class="icon-edit"></i></button></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>