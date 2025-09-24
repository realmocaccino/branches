var gallery = {
	
	elements: {
		item: '[data-gallery]'
	},

	start: function() {
		$(gallery.elements.item).each(gallery.create);
	
		gallery.events();
	},
	
	events: function() {},
	
	create: function() {
		$(this).magnificPopup({
			delegate: 'a',
			type: 'image',
			gallery:{
				enabled: true,
				tPrev: 'Anterior',
				tNext: 'Próximo',
				tCounter: '%curr% de %total%'
			},
			tClose: 'Fechar',
			tLoading: 'Carregando...',
			image: {
				tError: '<a href="%url%">A imagem</a> não pôde ser carregada.'
			},
			ajax: {
				tError: '<a href="%url%">O pedido</a> falhou.'
			}
		});
	}
	
};
