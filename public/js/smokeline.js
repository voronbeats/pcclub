(function () {
    function get(k) { try { return localStorage.getItem(k); } catch (e) { return null; } }
    function set(k, v) { try { localStorage.setItem(k, v); } catch (e) {} }

    var cookie = document.getElementById('cookie');
    function showCookie() { if (cookie && get('sl_cookie') !== '1') cookie.hidden = false; }
    var cookieOk = document.getElementById('cookie-ok');
    if (cookieOk) cookieOk.addEventListener('click', function () { set('sl_cookie', '1'); cookie.hidden = true; });

    // Подтверждение возраста
    var gate = document.getElementById('gate');
    if (gate) {
        var yes = document.getElementById('gate-yes');
        var no = document.getElementById('gate-no');
        if (get('sl_18') !== '1') { gate.hidden = false; document.body.classList.add('locked'); }
        else showCookie();
        yes.addEventListener('click', function () {
            set('sl_18', '1');
            gate.hidden = true;
            document.body.classList.remove('locked');
            showCookie();
        });
        no.addEventListener('click', function () {
            document.getElementById('gate-main').hidden = true;
            document.getElementById('gate-refuse').hidden = false;
        });
    } else {
        showCookie();
    }

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

    // Калькулятор списания баллов
    var calc = document.getElementById('calc');
    if (calc) {
        var bal = parseInt(calc.dataset.balance, 10) || 0;
        var pct = parseInt(calc.dataset.percent, 10) || 30;
        var inp = calc.querySelector('input');
        var out = calc.querySelector('[data-out]');
        inp.addEventListener('input', function () {
            var total = parseInt(inp.value, 10) || 0;
            if (total <= 0) { out.textContent = 'Введите сумму покупки'; return; }
            var max = Math.max(0, Math.min(bal, Math.floor(total * pct / 100)));
            out.textContent = 'Можно списать до ' + max + ' баллов, к оплате деньгами — ' + (total - max) + ' ₽';
        });
    }

    // Фильтр товаров
    var chips = document.querySelectorAll('.chip');
    if (chips.length) {
        var cards = document.querySelectorAll('[data-cat]');
        chips.forEach(function (chip) {
            chip.addEventListener('click', function () {
                var f = chip.getAttribute('data-filter');
                chips.forEach(function (c) { c.classList.toggle('is-active', c === chip); });
                cards.forEach(function (card) { card.hidden = !(f === 'all' || card.getAttribute('data-cat') === f); });
            });
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
