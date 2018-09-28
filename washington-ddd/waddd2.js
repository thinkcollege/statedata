var r = null, c = null, p = null;
$(function() {
	r = $('#region').addClass('starting-value').change(getNextGeo);
	c = $('#county').addClass('starting-value').change(getNextGeo);
	p = $('#provider').addClass('starting-value');
	var s = $('#saved-reports');
	if (s.size() == 1 && typeof(JSON) == 'object') {
		var rpts = JSON.parse(localStorage.getItem('saved-reports'));
	} else {
		var rpts = [];
	}
	if (r !== null) {
		r.change();
	}
	if (localStorage) {
		$('#report-settings').on('submit', function() {
			localStorage.setItem('current', window.location.href + '&' + $(this).serialize() + '&graph=1');
		});
	}
	if (rpts && s.size() == 1) {
		$.each(rpts, function(i) {
			s.append($('<li/>').append($('<a/>', {href:this.url, text:this.label})));
		});
		if (rpts.length > 0) {
			s.before($("<h3/>", {text:'Saved Reports'}));
		}
	}
	var title = $('#report-title'), email = $('#email-link'), url = localStorage ? localStorage.getItem('current') || '' : '';
	if (title.size() == 1 && localStorage) {
		title.get(0).disabled = false;
		title.next().click(saveReport).get(0).disabled = false;
		title.next().after($('<br/><span class="error">Your browser must support localStorage to be able to save reports.</span>'));
	}
})
function getNextGeo(event) {
	$.ajax({url:'./', dataType:'json', context:this, data:{ajax:this.name == 'region' ? 'getCounties' : 'getProviders', region:r.val(),county:c.val() || -1}, success:function (response, status, xhr) {
			var sel = (this.name == 'region' ? c : p), val = sel.hasClass("starting-value") ? sel.val() : null;
			sel.children().remove().end()
			$.each(response, function(i, v) {
				sel.append($('<option/>', {text:i, value:v}));
			});
			$(this).removeClass('starting-value');
			sel.val(val).change().get(0).disabled = false;
		},
		error:function (response, status, xhr) {alert('There was an error update the ' + (this.name == 'region' ? 'counties' : 'providers') + '.');}
	});
}

function saveReport() {
	var url = window.location.href.indexOf('&') > -1 ? window.location.href : (localStorage ? localStorage.getItem('current') || '' : '');
	if (!url || !localStorage || !JSON) {
		alert('Cannot save report!');
	}
	var rpts = JSON.parse(localStorage.getItem('saved-reports')) || [], rpt = {label:$('#report-title').val(), url:url};
	rpts.push(rpt);
	rpts.sort(function(a, b) {
		return a.label < b.label ? -1 : (a.label > b.label ? 1 : 0);
	});
	localStorage.setItem('saved-reports', JSON.stringify(rpts));
	alert('Report "' + rpts[rpts.length - 1].label + '" is saved!');
}
