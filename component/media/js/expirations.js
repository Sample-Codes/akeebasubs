/**
 * @package		akeebasubs
 * @copyright	Copyright (c)2010-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
 */

/**
 * Setup (required for Joomla! 3)
 */
if(typeof(akeeba) == 'undefined') {
	var akeeba = {};
}
if(typeof(akeeba.jQuery) == 'undefined') {
	akeeba.jQuery = jQuery.noConflict();
}

var jsonurl = 'index.php?option=com_akeebasubs&view=reports&task=getexpirations&format=json&layout=expirations';
var expireChart;

function loadExpGraph()
{
	akeeba.jQuery.ajax(jsonurl, {
		data    : {
			'start' : akeeba.jQuery('#exp_start').val()
		},
		dataType: 'json',
		cache   : false,
		success : function(json, status, jqXH){
			expireChart.destroy();
			
			var options = {
				//data : json.data,
				highlighter: { show: true, showMarker: false },
				stackSeries: true,
				seriesDefaults : {
						renderer: akeeba.jQuery.jqplot.BarRenderer,
						rendererOptions: {
							barPadding : 10,
							barMargin : 10,
							barWidth : 40
						}
				},
				series : json.seriesLabel,
				legend: {
					show: true,
					location: 'ne',
					placement: 'inside'
				},
				axes:{
					xaxis:{
						renderer: akeeba.jQuery.jqplot.DateAxisRenderer,
						tickRenderer: akeeba.jQuery.jqplot.CanvasAxisTickRenderer ,
						ticks : json.labels,
						tickOptions: {
							angle: -90,
							fontSize: '10pt',
							formatString:'%Y-%m-%d',
							labelPosition: 'middle'
						}
					}
				}
			};

			if(json.hideLegend){
				options.legend.show = false;
			}

			expireChart = akeeba.jQuery.jqplot('akexpirationschart', json.data, options);
		}
	});
}

akeeba.jQuery(document).ready(function(){
	expireChart = akeeba.jQuery.jqplot('akexpirationschart', [[[]]] ,{});
	
	akeeba.jQuery('#exp_graph_reload').click(function(){
		loadExpGraph();
	});

	akeeba.jQuery('#exp_graph_reload').click();
});