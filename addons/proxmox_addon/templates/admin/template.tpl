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
	<li {if !$action || $action  === 'index'}class="active"{/if}>
		<a href="{$route->to('index')}">{$trans['menu']['home']}</a>
	</li>
	<li {if $action === 'cluster' || $action === 'server'} class="active"{/if}>
		<a href="{$route->to('cluster')}">Clusters</a>
	</li>
	<li {if $action === 'ip'}class="active"{/if}>
		<a href="{$route->to('ip')}">IPs</a>
	</li>
	<li {if $action === 'interface'}class="active"{/if}>
		<a href="{$route->to('interface')}">Interfaces</a>
	</li>
	<li {if $action === 'template'}class="active"{/if}>
		<a href="{$route->to('template')}">Templates</a>
	</li>
</ul>
<br>

{if $flash->has('error')}
    <div class="alert alert-danger">
        <strong>{$trans['error']} : </strong> {$flash->get('error')}
    </div>
{/if}

{if $flash->has('success')}
    <div class="alert alert-success">
        <strong>{$trans['success']} : </strong> {$flash->get('success')}
    </div>
{/if}

{block name="content"}{/block}

<div class="text-center" style="margin-top: 50px;">
	<small>Promox Gateway by Uneo7 - Report issue to the project's <a target="_blank" href="https://github.com/Uneo7/WHMCS-Proxmox-Gateway">GitHub</a></small>
</div>