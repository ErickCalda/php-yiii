

    
document.addEventListener("DOMContentLoaded", function(){

    const btn = document.getElementById("toggleSidebar");

    btn.addEventListener("click", function(){

        document.body.classList.toggle("sidebar-collapsed");

    });

});




document.addEventListener("DOMContentLoaded", function () {

    const shadow = document.getElementById('cursor-shadow');
    if (!shadow) return;

    document.addEventListener('mousemove', function (e) {
        shadow.style.left = e.clientX + 'px';
        shadow.style.top = e.clientY + 'px';
    });

});


// cuando carga la página
document.addEventListener('DOMContentLoaded', initCursorShadow);

// cuando recarga Pjax (IMPORTANTE en tu GridView)
$(document).on('pjax:end', initCursorShadow);


