window.onload = loader;
var r = null, a = null, p = null;
function getNextGeo(e) {
	var b = $(e ? (e.srcElement ? e.srcElement : e.target) : window.event.srcElement).attr('id') == 'r', s = b ? a : p;
	s.load('ajax.php?r=' + r.val().replace(' ', '+') + (!b ? '&ao=' + a.val().replace(' ', '+') : ''));
	b && a.change();
}

function loader() {
	r = $('#r').first();
	a = $('#ao').first();
	p = $('#p').first();
	if (r !== null) {
		r.change(getNextGeo);
		r.change();
	}
	a !== null && a.change(getNextGeo);
}