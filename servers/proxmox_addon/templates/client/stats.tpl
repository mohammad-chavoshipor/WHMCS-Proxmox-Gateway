<div id="loader" class="text-center" style="margin-top: 30px;">
	<i class="fas fa-sync fa-spin fa-5x"></i>
	<h2>Loading ...</h2>
</div>

<div id="error" class="text-center hidden" style="margin-top: 30px;">
	<i class="fas fa-exclamation fa-5x text-danger"></i>
	<h3>Houston, we have a problem</h3>
	<p class="lead">An error has occured while trying to reach your server</h2>
</div>

<div id="stats" class="hidden">
	<div class="row">
		<div class="col-md-10">
			<h3>
				<span class="fa-stack">
					<i class="fas fa-circle fa-stack-2x"></i>
					<i class="fas fa-microchip fa-stack-1x fa-inverse"></i>
				</span>
				CPU
			</h3>
		</div>
		<div class="col-md-2 text-right">
			<label for="timeframe">Time base</label>
			<select id="timeframe" class="form-control">
				<option value="hour">Hour</option>
				<option value="day">Day</option>
				<option value="week">Week</option>
				<option value="month">Month</option>
				<option value="year">Year</option>
			</select>
		</div>		
	</div>

	<canvas id="cpu" height="80"></canvas>

	<h3>
		<span class="fa-stack">
			<i class="fas fa-circle fa-stack-2x"></i>
			<i class="fas fa-memory fa-stack-1x fa-inverse"></i>
		</span>
		RAM
	</h3>
	<canvas id="ram" height="80"></canvas>

	<div class="row">
		<div class="col-md-6">
			<h3>
				<span class="fa-stack">
					<i class="fas fa-circle fa-stack-2x"></i>
					<i class="fas fa-hdd fa-stack-1x fa-inverse"></i>
				</span>
				Disk space
			</h3>
			<canvas id="disk"></canvas>
		</div>

		<div class="col-md-6">
			<h3>
				<span class="fa-stack">
					<i class="fas fa-circle fa-stack-2x"></i>
					<i class="fas fa-tachometer-alt fa-stack-1x fa-inverse"></i>
				</span>
				Disk usage
			</h3>
			<canvas id="iops"></canvas>
		</div>
	</div>

	<h3>
		<span class="fa-stack">
			<i class="fas fa-circle fa-stack-2x"></i>
			<i class="fas fa-wifi fa-stack-1x fa-inverse"></i>
		</span>
		Network
	</h3>
	<canvas id="net" height="80"></canvas>
	
</div>
<style>
	canvas {
		margin-top: 20px;
	}
</style>

<script>
	const url = 'clientarea.php?action=productdetails&id={$params['serviceid']}';
</script>
<script src="/modules/servers/proxmox_addon/templates/client/js/chart.bundle.min.js"></script>
<script src="/modules/servers/proxmox_addon/templates/client/js/numeral.min.js"></script>
<script src="/modules/servers/proxmox_addon/templates/client/js/stats.js"></script>