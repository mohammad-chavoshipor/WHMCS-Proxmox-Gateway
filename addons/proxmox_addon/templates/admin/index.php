<?php include 'includes/header.php'; ?>

<div class="row">
	<div class="col-md-6">
		<h2>Liste des VMS</h2>
	</div>
</div>
<br>

<?php if ($this->flash->has('error')): ?>
    <div class="alert alert-danger">
        <strong>Erreur : </strong> <?= $this->flash->get('error') ?>
    </div>
<?php endif; ?>

<?php if ($this->flash->has('success')): ?>
    <div class="alert alert-success">
        <strong>Succès : </strong> <?= $this->flash->get('success') ?>
    </div>
<?php endif; ?>

<table class="table-product">
	<thead>
		<tr>
		    <th>Nom du produit</th>
		    <th>Limite par achat</th>
		    <th>Limite totale</th>
		    <th>Activé</th>
		    <th>Actions</th>
	    </tr>
	</thead>
	<tbody>
	   
	</tbody>
</table>
<pre><?php var_dump($servers); ?></pre>