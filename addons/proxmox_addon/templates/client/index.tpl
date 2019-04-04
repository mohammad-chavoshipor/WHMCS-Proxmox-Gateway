<div class="text-right" style="padding-top: 10px;">
	<a href="index.php?m=proxmox_addon&action=index&method=add" class="btn btn-default"><i class="fas fa-plus"></i> Add a key</a>
</div>

{if $flash->has('error')}
    <div class="alert alert-danger">
        <strong>Error : </strong> {$flash->get('error')}
    </div>
{/if}

{if $flash->has('success')}
    <div class="alert alert-success">
        <strong>Success : </strong> {$flash->get('success')}
    </div>
{/if}

<table class="table table-striped">
	<thead>
		<tr>
			<th width="90%">Name</th>
			<th>Action</th>
		</tr>
	</thead>

	<tbody>
		{foreach from=$ssh item=key}
		<tr>
			<td>{$key->name}</td>
			<td><a href="index.php?m=proxmox_addon&action=index&method=delete&id={$key->id}" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a></td>
		</tr>
		{/foreach}
	</tbody>

</table>