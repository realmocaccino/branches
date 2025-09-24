var chart = {

	auxiliaries: {
		fontColor: '#111',
		gridLineColor: '#CCC',
		darkModeFontColor: '#FFF',
		darkModeGridLineColor: '#484D55',
		preDatasets: {
		    default: {
				backgroundColor: "rgba(91,147,176,0.2)",
				borderColor: "rgba(91, 147, 176, 1)"
			},
			low: {
				backgroundColor: "rgba(255, 153, 153, 1)",
				borderColor: "rgba(250, 29, 27, 0.9)"
			},
			medium: {
				backgroundColor: "rgba(255, 255, 153, 1)",
				borderColor: "rgba(255, 166, 11, 0.9)"
			},
			high: {
				backgroundColor: "rgba(152, 251, 152, 1)",
				borderColor: "rgba(43, 184, 0, 0.9)"
			},
			user: {
				backgroundColor: "rgba(255,99,132,0.2)",
				borderColor: "rgba(255,99,132,0.8)"
			}
		}
	},
	
	elements: {
		instances: [],
		charts: '[data-chart]'
	},

	start: function() {
		$(chart.elements.charts).each(chart.create);
	
		chart.events();
	},
	
	events: function() {
		$(document).on('dialogCreated', function() {
			$(dialog.elements.container + ' ' + chart.elements.charts).each(chart.create);
		});
		$(document).on('modeChanged', function() {
			chart.updateColor();
		});
	},
	
	create: function() {
		var options = $(this).data('chart');

		var instance = new Chart(document.querySelector('#' + $(this).attr('id')).getContext('2d'), {
			type: 'radar',
			data: {
				labels: options.labels,
				datasets: chart.prepareDatasets(options.datasets)
			},
			options: {
                legend: {
                    display: options.datasets.length == 2
                },
				responsive: true,
				scale: {
					pointLabels: {
						fontFamily: 'Trebuchet MS',
						fontSize: isMobile.phone ? 15 : 18,
						fontColor: mode.isDarkMode() ? chart.auxiliaries.darkModeFontColor : chart.auxiliaries.fontColor,
						fontWeight: 'bold'
					},
					ticks: {
						min: 0,
						max: 10,
						display: false
					},
					gridLines: {
						color: mode.isDarkMode() ? chart.auxiliaries.darkModeGridLineColor : chart.auxiliaries.gridLineColor,
					}
				},
				tooltips: {
					callbacks: {
					    label: function(tooltipItem, data) {
							var datasetLabel = data.datasets[tooltipItem.datasetIndex].label;
							var label = data.labels[tooltipItem.index];
							var score = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];

							return score.replace('.', ',');
					    }
					}
				}
			}
		});
		
		chart.storeInstance(instance, $(this));
	},
	
	getInstance: function(selector) {
		return $(selector).length ? chart.elements.instances[$(selector).data('chartId')] : null;
	},
	
	storeInstance: function(instance, selector) {
		$(selector).data('chartId', chart.elements.instances.length);
		
		chart.elements.instances.push(instance);
	},
	
	update: function(selector, datasets) {
		datasets = chart.prepareDatasets(datasets);

		var chartDatasets = chart.getInstance(selector).data.datasets;
		
		chartDatasets.forEach(function(dataset) { dataset.data = [] });
		
		datasets.forEach(function(dataset, index) {
		    if(chartDatasets[index]) {
		        chartDatasets[index].backgroundColor = dataset.backgroundColor;
		        chartDatasets[index].borderColor = dataset.borderColor;
		    	chartDatasets[index].data = dataset.data;
		    } else {
		    	chartDatasets.push(dataset);
		    }
		});
		
		chart.getInstance(selector).update();
	},

	updateColor: function() {
		fontColor = mode.isDarkMode() ? chart.auxiliaries.darkModeFontColor : chart.auxiliaries.fontColor;
		gridLineColor = mode.isDarkMode() ? chart.auxiliaries.darkModeGridLineColor : chart.auxiliaries.gridLineColor;

		chart.elements.instances.forEach(function(instance) {
			instance.options.scale.pointLabels.fontColor = fontColor;
			instance.options.scale.gridLines.color = gridLineColor;
			instance.update();
		});
	},
	
	prepareDatasets: function(datasets) {
		var userDataset = null;
		var communityDataset = null;

		if(datasets.length == 2) {
			communityDataset = datasets[1];
			userDataset = datasets[0];
		} else {
			communityDataset = datasets[0];
		}

	    var scoreRangeName = communityDataset.score ? score.getScoreRangeName(communityDataset.score) : 'default';

		communityDataset.backgroundColor = chart.auxiliaries.preDatasets[scoreRangeName].backgroundColor;
		communityDataset.borderColor = chart.auxiliaries.preDatasets[scoreRangeName].borderColor;

		if(userDataset) {
			userDataset.backgroundColor = chart.auxiliaries.preDatasets.user.backgroundColor;
			userDataset.borderColor = chart.auxiliaries.preDatasets.user.borderColor;
		}

		return datasets;
	}
	
};