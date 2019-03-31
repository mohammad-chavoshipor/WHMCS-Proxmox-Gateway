<?php require dirname(__DIR__) . '/includes/header.php'; ?>

<div class="row">
	<div class="col-md-6">
		<form method="post">
			<div class="form-group">
				<label for="name">Nom</label>
				<input type="text" name="name" class="form-control" id="name" placeholder="Nom" required>
			</div>

			<div class="form-group">
				<label for="image">Chemin de l'image</label>
				<input type="text" name="image" class="form-control" id="image" placeholder="Chemin" required>
			</div>

			<div class="form-group">
				<label for="cluster">Cluster</label>
					<select name="cluster" id="cluster" class="form-control">
					<?php foreach ($clusters as $cluster): ?>
						<option value="<?= $cluster->id ?>"><?= $cluster->name ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="text-right">
				<input type="submit" class="btn btn-primary" value="Valider">
			</div>
		</form>
	</div>

	<div class="col-md-6">
		<div class="well well-sm">
			<p class="lead">Aide sur les chemins</p>

			<strong>LXC : </strong> 
			<ul>
				<li>Formattage du chemin : <code>local:vztmpl/image.tar.gz</code></li>
				<li>Liste les images disponibles : <code>pveam update && pveam available</code></li>
				<li>Télécharger une image : <code>pveam download local image.tar.gz</code></li>
				<li>Liste des images téléchargés : <code>pveam list local</code></li>
			</ul>
		</div>
	</div>
</div>