<tr>
	<td class="fieldarea" colspan="4" style="padding: 10px;font-weight: bold;background: #2162A3; color: white">Configuration de base</td>
</tr>

<tr>
	<td class="fieldlabel"  width="20%">Type</td>
	<td class="fieldarea">
		<select name="packageconfigoption[1]" class="form-control input-400">
			<option value="1" selected="selected">LXC</option>
		</select>
	</td>
</tr>
<tr>
	<td class="fieldlabel">Cluster</td>
	<td class="fieldarea">
	   	<select name="packageconfigoption[2]" id="cluster" class="form-control input-400">
	   		<?php foreach ($clusters as $cluster): ?>
				<option value="<?= $cluster->id ?>" <?= ($product->configoption2 === $cluster->id ? 'selected' : '') ?>><?= $cluster->name ?></option>
			<?php endforeach; ?>
	   	</select>
	</td>
</tr>

<tr>
	<td class="fieldlabel">Démarrage</td>
	<td class="fieldarea">
		<label class="checkbox-inline">
			<input type="hidden" name="packageconfigoption[3]">
			<input type="checkbox" name="packageconfigoption[3]" <?= ($product->configoption3 ? 'active' : '') ?>> Lancer au boot de la machine
		</label>
	</td>
</tr>
	<td class="fieldlabel">Notes</td>
    <td class="fieldarea">
    	<textarea class="form-control input-400" name="packageconfigoption[4]" cols="60" rows="5">
<?php if ($product->configoption4): ?>
<?= $product->configoption4 ?>
<?php else: ?>
Client: {$client_name}  (ID: {$client_id})
Email: {$client_email}
Service ID: {$service_id}
Product:  {$product_name} (ID: {$product_id})
<?php endif; ?>
    	</textarea>
    </td>
</tr>

<tr>
	<td class="fieldarea" colspan="4" style="padding: 10px;font-weight: bold;background: #2162A3; color: white">Ressources</td>
</tr>

<tr>
	<td class="fieldlabel">Cœurs CPU</td>
	<td class="fieldarea">
		<input type="text" name="packageconfigoption[5]" class="form-control input-400" value="<?= ($product->configoption5 ? $product->configoption5 : '0') ?>">
		<p class="text-muted" style="padding-top: 5px;margin-bottom: 5px;">Laisser 0 pour donner l'accès à tous les cœurs.</p>
	</td>
</tr>

<tr>
	<td class="fieldlabel">Espace disque</td>
	<td class="fieldarea">
		<div class="input-group input-400">
			<input type="text" name="packageconfigoption[6]" class="form-control" value="<?= ($product->configoption6 ? $product->configoption6 : '10') ?>">
			<span class="input-group-addon">Go</span>
		</div>
	</td>
</tr>
<tr>
	<td class="fieldlabel">Emplacement du disque système</td>
	<td class="fieldarea">
		<input type="text" name="packageconfigoption[7]" class="form-control input-400" value="<?= ($product->configoption7 ? $product->configoption7 : 'local') ?>">
	</td>
</tr>
<tr>
	<td class="fieldlabel">Ram</td>
	<td class="fieldarea">
		<div class="input-group input-400">
			<input type="text" name="packageconfigoption[8]" class="form-control" value="<?= ($product->configoption8 ? $product->configoption8 : '2048') ?>">
			<span class="input-group-addon">Mo</span>
		</div>
	</td>
</tr>
<tr>
	<td class="fieldlabel">Swap</td>
	<td class="fieldarea">
		<div class="input-group input-400">
			<input type="text" name="packageconfigoption[9]" class="form-control" value="<?= ($product->configoption9 ? $product->configoption9 : '1024') ?>">
			<span class="input-group-addon">Mo</span>
		</div>
	</td>
</tr>
  
<tr>
	<td class="fieldarea" colspan="4" style="padding: 10px;font-weight: bold;background: #2162A3; color: white">Backups</td>
</tr>

<tr>
	<td class="fieldlabel">Nombre de backups</td>
	<td class="fieldarea">
		<input type="text" name="packageconfigoption[10]" class="form-control input-400" value="<?= ($product->configoption10 ? $product->configoption10 : '-1') ?>">
		<p class="text-muted" style="padding-top: 5px;margin-bottom: 5px;">Laisser -1 pour n'appliquer aucune limite</p>
