function initSidebar(){

    const btn = document.getElementById("toggleSidebar");
    if(!btn) return;

    btn.onclick = function(){

        document.body.classList.toggle("sidebar-collapsed");

    };

}

document.addEventListener("DOMContentLoaded", initSidebar);
$(document).on('pjax:end', initSidebar);

// cuando carga la página
document.addEventListener('DOMContentLoaded', initCursorShadow);

// cuando recarga Pjax (IMPORTANTE en tu GridView)
$(document).on('pjax:end', initCursorShadow);





