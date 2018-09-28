// What follows is a hack to get dojo to work over an SSL connection.
for (var i in dojo._modulePrefixes) {
	if (dojo._modulePrefixes[i].value && dojo._modulePrefixes[i].value.indexOf('http://') === 0) {
		dojo._modulePrefixes[i].value = 'https://' + dojo._modulePrefixes[i].value.substr(7);
	}
}
var r = null, c = null;
function getNextGeo(event) {
	var el = event ? (event.srcElement ? event.srcElement : event.target) : window.event.srcElement, j = 0;
	dojo.xhrGet({url:'./', handleAs:'json', sync:true, content:{ajax:el.name == 'region' ? 'getCounties' : 'getProviders',region:r.options[r.selectedIndex].value,county:c.selectedIndex != -1 ? c.options[c.selectedIndex].value : -1},
		load:function (response, ioArgs) {
			var sel = document.getElementById(el.name == 'region' ? 'county' : 'provider'), i = 0, o = null;
			if (sel.options.length > 0) {
				for (i = sel.options.length - 1; i >= 0; i--) {
					sel.options[i] = null;
				}
			}
			for (i in response) {
				o = document.createElement('option');
				o.text = i;
				o.value = response[i];
				sel.options[sel.options.length] = o;
			}
			sel.disabled = false;
			
			el.name == 'region' ? getNextGeo({srcElement:sel}) : false;
		},
		error:function (response, ioArgs) {alert('There was an error update the ' + (el.name == 'region' ? 'counties' : 'providers') + '.');}
	});
}

function load() {
	r = document.getElementById('region');
	c = document.getElementById('county');
	if (r !== null) {
		r.onchange = window.getNextGeo;
		getNextGeo({srcElement:r});
	}
	if (c !== null) {
		c.onchange = window.getNextGeo;
	}
}