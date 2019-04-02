let console_url = '';

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

function loadData() {


	$('#loader').removeClass('hidden');
	
	$('#error').addClass('hidden');
	$('#infos').addClass('hidden');

	$.get(url + '&method=data', function (data) {
		$('#loader').addClass('hidden');

		if (data.success) {
			$('#infos').removeClass('hidden');
			$('.action').prop('title', '');
			console_url = data.url;

			let total_disk = Math.round(data.status.maxdisk / 2 ** 30);
			let used_disk = Math.round(data.status.disk / 2 ** 30);

			if (total_disk < 1) {
				total_disk = Math.round(data.status.maxdisk / 2 ** 20);
				used_disk = Math.round(data.status.disk / 2 ** 20);
				$('#disk_prefix').html('MiB');
			}

			$("#total_disk").html(total_disk);
			$("#used_disk").html(used_disk);

			let total_mem = Math.round(data.status.maxmem / 2 ** 30);
			let used_mem = Math.round(data.status.mem / 2 ** 30);

			if (total_mem < 1) {
				total_mem = Math.round(data.status.maxmem / 2 ** 20);
				used_mem = Math.round(data.status.mem / 2 ** 20);
				$('#mem_prefix').html('MiB');
			}

			$("#total_mem").html(total_mem);
			$("#used_mem").html(used_mem);

			if (data.status.status === 'running') {
				$('#status').html('<span class="label label-success">On</span>');

				$('#start')
					.prop('disabled', true)
					.prop('title', 'Server already on');
			} else if (data.status.status === 'stopped') {
				$('#status').html('<span class="label label-danger">Off</span>');

				$('#shutdown')
					.prop('disabled', true)
					.prop('title', 'Server already off');
				$('#restart')
					.prop('disabled', true)
					.prop('title', 'Server already off');

				$('#kill')
					.prop('disabled', true)
					.prop('title', 'Server already off');
			} else {
				$('#status').html('<span class="label label-default">Error</span>');
			}

		} else {
			$('#error').removeClass('hidden');

			$('#loader').addClass('hidden');
			$('#infos').addClass('hidden');
		}
	}).fail(function() {
		$('#loader').addClass('hidden');
		$('#error').removeClass('hidden');
	});
}

function openConsole() {
	window.open(console_url, "Console", "width=800,height=600");
	window.close();
}

$(document).ready(function () {
	loadData();
})

$('.action').click(function (event) {
	const action = $(this).data('action');

	if (action) {
		$('.action').prop('disabled', true);

		$.get(url + '&method=' + action, function (data) {
			$('.action').prop('disabled', false);
			loadData();
			if (data.success) {
				Swal.fire(
					'Success',
					action.capitalize() + ' executed',
					'success'
				);
			} else {
				Swal.fire(
					'Error',
					'An error occured while executing the ' + action+ ' task ! Please try again later.',
					'error'
				);
			}
			
		});
	}
});