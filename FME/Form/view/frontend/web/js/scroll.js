require(['jquery'], function($) {
    $(document).ready(function() {
        $('#scrollButton').on('click', function() {
            // Scroll to the target element
            $('html, body').animate({
                scrollTop: $('#namefield').offset().top
            }, 1000); // Adjust scroll speed if needed
        });
    });
});


// define([
//     'jquery'
// ], function($) {
//     'use strict';

//     return function() {
//         $(document).ready(function() {
//             // Define the target element to scroll to
//             var targetElement = $('#name');

//             // Check if the target element exists on the page
//             if (targetElement.length) {
//                 // Calculate the offset of the target element
//                 var targetOffset = targetElement.offset().top;

//                 // Animate the scroll to the target position
//                 $('html, body').animate({
//                     scrollTop: targetOffset
//                 }, 'slow');
//             }
//         });
//     };
// });
