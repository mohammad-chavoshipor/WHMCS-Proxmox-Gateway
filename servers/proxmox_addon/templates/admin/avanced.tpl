<div class="modal fade" id="module_reinstall" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content panel panel-primary">
			<div class="modal-header panel-heading">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Confirm reinstall</h4>
			</div>
			<div class="modal-body panel-body">
			<p><strong>Please select an os :</strong></p>
			<select id="os-list" class="form-control">
				{foreach from=$templates item=$template}
					<option value="{$template->id}">{$template->name}</option>;
				{/foreach}
			</select>
			</div>
			<div class="modal-footer panel-footer">
				<button type="button" class="btn btn-primary" onclick="runReinstall()">
					Reinstall
				</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Cancel
				</button>
			</div>
		</div>
	</div>
</div>

<button type="button" class="btn btn-default" onclick="jQuery('#module_reinstall').modal('show');">Reinstall</button>
<button type="button" class="btn btn-default" onclick="openConsole()">Console</button>

<script>
	function openConsole() {
		window.open("{$url}", "Console", "width=800,height=600");
		window.close();
	}
	function runReinstall() {
		$("#module_reinstall .btn-primary").attr("disabled", true);
		

		$.post("clientsservices.php", {
				modop: "custom",
				token: csrfToken,
				id: $("input[name=id]").val(),
				userid: $("input[name=userid]").val(),
				ajax: 1,
				ac: "reinstall",
				os: $("#os-list").val()
			})
			.done(function( data ) {
				location.reload();
			});
	}
</script>