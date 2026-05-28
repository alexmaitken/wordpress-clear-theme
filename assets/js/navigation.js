(function () {
	var html = document.documentElement;
	html.classList.add('js');

	var toggle = document.querySelector('.menu-toggle');
	var nav = document.getElementById('site-header-nav');

	if (!toggle || !nav) {
		return;
	}

	toggle.addEventListener('click', function () {
		var expanded = toggle.getAttribute('aria-expanded') === 'true';
		toggle.setAttribute('aria-expanded', expanded ? 'false' : 'true');
		nav.classList.toggle('is-open', !expanded);
	});
})();
