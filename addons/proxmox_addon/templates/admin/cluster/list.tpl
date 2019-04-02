{extends file='template.tpl'}

{block name="content"}
	<div class=" text-right">
		<a href="{$route->to('cluster', ['method' => 'add'])}" class="btn btn-sm btn-primary">
			<i class="fa fa-plus fa-fw"></i>
			<span class="hidden-md">Ajouter</span>
		</a>
	</div>
	<br>

	<table class="table-product">
		<thead>
			<tr>
				<th>{$trans['name']}</th>
				<th>Serveurs</th>
				<th>IPs Disponibles</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$clusters item=$cluster}
			<tr>
				<td>{$cluster->name}</td>
				<td>{$cluster->nodes->count()}</td>
				<td>{$cluster->unusedIps()}/{$cluster->ips->count()}</td>
			
				<td>
					<div class="btn-group">
						<a onclick="return confirm('Voulez vous vraiment suppimer ce cluster ?');" href="{$route->to('cluster', ['method' => 'delete', 'id' => $cluster->id])}" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-fw"></i></a>
						<a href="{$route->to('cluster', ['method' => 'edit', 'id' => $cluster->id])}" class="btn btn-sm btn-primary"><i class="fa fa-edit fa-fw"></i></a>
						<a href="{$route->to('server', ['cluster' => $cluster->id])}" class="btn btn-sm btn-info"><i class="fa fa-server fa-fw"></i></a>
					</div>
				</td>
			</tr>
			 {/foreach}
		</tbody>
	</table>
{/block}