</td>
</tr>
<tr>
	<td class="fieldlabel">Emplacement du disque backup</td>
	<td class="fieldarea">
		<input type="text" name="packageconfigoption[11]" class="form-control input-400" value="<?= ($product->configoption11 ? $product->configoption11 : 'local') ?>">
	</td>
</tr>
<tr>
	<td class="fieldlabel">Nombre de jours de conservation des backups</td>
	<td class="fieldarea">
		<input type="text" name="packageconfigoption[12]" class="form-control input-400" value="<?= ($product->configoption12 ? $product->configoption12 : '-1') ?>">
		<p class="text-muted" style="padding-top: 5px;margin-bottom: 5px;">Laisser -1 pour n'appliquer aucune limite</p>
	</td>
</tr>

<tr>
	<td class="fieldarea" colspan="4" style="padding: 10px;font-weight: bold;background: #2162A3; color: white">Réseau</td>
</tr>
<tr>
	<td class="fieldlabel">Eth0</td>
	<td class="fieldarea">
		<select name="packageconfigoption[13]" class="bridge form-control input-400">
			<option value="-1">Aucune interface</option>
			<?php var_dump($interfaces) ?>
	   		<?php foreach ($interfaces as $interface): ?>
				<option value="<?= $interface->id ?>" <?= ($product->configoption13 == $interface->id ? 'selected' : '') ?>><?= $interface->name ?></option>
			<?php endforeach; ?>
	   	</select>
		<p class="help-block hidden">Chargement des interfaces ...</p>
	</td>
</tr>

<tr>
	<td class="fieldlabel">Eth1</td>
	<td class="fieldarea">
		<select name="packageconfigoption[14]" class="bridge form-control input-400">
			<option value="-1">Aucune interface</option>
	   		<?php foreach ($interfaces as $interface): ?>
				<option value="<?= $interface->id ?>" <?= ($product->configoption14 == $interface->id ? 'selected' : '') ?>><?= $interface->name ?></option>
			<?php endforeach; ?>
	   	</select>
		<p class="help-block hidden">Chargement des interfaces ...</p>
	</td>
</tr>

<tr>
	<td class="fieldlabel">Eth2</td>
	<td class="fieldarea">
		<select name="packageconfigoption[15]" class="bridge form-control input-400">
			<option value="-1">Aucune interface</option>
	   		<?php foreach ($interfaces as $interface): ?>
				<option value="<?= $interface->id ?>" <?= ($product->configoption15 == $interface->id ? 'selected' : '') ?>><?= $interface->name ?></option>
			<?php endforeach; ?>
	   	</select>
		<p class="help-block hidden">Chargement des interfaces ...</p>
	</td>
</tr>

<tr>
	<td class="fieldlabel">Eth3</td>
	<td class="fieldarea">
		<select name="packageconfigoption[16]" class="bridge form-control input-400">
			<option value="-1">Aucune interface</option>
	   		<?php foreach ($interfaces as $interface): ?>
				<option value="<?= $cluster->id ?>" <?= ($product->configoption16 == $interface->id ? 'selected' : '') ?>><?= $interface->name ?></option>
			<?php endforeach; ?>
	   	</select>
		<p class="help-block hidden">Chargement des interfaces ...</p>
	</td>
</tr>



<script>
		
	let lock = 0;

	$('form').submit(function (e) {
		if (lock) e.preventDefault();
	})

	let select = function() {
		let id = $('#cluster option:selected').val();
		let route = 'addonmodules.php?module=proxmox_addon&action=api&method=interfaces';

		$('.help-block')
			.removeClass('hidden')
			.html('Chargement des interfaces ...');

		$('.bridge').prop('disabled', false);
		$('.btn-primary').prop('disabled', false);
		$('.bridge option').remove();

		$.get(`${route}&id=${id}`, function (data) {
			lock = 0;
			$('.help-block').addClass('hidden');

			if (!data.success) {
				$('.help-block')
					.removeClass('hidden')
					.html(data.message);
				$('.bridge').prop('disabled', true);
				$('.btn-primary').prop('disabled', true);
				lock = 1;
				return;
			}

			$('.bridge')
					.append($('<option></option>')
						.attr('value', '-1')
						.text('Aucune interface')
					);

			for (let interface of data.interfaces) {
				$('.bridge')
					.append($('<option></option>')
						.attr('value', interface.id)
						.text(interface.name)
					);
			}
		});
	}

	$('#cluster').change(select);
</script>