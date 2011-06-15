/* 
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

jQuery.fn.exists = function(){return jQuery(this).length>0;}

$(document).ready( function() {
    if ($('section.assets-list').exists) {
        $('section.assets-list article').each (function() {
            $(this).children('a.action').hide();
            var config = {    
                over: showActions, // function = onMouseOver callback (REQUIRED)    
                timeout: 50, // number = milliseconds delay before onMouseOut    
                out: hideActions // function = onMouseOut callback (REQUIRED)    
            };
            $(this).hoverIntent(config);
            function showActions() {
                $(this).children('a.action').fadeIn('fast')
            }
            function hideActions() {
                $(this).children('a.action').fadeOut('slow')
            }
        });
    }
});