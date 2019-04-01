{extends file='template.tpl'}

{block name="content"}
	<h2>Ajouter un serveur</h2>
	<div class="row">
		<form class="col-md-6" method="post">
			<div class="form-group">
				<label for="server">Serveur</label>
				<select name="server" id="server" class="form-control">
					{foreach from=$servers item=$server}
						<option value="{$server->id}">{$server->name}</option>
					{/foreach}
				</select>
			</div>

			<div class="form-group">
				<label for="node">Nom promox</label>
				<input type="text" name="node" class="form-control" id="node" placeholder="Nom promox" required>
			</div>

			<div class="checkbox">
				<label>
					<input type="checkbox" name="active"> Livraisons activés
				</label>
			</div>

			<div class="text-right">
				<button type="submit" class="btn btn-primary">Valider</button>
			</div>
		</form>
	</div>
{/block}