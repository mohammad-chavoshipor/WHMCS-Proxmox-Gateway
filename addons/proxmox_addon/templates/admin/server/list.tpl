{extends file='template.tpl'}

{block name="content"}
	<div class="row">
		<div class="col-md-8">
			<h2>Cluster #{$cluster->id} - Gestion des serveurs</h2>
		</div>
		<div class="col-md-4 text-right">
			<a href="{$route->to('server', ['method' => 'add', 'cluster' => $cluster->id])}" class="btn btn-sm btn-primary">
				<i class="fa fa-plus fa-fw"></i>
				<span class="hidden-md">Ajouter</span>
			</a>
		</div>
	</div>


	<br>

	<table class="table-product">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Nom Proxmox</th>
				<th>Livraison actives</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$cluster->nodes item=$node}
			<tr>
				<td>{$node->server->name}</td>
				<td>{$node->node}</td>
				<td>{if $node->active}<span class="label label-success">Oui</span>{else}<span class="label label-danger">Non</span>{/if}</td>
				<td>
					<div class="btn-group">
						<a onclick="return confirm('Voulez vous vraiment suppimer ce serveur ?');" href="{$route->to('server', ['method' => 'delete', 'id' => $node->id, 'cluster' => $cluster->id])}" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-fw"></i></a>
						<a href="{$route->to('server', ['method' => 'edit', 'cluster' => $cluster->id, 'id' => $node->id])}" class="btn btn-sm btn-primary"><i class="fa fa-edit fa-fw"></i></a>
					</div>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
{/block}