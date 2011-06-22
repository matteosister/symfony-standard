/* 
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

jQuery.fn.exists = function(){return jQuery(this).length>0;}

$(document).ready(function() {
    handleFlashMessages();
});

function handleFlashMessages()
{
    // FLASH Messages
    if ($('.flash-message').exists()) 
    {
        $('.flash-message').disableSelection();
        setTimeout(hideFlash, 5000);
    }
    
    function hideFlash()
    {
        $('.flash-message').fadeOut();
    }
}