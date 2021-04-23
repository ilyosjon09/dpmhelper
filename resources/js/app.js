
require('./bootstrap');

require('alpinejs');
require(['clipboard'], function(ClipboardJS) {
   new ClipboardJS('.btn');
});
// require(['pikaday'], function (Pikaday) {
//     var picker = new Pikaday(
//         { 
//             field: document.getElementById('birth_date'),
//             format: 'DD.MM.YYYY' 
//         });
// });