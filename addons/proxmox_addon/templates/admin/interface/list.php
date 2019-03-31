<?php require dirname(__DIR__) . '/includes/header.php'; ?>

<div class="text-right">
    <a href="<?= $this->route->to('interface', ['method' => 'add']) ?>" class="btn btn-sm btn-primary">
        <i class="fa fa-plus fa-fw"></i>
        <span class="hidden-md">Ajouter</span>
    </a>
</div>
<br>

<table class="table-product">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Cluster</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($interfaces as $interface): ?>
        <tr>
            <td><?= $interface->name ?></td>
            <td><?= $interface->cluster->name ?></td>
            <td>
                <div class="btn-group">
                    <a onclick="return confirm('Voulez vous vraiment supprimer cette interface ? ')" href="<?= $this->route->to('interface', ['method' => 'delete', 'id' => $interface->id]) ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash fa-fw"></i></a>
                    <a href="<?= $this->route->to('interface', ['method' => 'edit', 'id' => $interface->id]) ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit fa-fw"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>