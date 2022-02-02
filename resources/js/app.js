require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.removeNotification = function (e) {
    let block = e.parentNode.parentNode;
    block.classList.add('translate-x-full');
    block.classList.add('opacity-0');
    setTimeout(function() {
        block.remove();
    }, 500)
}
