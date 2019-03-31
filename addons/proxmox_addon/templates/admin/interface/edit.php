<?php require dirname(__DIR__) . '/includes/header.php'; ?>

<h2>Ajouter une limite à un produit</h2>

<div class="row">
  <form class="col-md-6" method="post">
	
	<div class="form-group">
		<label for="name">Nom</label>
		<input type="text" name="name" class="form-control" id="name" value="<?= $interface->name ?>" required>
	</div>

	<div class="form-group">
		<label for="rate">Limitation de débit (Mb/s)</label>
		<input type="text" name="rate" class="form-control" id="rate" value="<?= $interface->rate ?>" placeholder="Limitation en Mb/s" required>
	</div>

    <div class="text-right">
      <button type="submit" class="btn btn-primary">Valider</button>
    </div>

  </form>
</div>