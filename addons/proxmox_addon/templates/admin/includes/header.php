<style>
	.table-product th{
		background: #1A4D80;
		color: #fff;
		padding: 5px;
	}

	.table-product th:not(:first-child){
		border-left: 2px solid;
	}

	table {
		width: 100%;
	}

	td {
		padding: 5px;
	}
</style>

<ul class="nav nav-tabs">
	<li <?= (!$_GET['action'] || $_GET['action'] === 'index') ? 'class="active"' : '' ?>>
		<a href="<?= $this->route->to('index') ?>">Accueil</a>
	</li>
	<li <?= ($_GET['action'] === 'cluster' || $_GET['action'] === 'server') ? 'class="active"' : '' ?>><a href="<?= $this->route->to('cluster') ?>">Clusters</a></li>
	<li <?= ($_GET['action'] === 'ip') ? 'class="active"' : '' ?>><a href="<?= $this->route->to('ip') ?>">Ips</a></li>
	<li <?= ($_GET['action'] === 'interface') ? 'class="active"' : '' ?>><a href="<?= $this->route->to('interface') ?>">Interfaces</a></li>
	<li <?= ($_GET['action'] === 'template') ? 'class="active"' : '' ?>><a href="<?= $this->route->to('template') ?>">Templates</a></li>
</ul>
<br>

<?php if ($this->flash->has('error')): ?>
  <div class="alert alert-danger">
    <strong>Erreur : </strong> <?= $this->flash->get('error') ?>
  </div><br>
<?php endif; ?>

<?php if ($this->flash->has('success')): ?>
    <div class="alert alert-success">
        <strong>Succès : </strong> <?= $this->flash->get('success') ?>
    </div><br>
<?php endif; ?>
