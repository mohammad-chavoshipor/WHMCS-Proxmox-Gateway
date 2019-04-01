{extends file='template.tpl'}

{block name="content"}
	<h2>Gérer un serveur</h2>
	<div class="row">
		<form class="col-md-6" method="post">
			<div class="form-group">
				<label for="server">Serveur</label>
				<input name="server" id="server" class="form-control" value="{$node->server->name}" disabled>
			</div>

			<div class="form-group">
				<label for="node">Nom promox</label>
				<input type="text" name="node" class="form-control" id="node" value="{$node->node}" required>
			</div>

			<div class="checkbox">
				<label>
					<input type="checkbox" name="active" {if $node->active}checked{/if}> Livraisons activés
				</label>
			</div>

			<div class="text-right">
				<button type="submit" class="btn btn-primary">Valider</button>
			</div>
		</form>
	</div>
{/block}
