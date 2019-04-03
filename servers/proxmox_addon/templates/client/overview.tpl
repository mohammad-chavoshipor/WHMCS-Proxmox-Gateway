<style>
	.swal2-popup {
		font-size: 1.6rem !important;
	}
</style>
{debug}
<div class="row">   
	<div class="col-md-6"> 
			<h3>        
				VPS Management
			</h3>
	</div>

	<div class="col-md-6 text-right" style="margin-top: 25px;"> 
		<div class="btn-group"> 
			{if $packagesupgrade && !$pendingcancellation}
				<a href="upgrade.php?type=package&amp;id={$id}" class="btn btn-success">
					<i class="fas fa-wrench"></i> {$LANG.upgrade}
				</a>
			{/if}

			<a href="clientarea.php?action=cancel&amp;id={$id}" class="btn btn-danger {if $pendingcancellation}disabled{/if}">
				{if $pendingcancellation}
					<i class="fas fa-times"></i> {$LANG.cancellationrequested}
				{else}
					<i class="fas fa-times"></i> {$LANG.cancel}
				{/if}
			</a>
		</div>
	</div>
</div>

{if $suspendreason}
	<div class="alert alert-danger">
		<h4>{$LANG.clientareasuspended}</h4>
		<strong>{$LANG.suspendreason} </strong>{$suspendreason}
	</div>
{/if}

