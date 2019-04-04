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

			if (data.install) {
				$('#install').removeClass('hidden');
				return;
			}

			if (data.reinstall) {
				$('#reinstall').removeClass('hidden');
				return;
			}

			$('#infos').removeClass('hidden');
			$('.action').prop('title', '');
			console_url = data.url;

			
			$("#total_disk").html(numeral(data.status.maxdisk).format('0 ib'));
			$("#used_disk").html(numeral(data.status.disk).format('0 ib'));

			$("#total_mem").html(numeral(data.status.maxmem).format('0 ib'));
			$("#used_mem").html(numeral(data.status.mem).format('0 ib'));

			$('#os')
				.find('option')
				.remove()
				.end();

			for (let template of data.templates) {
				$('#os').append('<option value="'+ template.id +'">'+ template.name +'</option>')
			}

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
	let action = $(this).data('action');
	const message = $(this).data('action');

	if (action) {
		$('.action').prop('disabled', true);

		if (action === 'reinstall') {
			action = action + '&os=' + $('#os').val();
			$('#reinstall_modal').modal('hide');
		}

		$.get(url + '&method=' + action, function (data) {
			$('.action').prop('disabled', false);
			loadData();
			if (data.success) {
				Swal.fire(
					'Success',
					message.capitalize() + (message === 'reinstall' ? ' scheduled' : ' executed'),
					'success'
				);
			} else {
				Swal.fire(
					'Error',
					'An error occured while executing the ' + message + ' task ! Please try again later.',
					'error'
				);
			}
			
		});
	}
});