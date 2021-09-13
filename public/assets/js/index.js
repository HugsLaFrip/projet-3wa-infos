// Import js class
import Menu from './module/Menu.js';
import Background from './module/Background.js';

// Instantiate js class
const menu = new Menu;
const background = new Background;

// Execute functions when dom is loaded
document.addEventListener('DOMContentLoaded', function () {
    menu.setMenuClass();
    menu.openMenu();
    menu.closeMenu()
    background.setSize();
});

// Execute functions when window is resized
window.addEventListener('resize', function () {
    menu.setMenuClass();
    background.setSize();
})