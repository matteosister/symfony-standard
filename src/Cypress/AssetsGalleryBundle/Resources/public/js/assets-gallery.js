/* 
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

jQuery.fn.exists = function(){return jQuery(this).length>0;}

$(document).ready( function() {
    if ($('section.assets-list').exists) {
        $('section.assets-list article').each (function() {
            $(this).children('a.delete').hide();
            $(this).hover(onHover, onOut);
            function onHover() {
                $(this).children('a.delete').fadeIn('fast')
            }
            
            function onOut() {
                $(this).children('a.delete').fadeOut('slow')
            }
        });
    }
});