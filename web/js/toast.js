document.addEventListener("DOMContentLoaded", function () {

    const flash = window.toastFlash;

    if (!flash) return;

    const toast = document.getElementById("toast");
    const message = document.getElementById("toast-message");
    const icon = document.getElementById("toast-icon");

    message.innerText = flash.message;

    // 🎨 iconos por tipo
    const icons = {
        success: "✅",
        error: "❌",
        warning: "⚠️",
        info: "ℹ️"
    };

    icon.innerText = icons[flash.type] || "ℹ️";

    toast.className = "toast show " + flash.type;

    setTimeout(() => {
        toast.className = "toast";
    }, 3500);
});