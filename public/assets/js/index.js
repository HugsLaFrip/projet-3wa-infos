// Import js class
import Menu from './module/Menu.js';

// Instantiate js class
const menu = new Menu;

// Execute functions when dom is loaded
document.addEventListener('DOMContentLoaded', function () {
    menu.setMenuClass();
    menu.openMenu();
    menu.closeMenu()
});

// Execute functions when window is resized
window.addEventListener('resize', function () {
    menu.setMenuClass();
})