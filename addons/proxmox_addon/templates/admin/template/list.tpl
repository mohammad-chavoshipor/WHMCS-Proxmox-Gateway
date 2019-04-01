{extends file='template.tpl'}

{block name="content"}

	<div class="text-right">
		<a href="{$route->to('template', ['method' => 'add'])}" class="btn btn-sm btn-primary">
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
			{foreach from=$templates item=$template}
			<tr>
				<td>{$template->name}</td>
				<td>{$template->cluster->name}</td>
				<td>
					<div class="btn-group">
						<a onclick="return confirm('Voulez vous vraiment supprimer cette template ? ')" href="{$route->to('template', ['method' => 'delete', 'id' => $template->id])}" class="btn btn-xs btn-danger"><i class="fa fa-trash fa-fw"></i></a>
						<a href="{$route->to('template', ['method' => 'edit', 'id' => $template->id])}" class="btn btn-xs btn-primary"><i class="fa fa-edit fa-fw"></i></a>
					</div>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
{/block}