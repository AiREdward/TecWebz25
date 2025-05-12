// Mobile Menu Toggle
function toggleMenu() {
    const navUl = document.querySelectorAll('nav ul');
    for (let i = 0; i < navUl.length; i++) {
        if (navUl[i].classList.contains("open")) {
            navUl[i].classList.remove("open");
        }
        else {
            navUl[i].classList.add("open");
        }
    }
    replaceIcon("burgermenu-button");
}

function replaceIcon(iconId) {
    root = "/tecwebz25"
    firstIcon = "/assets/images/burgermenu.webp";
    secondIcon = "/assets/images/closeburgermenu.webp";
    currentIcon = extractImagePath(document.getElementById(iconId).src);

    if (currentIcon == firstIcon) {
        document.getElementById(iconId).src = root+secondIcon;
    } else {
        document.getElementById(iconId).src = root+firstIcon;
    }
}

function extractImagePath(urlString) {
    try {
        const url = new URL(urlString);
        const parts = url.pathname.split('/').filter(part => part !== '');

        const startIndex = parts.findIndex((part, i) => part === 'assets' && parts[i + 1] === 'images');
        if (startIndex === -1) throw new Error('"/assets/images/" not found in URL');

        return `/${parts.slice(startIndex).join('/')}`;
    } catch (e) {
        console.error('Error:', e.message);
        return null;
    }
}