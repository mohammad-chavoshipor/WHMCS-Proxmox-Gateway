{extends file='template.tpl'}

{block name="content"}
	<div class="row">
		<div class="col-md-6">
			<h2>Editer l'ip {$ip->ip}/{$ip->netmask}</h2>
		</div>
	</div>
	<div class="row mt-2">
		<form class="col-md-6" method="post">

			<div class="form-group">
				<label for="mac">MAC</label>
				<input type="text" name="mac" class="form-control" id="mac" placeholder="Adresse mac" value="{$ip->mac}">
			</div>

			<div class="checkbox">
				<label>
					<input type="checkbox" name="active" {if $ip->active}checked{/if}> Activé
				</label>
			</div>
		
			<div class="text-right">
				<button type="submit" class="btn btn-primary">Valider</button>
			</div>

		</form>
	</div>
{/block}