{if !$suspendreason}
	
	<div class="row">
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<h3>        
						<span class="fa-stack">
							<i class="fas fa-circle fa-stack-2x"></i>
							<i class="fas fa-receipt fa-stack-1x fa-inverse"></i>
						</span>
						Billing Details
					</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">	
					<table class="table table-striped">
						<tr>
							<td><strong>{$LANG.clientareahostingregdate}</strong></td>
							<td>{$regdate}</td>
						</tr>
						<tr>
							<td><strong>{$LANG.recurringamount}</strong></td>
							<td>{$recurringamount}</td>
						</tr>
						<tr>
							<td><strong>{$LANG.clientareahostingnextduedate}</strong></td>
							<td>{$nextduedate}</td>
						</tr>
						<tr>
							<td><strong>{$LANG.orderbillingcycle}</strong></td>
							<td>{$billingcycle}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<h3>
						<span class="fa-stack">
							<i class="fas fa-circle fa-stack-2x"></i>
							<i class="fas fa-hdd fa-stack-1x fa-inverse"></i>
						</span>
						Server details
					</h3>
				</div>
			</div>
			<div class="row">	
				<div class="col-md-12">	
					<table class="table table-striped">
						<tr>
							<td><strong>{$LANG.serverhostname}</strong></td>
							<td>{$domain}</td>
						</tr>
						<tr>
							<td><strong>{$LANG.primaryIP}</strong></td>
							<td>{$dedicatedip}</td>
						</tr>
						<tr>
							<td><strong>{$LANG.assignedIPs}</strong></td>
							<td>{$assignedips|nl2br}</td>
						</tr>
						<tr>
							<td><strong>SSH Key</strong></td>
							<td>-</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div id="install" class="hidden text-center" style="margin-top: 30px;">
		<i class="fas fa-cog fa-spin fa-5x"></i>
		<h2>Get a <i class="fas fa-coffee"></i> and relax, we're dealing with the boring stuff.</h2>
		<p><i class="fas fa-coffee"></i> Get a cofee and relax</p>
	</div>

	<div id="reinstall" class="hidden text-center" style="margin-top: 30px;">
		<i class="fas fa-cog fa-spin fa-5x"></i>
		<h2>Reinstallation in progress ...</h2>
		<p>Get a <i class="fas fa-coffee"></i> and relax, we're dealing with the boring stuff.</p>
	</div>

	<div id="loader" class="text-center" style="margin-top: 30px;">
		<i class="fas fa-sync fa-spin fa-5x"></i>
		<h2>Loading ...</h2>
	</div>

	<div id="error" class="text-center hidden" style="margin-top: 30px;">
		<i class="fas fa-exclamation fa-5x text-danger"></i>
		<h3>Houston, we have a problem</h3>
		<p class="lead">An error has occured while trying to reach your server</h2>
	</div>

	<div class="hidden" id="infos">
		<div class="row">
			<div class="col-md-12">
				<h3>        
					<span class="fa-stack">
						<i class="fas fa-circle fa-stack-2x"></i>
						<i class="fas fa-chart-pie fa-stack-1x fa-inverse"></i>
					</span>
					Usage
				</h3>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<table class="table table-striped">
					<tr>
						<td><strong>Status</strong></td>
						<td id="status"></td>
					</tr>
					<tr>
						<td><strong>RAM</strong></td>
						<td><span id="used_mem"></span> / <span id="total_mem"></span> <span id="mem_prefix">GiB</span></td>
					</tr>
					<tr>
						<td><strong>Disk</strong></td>
						<td><span id="used_disk"></span> / <span id="total_disk"></span> <span id="disk_prefix">GiB</span></td>
					</tr>
					<tr>
						<td><strong>Bakups</strong></td>
						<td>1 / 10</td>
					</tr>
					<tr>
						<td colspan="2" class="text-center active">
							<button class="btn btn-default btn-sm"><i class="fas fa-chart-area"></i> More stats</button>

						</td>
					</tr>
				</table>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<h3>        
					<span class="fa-stack">
						<i class="fas fa-circle fa-stack-2x"></i>
						<i class="fas fa-bolt fa-stack-1x fa-inverse"></i>
					</span>
					Controls
				</h3>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="well well-sm">
					<button onclick="openConsole()" class="action btn btn-primary"><i class="fas fa-terminal"></i> Console</button>

					<button 
						id="start"
						data-action="start"
						data-toggle="tooltip"
						data-placement="bottom"
						class="action btn btn-default">
							<i class="fas fa-play"></i> Boot up
					</button>
					

					<button 
						id="shutdown" 
						data-action="shutdown"
						data-toggle="tooltip"
						data-placement="bottom"
						data-confirm="Do you relly want to stop your server ?"
						class="action btn btn-default">
							<i class="fas fa-power-off"></i> Shutdown
					</button>

					<button 
						id="restart"
						data-action="restart"
						data-toggle="tooltip"
						data-placement="bottom"
						data-confirm="Do you relly want to restart your server ?" 
						class="action btn btn-default">
							<i class="fas fa-redo"></i> Restart
					</button>


					<div class="pull-right">
						<button 
							id="kill"
							data-action="kill"
							data-toggle="tooltip"
							data-placement="bottom"
							data-confirm="Do you relly want to kill your server ?"
							class="action btn btn-danger">
								<i class="fas fa-skull"></i> Kill
						</button>
						
						<button 
							data-toggle="modal"
							data-target="#reinstall_modal"
							class="action btn btn-danger">
								<i class="fas fa-eraser"></i> Reinstall
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<h3>        
					<span class="fa-stack">
						<i class="fas fa-circle fa-stack-2x"></i>
						<i class="fas fa-cog fa-stack-1x fa-inverse"></i>
					</span>
					Settings
				</h3>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="well well-sm">
					<button class="btn btn-default"><i class="fas fa-shield"></i> Firewall</button>
					<button class="btn btn-default"><i class="fas fa-box"></i> Backups</button>
				</div>
			</div>
		</div>
	</div>

{/if}

<div class="modal fade" id="reinstall_modal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" ><span>&times;</span></button>
				<h4 class="modal-title">Reinstall your server</h4>
			</div>
			<div class="modal-body">
				
				<div class="form-group">
					<label for="os">Please select an operating system</label>
					<select id="os" class="form-control"></select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="action btn btn-primary" data-dismiss="modal" data-action="reinstall">Reinstall</button>
			</div>
		</div>
	</div>
</div>

<script>
	const url = 'clientarea.php?action=productdetails&id={$params['serviceid']}';
</script>
<script src="/modules/servers/proxmox_addon/templates/client/js/sweetalert2.all.min.js"></script>
<script src="/modules/servers/proxmox_addon/templates/client/js/clientarea.js"></script>