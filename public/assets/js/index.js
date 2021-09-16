// Import js class
import Menu from './module/Menu.js';
import Background from './module/Background.js';
import Display from './module/Display.js';

// Instantiate js class
const menu = new Menu;
const background = new Background;
const display = new Display;

// Execute functions when dom is loaded
document.addEventListener('DOMContentLoaded', function () {
    display.displayMenu();
    display.displayContent();
    menu.openMenu();
    menu.closeMenu()
    background.setSize();
});

// Execute functions when window is resized
window.addEventListener('resize', function () {
    display.displayMenu();
    display.displayContent();
    background.setSize();
})