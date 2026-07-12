/**
 * Auto-initialize Choices.js on all elements with .js-choices class
 */
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const selects = document.querySelectorAll('.js-choices');
        
        selects.forEach(function(select) {
            new Choices(select, {
                searchEnabled: true,
                searchPlaceholderValue: 'Search...',
                itemSelectText: '',
                shouldSort: false
            });
        });
    });
})();