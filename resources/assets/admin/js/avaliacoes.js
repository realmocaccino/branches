var avaliacoes = {

	elementos: {
		selectJogo: 'select#game_id',
		selectPlataforma: 'select#platform_id',
		inputSubmit: 'input[type=submit]'
	},
	
	iniciar: function() {
		avaliacoes.eventos();
	},
	
	eventos: function() {
		$(document).on('change', avaliacoes.elementos.selectJogo, avaliacoes.getPlataformas);
	},
	
	getPlataformas: function() {
		$(avaliacoes.elementos.inputSubmit).prop('disabled', true);
		$.ajax({
			type: 'GET',
			url: '/ajax/ratings/edit/platforms/'+$(avaliacoes.elementos.selectJogo).val(),
			success: function(resposta) {
				$(avaliacoes.elementos.selectPlataforma).html(resposta);
				$(avaliacoes.elementos.inputSubmit).prop('disabled', false);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

}

$(document).ready(function(){
	avaliacoes.iniciar();
});
