// Mobile Menu Toggle
function toggleMenu() {
    const navUl = document.querySelector('nav ul');
    if (navUl.classList.contains("open")) {
        navUl.classList.remove("open");
    } else {
        navUl.classList.add("open");
    }
}