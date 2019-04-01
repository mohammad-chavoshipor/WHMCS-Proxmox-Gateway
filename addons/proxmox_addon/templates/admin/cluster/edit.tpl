{extends file='template.tpl'}

{block name="content"}
	<h2>Editer un cluster</h2>

	<div class="row">
		<form class="col-md-6" method="post">
			<div class="form-group">
				<input type="text" name="name" class="form-control" id="name" value="{$cluster->name}" required>
			</div>

			<div class="text-right">
				<button type="submit" class="btn btn-primary">Valider</button>
			</div>
		</form>
	</div>
{/block}

