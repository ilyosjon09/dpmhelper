
require('./bootstrap');

require('alpinejs');

require(['pikaday'], function (Pikaday) {
    var picker = new Pikaday(
        { 
            field: document.getElementById('birth_date'),
            format: 'DD.MM.YYYY' 
        });
});