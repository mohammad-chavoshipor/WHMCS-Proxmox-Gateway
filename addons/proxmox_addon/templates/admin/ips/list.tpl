{extends file='template.tpl'}

{block name="content"}

	<div class="text-right">
		<a href="{$route->to('ip', ['method' => 'add'])}" class="btn btn-sm btn-primary">
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
			{foreach from=$ips item=$ip}
			<tr>
				<td>{$ip->ip}</td>
				<td>{$ip->netmask}</td>
				<td>{$ip->gateway}</td>
				<td>{$ip->cluster->name}</td>
				<td>{if $ip->active} <span class="label label-success">Publique</span>{else}<span class="label label-danger">Privée</span>{/if}</td>
				<td>{if !$ip->used} '<span class="label label-success">Libre</span>{else}<a href="clientsservices.php?id='.$ip->service_id.'">Voir</a>{/if}</td>
				<td>
					<div class="btn-group">
						<a onclick="return confirm('Voulez vous vraiment supprimer cette ip ? ')" href="{$route->to('ip', ['method' => 'delete', 'id' => $ip->id])}" class="btn btn-xs btn-danger"><i class="fa fa-trash fa-fw"></i></a>
						<a href="{$route->to('ip', ['method' => 'edit', 'id' => $ip->id])}" class="btn btn-xs btn-primary"><i class="fa fa-edit fa-fw"></i></a>
					</div>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
{/block}