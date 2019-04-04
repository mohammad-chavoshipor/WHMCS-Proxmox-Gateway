let datas = [];

Chart.defaults.global.legend.position = 'bottom';
Chart.defaults.global.elements.point.radius = 0;
Chart.defaults.global.elements.point.hitRadius = 5;
Chart.defaults.global.responsive = true;

const options = {
	scales: {
		xAxes: [{
			type: 'time'
		}],
		yAxes: [{
			ticks: {
				callback: function(label, index, labels) {
					return numeral(label).format('0 ib');
				}
			}
		}]
	},
	tooltips: {
		callbacks: {
			title: () => null,
			label: function(tooltipItem, data) {
				return numeral(tooltipItem.yLabel).format('0 ib');
			},
		}
    }
};


String.prototype.capitalize = function() {
	return this.charAt(0).toUpperCase() + this.slice(1);
}

function loadData() {
	$('#loader').removeClass('hidden');
	
	$('#error').addClass('hidden');
	$('#stats').addClass('hidden');

	$.get(url + '&method=rrd', function (data) {
		$('#loader').addClass('hidden');

		if (data.success) {
			$('#stats').removeClass('hidden');
			datas = data.rrd;
			netgraph();
			cpugraph();
			ramgraph();
			diskgraph();
			iopsgraph();
		} else {
			$('#error').removeClass('hidden');

			$('#loader').addClass('hidden');
			$('#stats').addClass('hidden');
		}
	}).fail(function() {
		$('#loader').addClass('hidden');
		$('#error').removeClass('hidden');
	});
}

$(document).ready(function () {
	loadData();
})

function cpugraph() {
	const config = {
		type: 'line',
		data: {
			datasets: [
				{ label: 'Total', data: [], fill: false, borderColor: '#3498db' },
				{ label: 'Used', data: [], fill: false, borderColor: '#e74c3c' },
			]
		},
		options: {
			scales: {
				xAxes: [{
					type: 'time'
				}]
			}
		}
	};

	for (let data of datas) {
		config.data.datasets[0].data.push({
			x: new Date(data.time * 1000),
			y: data.maxcpu
		});
	}

	for (let data of datas) {
		config.data.datasets[1].data.push({
			x: new Date(data.time * 1000),
			y: data.cpu
		});
	}

	const ctx = document.getElementById('cpu').getContext('2d');
	new Chart(ctx, config);
}

function netgraph() {
	const config = {
		type: 'line',
		data: {
			datasets: [
				{ label: 'Ingress', data: [], fill: false, borderColor: '#3498db' },
				{ label: 'Egress', data: [], fill: false, borderColor: '#e74c3c' }
			]
		},
		options
	};

	for (let data of datas) {
		config.data.datasets[0].data.push({
			x: new Date(data.time * 1000),
			y: data.netin
		});
	}

	for (let data of datas) {
		config.data.datasets[1].data.push({
			x: new Date(data.time * 1000),
			y: data.netout
		});
	}

	const ctx = document.getElementById('net').getContext('2d');
	new Chart(ctx, config);
}


function ramgraph() {
	const config = {
		type: 'line',
		data: {
			datasets: [
				{ label: 'Total', data: [], fill: false, borderColor: '#3498db' },
				{ label: 'Used', data: [], fill: false, borderColor: '#e74c3c' }
			]
		},
		options
	};

	for (let data of datas) {
		config.data.datasets[0].data.push({
			x: new Date(data.time * 1000),
			y: data.maxmem
		});
	}

	for (let data of datas) {
		config.data.datasets[1].data.push({
			x: new Date(data.time * 1000),
			y: data.mem
		});
	}

	const ctx = document.getElementById('ram').getContext('2d');
	new Chart(ctx, config);
}

function diskgraph() {
	const config = {
		type: 'line',
		data: {
			datasets: [
				{ label: 'Total', data: [], fill: false, borderColor: '#3498db' },
				{ label: 'Used', data: [], fill: false, borderColor: '#e74c3c' }
			]
		},
		options
	};

	for (let data of datas) {
		config.data.datasets[0].data.push({
			x: new Date(data.time * 1000),
			y: data.maxdisk
		});
	}

	for (let data of datas) {
		config.data.datasets[1].data.push({
			x: new Date(data.time * 1000),
			y: data.disk
		});
	}

	const ctx = document.getElementById('disk').getContext('2d');
	new Chart(ctx, config);
}

function iopsgraph() {
	const config = {
		type: 'line',
		data: {
			datasets: [
				{ label: 'Writes', data: [], fill: false, borderColor: '#3498db' },
				{ label: 'Reads', data: [], fill: false, borderColor: '#e74c3c' }
			]
		},
		options
	};

	for (let data of datas) {
		config.data.datasets[0].data.push({
			x: new Date(data.time * 1000),
			y: data.diskwrite
		});
	}

	for (let data of datas) {
		config.data.datasets[1].data.push({
			x: new Date(data.time * 1000),
			y: data.diskread
		});
	}

	const ctx = document.getElementById('iops').getContext('2d');
	new Chart(ctx, config);
}