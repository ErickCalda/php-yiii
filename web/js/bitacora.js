


let observer = null;
let topBtn = null;
let bitacoraInitialized = false;

(function () {

    /* ===============================
       INIT PRINCIPAL
    =============================== */
    function initBitacora() {

        // 🔥 evitar re-init duplicado dentro del mismo ciclo
        resetBitacora();

        forceViewSync();
        initViews();
        initCards();
        initRipple();
        initTopButton();
        initModal();
    }


    /* ===============================
       RESET TOTAL SEGURO
    =============================== */
    function resetBitacora() {

        bitacoraInitialized = false;

        // 🔥 limpiar observer anterior
        if (observer) {
            observer.disconnect();
            observer = null;
        }

        // 🔥 limpiar animaciones previas
        document.querySelectorAll('.log-card').forEach(el => {
            el.classList.remove('show-card');
        });
    }


    /* ===============================
       FORZAR VISTA (TIMELINE / TABLE)
    =============================== */
    function forceViewSync() {

        const saved = localStorage.getItem('bitacoraView') || 'timeline';

        const timeline = document.getElementById('timelineView');
        const table = document.getElementById('tableView');

        if (!timeline || !table) return;

        // 🔥 IMPORTANTE: evitar doble render visual
        timeline.style.display = 'none';
        table.style.display = 'none';

        if (saved === 'table') {
            table.style.display = 'block';
        } else {
            timeline.style.display = 'block';
        }
    }


    /* ===============================
       VISTAS (TIMELINE / TABLE)
    =============================== */
    function initViews() {

        const btnTimeline = document.getElementById('btnTimeline');
        const btnTable = document.getElementById('btnTable');

        const timeline = document.getElementById('timelineView');
        const table = document.getElementById('tableView');

        if (!btnTimeline || !btnTable || !timeline || !table) return;

        function activate(btn) {
            document.querySelectorAll('.view-btn')
                .forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }

        function showTimeline() {

            table.style.display = 'none';
            timeline.style.display = 'block';

            activate(btnTimeline);
            localStorage.setItem('bitacoraView', 'timeline');

            requestAnimationFrame(() => initCards());
        }

        function showTable() {

            timeline.style.display = 'none';
            table.style.display = 'block';

            activate(btnTable);
            localStorage.setItem('bitacoraView', 'table');
        }

        btnTimeline.onclick = showTimeline;
        btnTable.onclick = showTable;

        const saved = localStorage.getItem('bitacoraView');

        if (saved === 'table') showTable();
        else showTimeline();


        /* 🔥 BLOQUEAR TECLAS MIENTRAS ESCRIBE */
        document.addEventListener('keydown', function (e) {

            const isTyping = ['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName);

            if (isTyping) return;

            if (e.key === 't') showTimeline();
            if (e.key === 'g') showTable();

            if (e.key === '/') {
                e.preventDefault();
                document.querySelector('.search-input')?.focus();
            }

            if (e.key === 'Escape') closeModal();
        });
    }


    /* ===============================
       CARDS (SIN DUPLICADOS)
    =============================== */
    function initCards() {

        if (observer) {
            observer.disconnect();
            observer = null;
        }

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
       RIPPLE
    =============================== */
    function initRipple() {

        document.querySelectorAll('.view-btn,.btn-primary').forEach(btn => {

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
                ripple.style.background = 'rgba(255,255,255,.45)';
                ripple.style.transform = 'scale(0)';
                ripple.style.transition = '.55s ease';
                ripple.style.pointerEvents = 'none';

                btn.appendChild(ripple);

                requestAnimationFrame(() => {
                    ripple.style.transform = 'scale(18)';
                    ripple.style.opacity = '0';
                });

                setTimeout(() => ripple.remove(), 550);
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

        window.addEventListener('scroll', function () {

            if (window.scrollY > 280) {
                topBtn.classList.add('show-top');
            } else {
                topBtn.classList.remove('show-top');
            }

        });
    }


    /* ===============================
       MODAL
    =============================== */
    function initModal() {

        const modal = document.getElementById('crudModal');
        if (!modal) return;

        const closeBtn = document.getElementById('closeCrudModal');
        const backdrop = modal.querySelector('.crud-backdrop');

        closeBtn?.addEventListener('click', closeModal);
        backdrop?.addEventListener('click', closeModal);
    }


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


    function closeModal() {

        const modal = document.getElementById('crudModal');
        const content = document.getElementById('crudContent');

        modal.classList.remove('show');

        setTimeout(() => {
            content.innerHTML = '';
        }, 200);
    }


    /* ===============================
       AJAX FORM (SIN PJAX PROBLEMS)
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

                if (res.includes('success')) {

                    closeModal();

                    // 🔥 RECARGA LIMPIA SIN DUPLICAR
                    location.reload();

                } else {
                    document.getElementById('crudContent').innerHTML = res;
                    bindAjaxForm();
                }

            })
            .catch(() => {
                showToast('Ocurrió un error');
            });
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
       EVENTS GLOBALES
    =============================== */
    document.addEventListener('click', function (e) {

        const createBtn = e.target.closest('#openCreateModal');
        const editBtn = e.target.closest('.open-edit');

        if (createBtn) {
            e.preventDefault();
            openModal('/index.php?r=bitacoras/create');
        }

        if (editBtn) {
            e.preventDefault();
            openModal(editBtn.href);
        }

    });


    /* ===============================
       INIT
    =============================== */
    document.addEventListener('DOMContentLoaded', initBitacora);

})();







