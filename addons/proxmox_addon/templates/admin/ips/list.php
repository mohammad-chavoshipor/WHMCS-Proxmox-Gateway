<?php require dirname(__DIR__) . '/includes/header.php'; ?>

<div class="text-right">
	<a href="<?= $this->route->to('ip', ['method' => 'add']) ?>" class="btn btn-sm btn-primary">
	    <i class="fa fa-plus fa-fw"></i>
	    <span class="hidden-md">Ajouter</span>
	</a>
</div>
<br>

<table class="table-product">
	<thead>
		<tr>
		    <th>IP</th>
		    <th>Masque</th>
		    <th>Passrelle</th>
		    <th>Cluster</th>
		    <th>Status</th>
		    <th>Service</th>
		    <th>Actions</th>
	    </tr>
	</thead>
	<tbody>
	    <?php foreach ($ips as $ip): ?>
        <tr>
        	<td><?= $ip->ip ?></td>
        	<td><?= $ip->netmask ?></td>
        	<td><?= $ip->gateway ?></td>
        	<td><?= $ip->cluster->name ?></td>
        	<td><?= $ip->active ? '<span class="label label-success">Publique</span>' : '<span class="label label-danger">Privée</span>'  ?></td>
        	<td><?= !$ip->used ? '<span class="label label-success">Libre</span>' : '<a href="clientsservices.php?id='.$ip->service_id.'">Voir</a>'  ?></td>
        	<td>
                <div class="btn-group">
                    <a onclick="return confirm('Voulez vous vraiment supprimer cette ip ? ')" href="<?= $this->route->to('ip', ['method' => 'delete', 'id' => $ip->id]) ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash fa-fw"></i></a>
                    <a href="<?= $this->route->to('ip', ['method' => 'edit', 'id' => $ip->id]) ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit fa-fw"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
	</tbody>
</table>