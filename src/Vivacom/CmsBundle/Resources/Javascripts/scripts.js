/* 
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

jQuery.fn.exists = function(){return jQuery(this).length>0;}

$(document).ready( function() {
  if ($('section.message').exists) {
    $('section.message').fadeIn();
    setTimeout(hideMessage, 5000, $('section.message'));
  }
  
  function hideMessage(element) {
    element.fadeOut();
  }
});