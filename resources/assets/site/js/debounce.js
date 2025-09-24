var debounce = {

	elementos: {
		cronometro: ''
	},

	calcular: function(callback, intervalo) {
		clearTimeout(debounce.elementos.cronometro);
		
		debounce.elementos.cronometro = setTimeout(function() {
			callback();
		}, intervalo);
	}
	
}
