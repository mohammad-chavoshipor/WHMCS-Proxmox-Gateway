{extends file='template.tpl'}

{block name="content"}
	<h2>Ajouter une interface</h2>

	<div class="row">
		<form class="col-md-6" method="post">

		<div class="form-group">
			<label for="cluster">Cluster</label>
			<select name="cluster" id="cluster" class="form-control" required>
				{foreach from=$clusters item=$cluster}
					<option value="{$cluster->id}">{$cluster->name}</option>
				{/foreach}
			</select>
		</div>

		<div class="form-group">
			<label for="name">Nom</label>
			<input type="text" name="name" class="form-control" id="name" placeholder="Nom de l'interface" required>
		</div>

		<div class="form-group">
			<label for="rate">Limitation de débit</label>
			<input type="text" name="rate" class="form-control" id="rate" placeholder="Limitation en Mb/s" required>
		</div>

		<div class="form-group">
			<label for="ip4">IPv4</label>
			<select name="ip4" id="ip4" class="form-control" required>
				<option value="">Aucun</option>
				<option value="static">Statique</option>
				<option value="dhcp">DHCP</option>
			</select>
		</div>

		<div class="form-group">
			<label for="ip6">IPv6</label>
			<select name="ip6" id="ip6" class="form-control" required>
				<option value="">Aucun</option>
				<option value="static">Statique</option>
				<option value="dhcp">DHCP</option>
				<option value="auto">SLAAC</option>
			</select>
		</div>

		<div class="form-group">
			<label for="bridge">Carte réseau</label>
			<select name="bridge" id="bridge" class="form-control" required></select>
			<p class="help-block hidden">Chargement des interfaces ...</p>
		</div>

		<div class="text-right">
		  <button type="submit" class="btn btn-primary">Valider</button>
		</div>

	  </form>
		
		<div class="col-md-6">
			<div class="well well-sm">
				<p class="lead">Aide sur les interfaces</p>

				<strong>Bridge : </strong> La liste des interfaces est automatiquement récupérée depuis le premier serveur du cluster. Assurez-vous que tous les serveurs au sein du cluster disposent de ces interfaces. <br><br>
				<strong>IP : </strong> Statique attribura une automatiquement ip (v4 ou v6) assignée au cluster.
			</div>
		</div>

	</div>

	<script>
		const route = '{$route->to('api', ['method' => 'network'])}';
	</script>

	{literal}
	<script>
		let lock = 0;

		$('form').submit(function (e) {
			if (lock) e.preventDefault();
		})

		const select = function() {
			const id = $('#cluster option:selected').val();


			$('.help-block')
				.removeClass('hidden')
				.html('Chargement des interfaces ...');

			$('#bridge').prop('disabled', false);
			$('button').prop('disabled', false);
			$('#bridge option').remove();

			$.get(`${route}&id=${id}`, function (data) {
				lock = 0;
				$('.help-block').addClass('hidden');

				if (!data.success) {
					$('.help-block')
						.removeClass('hidden')
						.html(data.message);
					$('#bridge').prop('disabled', true);
					$('button').prop('disabled', true);
					lock = 1;
					return;
				}

				data.interfaces.forEach(function (value) {
					$('#bridge')
						.append($('<option></option>')
							.attr('value', value)
							.text(value)
						);
				});

			});
		}

		$('#cluster').change(select);

		select();

	</script>
	{/literal}
{/block}