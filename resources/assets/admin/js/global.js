$(document).ready(function(){

	$('.alert .close').click(function(){
		$(this).parent().fadeOut('fast');
	});
	
	$.ajaxSetup({
		headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
		}
	});
	
	$('[data-sa]').click(function(e){
		e.preventDefault();
		self = this;
		swal({
			title: 'Tem certeza?',
			text: 'Você não conseguirá recuperar este item!',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Cancelar',
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Sim, exclua!',
			closeOnConfirm: true,
			allowOutsideClick: true,
			showLoaderOnConfirm: true
		},
		function(){
			$.ajax({
				type: 'DELETE',
				url: $(self).attr('href'),
			})
			.done(function(data){
				$(self).parents('tr').fadeOut('fast');
				//swal('Sucesso!', data.message, 'success');
			})
			.error(function(data){
				//swal('Oops', 'Não conseguimos nos conectar ao servidor!', 'error');
			});
		});
	});
});