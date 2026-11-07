(function () {
    function get(k) { try { return localStorage.getItem(k); } catch (e) { return null; } }
    function set(k, v) { try { localStorage.setItem(k, v); } catch (e) {} }

    // Cookies
    var cookie = document.getElementById('cookie');
    var cookieOk = document.getElementById('cookie-ok');
    if (cookie && get('club_cookie') !== '1') cookie.hidden = false;
    if (cookieOk) cookieOk.addEventListener('click', function () { set('club_cookie', '1'); cookie.hidden = true; });

    // Меню
    var burger = document.getElementById('burger');
    var menu = document.getElementById('menu');
    if (burger && menu) {
        var setOpen = function (open) {
            menu.classList.toggle('open', open);
            burger.classList.toggle('open', open);
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        };
        burger.addEventListener('click', function () { setOpen(!menu.classList.contains('open')); });
        menu.addEventListener('click', function (e) { if (e.target.tagName === 'A') setOpen(false); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setOpen(false); });
    }

    // Вкладки тарифов
    document.querySelectorAll('[data-tabs]').forEach(function (box) {
        var tabs = box.querySelectorAll('.tab');
        var panels = box.querySelectorAll('.tpanel');
        function show(key) {
            tabs.forEach(function (t) { t.setAttribute('aria-selected', t.getAttribute('data-tab') === key ? 'true' : 'false'); });
            panels.forEach(function (p) { p.hidden = p.getAttribute('data-panel') !== key; });
        }
        tabs.forEach(function (t) { t.addEventListener('click', function () { show(t.getAttribute('data-tab')); }); });
        if (tabs.length) show(tabs[0].getAttribute('data-tab'));
    });

    // Маска телефона
    document.querySelectorAll('[data-phone]').forEach(function (input) {
        input.addEventListener('input', function () {
            var d = input.value.replace(/\D/g, '');
            if (!d) { input.value = ''; return; }
            if (d[0] === '8') d = '7' + d.slice(1);
            if (d[0] !== '7') d = '7' + d;
            d = d.slice(0, 11);
            var out = '+7';
            if (d.length > 1) out += ' (' + d.slice(1, 4);
            if (d.length >= 4) out += ')';
            if (d.length > 4) out += ' ' + d.slice(4, 7);
            if (d.length > 7) out += '-' + d.slice(7, 9);
            if (d.length > 9) out += '-' + d.slice(9, 11);
            input.value = out;
        });
    });

    // Дата брони: не раньше сегодняшней
    var today = document.querySelector('[data-today]');
    if (today) {
        var n = new Date();
        var iso = n.getFullYear() + '-' + String(n.getMonth() + 1).padStart(2, '0') + '-' + String(n.getDate()).padStart(2, '0');
        today.min = iso;
        if (!today.value) today.value = iso;
    }

    // Калькулятор списания баллов
    var calc = document.getElementById('calc');
    if (calc) {
        var bal = parseInt(calc.dataset.balance, 10) || 0;
        var pct = parseInt(calc.dataset.percent, 10) || 30;
        var inp = calc.querySelector('input');
        var out = calc.querySelector('[data-out]');
        inp.addEventListener('input', function () {
            var total = parseInt(inp.value, 10) || 0;
            if (total <= 0) { out.textContent = 'Введите сумму сеанса'; return; }
            var max = Math.max(0, Math.min(bal, Math.floor(total * pct / 100)));
            out.textContent = 'Можно списать до ' + max + ' баллов, к оплате деньгами — ' + (total - max) + ' ₽';
        });
    }

    // PWA
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/sw.js').catch(function () {});
        });
    }
    var deferred = null, install = document.getElementById('install');
    window.addEventListener('beforeinstallprompt', function (e) {
        e.preventDefault(); deferred = e;
        if (install) install.hidden = false;
    });
    if (install) install.addEventListener('click', function () {
        if (!deferred) return;
        deferred.prompt();
        deferred.userChoice.finally(function () { deferred = null; install.hidden = true; });
    });
})();
