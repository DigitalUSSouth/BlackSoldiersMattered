/* javascript for slide-5 */

$(document).ready(function(){
    var pie = new d3pie("myPie", {
	"header": {
		"title": {
			"text": "Types of Domestic Units",
			"fontSize": 24,
			"font": "open sans"
		},
		"subtitle": {
			"color": "#999999",
			"fontSize": 12,
			"font": "open sans"
		},
		"titleSubtitlePadding": 9
	},
	"footer": {
		"color": "#999999",
		"fontSize": 10,
		"font": "open sans",
		"location": "bottom-left"
	},
	"size": {
		canvasHeight: 500,
		canvasWidth: 750,
		pieInnerRadius: 0,
		pieOuterRadius: null
	},
	"data": {
		"sortOrder": "value-desc",
		"content": domesticUnitsPieData
	},
	"labels": {
		"outer": {
			"pieDistance": 32
		},
		"inner": {
			"hideWhenLessThanPercentage": 3
		},
		"mainLabel": {
			"fontSize": 11
		},
		"percentage": {
			"color": "#ffffff",
			"decimalPlaces": 0
		},
		"value": {
			"color": "#adadad",
			"fontSize": 11
		},
		"lines": {
			"enabled": true
		},
		"truncation": {
			"enabled": true
		}
	},
	"effects": {
		"pullOutSegmentOnClick": {
			"effect": "linear",
			"speed": 400,
			"size": 8
		}
	},
	"tooltips": {
		"enabled" : true,
		"type": "placeholder",
		"string": "{label}, {value}"
	},
	"misc": {
		"gradient": {
			"enabled": true,
			"percentage": 100
		}
	}
    });

//pie.redraw();
//$("#myPie svg").addClass("testClass");


var pie2 = new d3pie("myPie2", {
	"header": {
		"title": {
			"text": "Types of Overseas Units",
			"fontSize": 24,
			"font": "open sans"
		},
		"subtitle": {
			"color": "#999999",
			"fontSize": 12,
			"font": "open sans"
		},
		"titleSubtitlePadding": 9
	},
	"footer": {
		"color": "#999999",
		"fontSize": 10,
		"font": "open sans",
		"location": "bottom-left"
	},
	"size": {
		canvasHeight: 500,
		canvasWidth: 750,
		pieInnerRadius: 0,
		pieOuterRadius: null
	},
	"data": {
		"sortOrder": "value-desc",
		"content": overseasUnitsPieData
	},
	"labels": {
		"outer": {
			"pieDistance": 32
		},
		"inner": {
			"hideWhenLessThanPercentage": 3
		},
		"mainLabel": {
			"fontSize": 11
		},
		"percentage": {
			"color": "#ffffff",
			"decimalPlaces": 0
		},
		"value": {
			"color": "#adadad",
			"fontSize": 11
		},
		"lines": {
			"enabled": true
		},
		"truncation": {
			"enabled": true
		}
	},
	"effects": {
		"pullOutSegmentOnClick": {
			"effect": "linear",
			"speed": 400,
			"size": 8
		}
	},
	"tooltips": {
		"enabled" : true,
		"type": "placeholder",
		"string": "{label}, {value}"
	},
	"misc": {
		"gradient": {
			"enabled": true,
			"percentage": 100
		}
	}
    });

});