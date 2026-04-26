let observer = null;
let topBtn = null;
let bitacoraInitialized = false;

(function () {

    /* ===============================
       INIT PRINCIPAL
    =============================== */
    function initBitacora() {

        resetBitacora();
        forceViewSync();
        initViews();
        initCards();
        initRipple();
        initTopButton();
        initModal();
    }

    /* ===============================
       RESET SEGURO
    =============================== */
    function resetBitacora() {

        bitacoraInitialized = false;

        if (observer) {
            observer.disconnect();
            observer = null;
        }

        document.querySelectorAll('.log-card')
            .forEach(el => el.classList.remove('show-card'));
    }

    /* ===============================
       FORZAR VISTA
    =============================== */


    function forceViewSync() {

        const saved = localStorage.getItem('bitacoraView') || 'timeline';

        const timeline = document.getElementById('timelineView');
        const table = document.getElementById('tableView');

        if (!timeline || !table) return;

        timeline.style.display = 'none';
        table.style.display = 'none';

        if (saved === 'table') {
            table.style.display = 'block';
        } else {
            timeline.style.display = 'block';
        }
    }

    /* ===============================
       VISTAS
    =============================== */
function initViews() {

    const btnTimeline = document.getElementById('btnTimeline');
    const btnTable = document.getElementById('btnTable');

    const timeline = document.getElementById('timelineView');
    const table = document.getElementById('tableView');

    if (!btnTimeline || !btnTable || !timeline || !table) return;

    function setView(view) {

        const isTimeline = view === 'timeline';

        timeline.style.display = isTimeline ? 'block' : 'none';
        table.style.display = isTimeline ? 'none' : 'block';

        document.querySelectorAll('.view-btn')
            .forEach(b => b.classList.remove('active'));

        (isTimeline ? btnTimeline : btnTable).classList.add('active');

        localStorage.setItem('bitacoraView', view);

        if (isTimeline) {
            requestAnimationFrame(initCards);
        }
    }

    btnTimeline.addEventListener('click', () => setView('timeline'));
    btnTable.addEventListener('click', () => setView('table'));

    // estado inicial
    const saved = localStorage.getItem('bitacoraView') || 'timeline';
    setView(saved);

    document.addEventListener('keydown', function (e) {

        const typing = ['INPUT', 'TEXTAREA']
            .includes(document.activeElement.tagName);

        if (typing) return;

        if (e.key === 't') setView('timeline');
        if (e.key === 'g') setView('table');

        if (e.key === '/') {
            e.preventDefault();
            document.querySelector('.search-input')?.focus();
        }

        if (e.key === 'Escape') closeModal();
    });
}
    /* ===============================
       ANIMACIÓN CARDS
    =============================== */
    function initCards() {

        if (observer) observer.disconnect();

        const cards = document.querySelectorAll('.log-card');

        observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show-card');
                }
            });
        }, { threshold: 0.08 });

        cards.forEach(card => {
            card.classList.remove('show-card');
            observer.observe(card);
        });
    }

    /* ===============================
       RIPPLE EFFECT
    =============================== */
    function initRipple() {

        document.querySelectorAll('.view-btn,.btn-primary')
            .forEach(btn => {

                if (btn.dataset.rippleReady) return;
                btn.dataset.rippleReady = "1";

                btn.addEventListener('click', function (e) {

                    const ripple = document.createElement('span');

                    ripple.style.position = 'absolute';
                    ripple.style.width = '10px';
                    ripple.style.height = '10px';
                    ripple.style.borderRadius = '50%';
                    ripple.style.left = (e.offsetX - 5) + 'px';
                    ripple.style.top = (e.offsetY - 5) + 'px';
                    ripple.style.background = 'rgba(255,255,255,.4)';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.transition = '.5s ease';
                    ripple.style.pointerEvents = 'none';

                    btn.appendChild(ripple);

                    requestAnimationFrame(() => {
                        ripple.style.transform = 'scale(15)';
                        ripple.style.opacity = '0';
                    });

                    setTimeout(() => ripple.remove(), 500);
                });
            });
    }

    /* ===============================
       TOP BUTTON
    =============================== */
    function initTopButton() {

        if (topBtn) return;

        topBtn = document.createElement('button');
        topBtn.innerHTML = '↑';
        topBtn.className = 'scroll-top-btn';

        topBtn.onclick = () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };

        document.body.appendChild(topBtn);

        window.addEventListener('scroll', () => {
            topBtn.classList.toggle('show-top', window.scrollY > 280);
        });
    }

    /* ===============================
       MODAL INIT
    =============================== */
    function initModal() {

        const modal = document.getElementById('crudModal');
        if (!modal) return;

        const closeBtn = document.getElementById('closeCrudModal');
        const backdrop = modal.querySelector('.crud-backdrop');

        closeBtn?.addEventListener('click', closeModal);
        backdrop?.addEventListener('click', closeModal);
    }

    /* ===============================
       OPEN MODAL
    =============================== */
    function openModal(url) {

        const modal = document.getElementById('crudModal');
        const content = document.getElementById('crudContent');

        fetch(url)
            .then(r => r.text())
            .then(html => {
                content.innerHTML = html;
                modal.classList.add('show');
                bindAjaxForm();
            });
    }

    /* ===============================
       CLOSE MODAL
    =============================== */
    function closeModal() {

        const modal = document.getElementById('crudModal');
        const content = document.getElementById('crudContent');

        modal.classList.remove('show');

        setTimeout(() => {
            content.innerHTML = '';
        }, 200);
    }

    /* ===============================
       AJAX FORM FIX
    =============================== */
    function bindAjaxForm() {

        const form = document.querySelector('#crudContent form');
        if (!form) return;

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
            .then(r => r.text())
            .then(res => {

                // ✔ SUCCESS SIMPLE (tu controller devuelve "success")
                if (res.includes('success')) {

                    closeModal();
                    location.reload();
                    return;
                }

                // si no es success → recarga form con errores
                document.getElementById('crudContent').innerHTML = res;
                bindAjaxForm();
            })
            .catch(() => showToast('Error al guardar'));
        });
    }

    /* ===============================
       TOAST
    =============================== */
    function showToast(msg) {

        const toast = document.createElement('div');
        toast.className = 'custom-toast';
        toast.innerText = msg;

        document.body.appendChild(toast);

        setTimeout(() => toast.classList.add('show'), 20);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 2200);
    }

    /* ===============================
       EVENTOS GLOBALES (FIX REAL)
    =============================== */
    document.addEventListener('click', function (e) {

        const createBtn = e.target.closest('#openCreateModal');
        const editBtn = e.target.closest('.open-edit');

        if (createBtn) {
            e.preventDefault();
            openModal('/index.php?r=bitacoras/create');
            return;
        }

        if (editBtn) {
            e.preventDefault();
            openModal(editBtn.getAttribute('href'));
            return;
        }
    });

    /* ===============================
       EXPOSICIÓN GLOBAL (IMPORTANTE)
    =============================== */
    window.openModal = openModal;
    window.closeModal = closeModal;

    /* ===============================
       INIT
    =============================== */
    document.addEventListener('DOMContentLoaded', initBitacora);

})();