var add = {
	
	elements: {
		form: '#form-add',
		release: '#form-add-release',
		modesContainer: '#form-add-modes',
		noDeveloperFoundButton: '#form-add-no-developer-found-button',
		createDeveloperPublisherSection: '#form-add-create-developer-publisher-section',
		coverInput: '#form-add-cover',
		coverPreview: '#form-add-cover-preview',
		coverErrorMessage: '#form-add-cover-errorMessage',
		errorMessages: '.help-block',
	},
	
	start: function() {
	    add.events();
	    
		if(document.querySelector(add.elements.form)) {
			add.checkModesMessage();
			add.maskRelease();
		}
	},
	
	events: function() {
	  	$(add.elements.form).on('click', add.elements.noDeveloperFoundButton, add.showCreateDeveloperPublisherSection);
	  	$(add.elements.form).on('change', add.elements.coverInput, add.checkCoverDimensionsAndPreviewIt);
	},

	checkCoverDimensionsAndPreviewIt: function() {
		var reader = new FileReader();
		reader.onloadend = function() {
			$(add.elements.coverPreview).prop('src', reader.result)
		}
		reader.readAsDataURL(this.files[0]);
		$(add.elements.coverPreview).on('load', function(image) {
			if(image.target.naturalWidth > image.target.naturalHeight) {
				$(add.elements.coverInput).val('');
				$(add.elements.coverPreview).prop('src', '');
				$(add.elements.coverErrorMessage).show().text('Dimensão incorreta: largura maior que altura.');
			} else if(image.target.naturalWidth < 250) {
				$(add.elements.coverInput).val('');
				$(add.elements.coverPreview).prop('src', '');
				$(add.elements.coverErrorMessage).show().text('Dimensão incorreta: largura menor que 250px.');
			} else {
				$(add.elements.coverErrorMessage).hide().text('');
			}
		});
	},
	
	checkModesMessage: function() {
		if($(add.elements.modesContainer + ' ' + add.elements.errorMessages).length > 0) {
			location.hash = add.elements.modesContainer;
		}
	},

	maskRelease: function() {
		document.querySelector(add.elements.release).MaskIt('00/00/0000');
	},
	
	showCreateDeveloperPublisherSection: function(event) {
	    event.preventDefault();
	    
	    $(event.target).hide();
        $(add.elements.createDeveloperPublisherSection).show();
    }
	
};
