<?php require dirname(__DIR__) . '/includes/header.php'; ?>
<div class=" text-right">
	<a href="<?= $this->route->to('cluster', ['method' => 'add']) ?>" class="btn btn-sm btn-primary">
    	 <i class="fa fa-plus fa-fw"></i>
    	 <span class="hidden-md">Ajouter</span>
    </a>
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
		    <th>Nom</th>
		    <th>Serveurs</th>
		    <th>Actions</th>
	    </tr>
	</thead>
	<tbody>
	    <?php foreach ($clusters as $cluster): ?>
        <tr>
        	<td><?= $cluster->name ?></td>
        	<td><?= $cluster->nodes->count() ?></td>
        
        	<td>
                <div class="btn-group">
                    <a onclick="return confirm('Voulez vous vraiment suppimer ce cluster ?');" href="<?= $this->route->to('cluster', ['method' => 'delete', 'id' => $cluster->id]) ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-fw"></i></a>
                    <a href="<?= $this->route->to('cluster', ['method' => 'edit', 'id' => $cluster->id]) ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit fa-fw"></i></a>
                    <a href="<?= $this->route->to('server', ['cluster' => $cluster->id]) ?>" class="btn btn-sm btn-info"><i class="fa fa-server fa-fw"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
	</tbody>
</table>