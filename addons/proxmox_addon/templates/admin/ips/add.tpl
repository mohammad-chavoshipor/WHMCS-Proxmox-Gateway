{extends file='template.tpl'}

{block name="content"}
	<div class="row">
		<div class="col-md-6">
			<form method="post">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="ip">IP</label>
							<input type="text" name="ip" class="form-control" id="ip" placeholder="IP" required>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="netmask">Masque</label>
							<input type="number" name="netmask" class="form-control" id="netmask" max="32" placeholder="Masque" required>
							<p class="help-block">Notation CIDR</p>
						</div>
					</div>
			
				</div>

				<div class="form-group">
					<label for="mac">MAC</label>
					<input type="text" name="mac" class="form-control" id="mac" placeholder="Adresse mac">
				</div>

				<div class="form-group">
					<label for="gateway">Passerelle</label>
					<input type="text" name="gateway" class="form-control" id="gateway" placeholder="Passerelle" required>
				</div>

				<div class="form-group">
					<label for="type">Type</label>
					<select name="type" id="type" class="form-control">
						<option value="4">IPv4</option>
						<option value="6">IPv6</option>
					</select>
				</div>

				<div class="form-group">
					<label for="cluster">Cluster</label>
						<select name="cluster" id="cluster" class="form-control">
						{foreach from=$clusters item=$cluster}
							<option value="{$cluster->id}">{$cluster->name}</option>
						{/foreach}
					</select>
				</div>

				<div class="checkbox">
					<label>
						<input type="checkbox" name="active"> Privée
					</label>
				</div>

				<div class="text-right">
					<input type="submit" class="btn btn-primary" value="Valider">
				</div>
			</form>
		</div>
	</div>
{/block}