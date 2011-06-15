/* 
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

jQuery.fn.exists = function(){return jQuery(this).length>0;}

$(document).ready( function() {
    if ($('section.assets-list').exists) {
        $('section.assets-list article').each (function() {
            $(this).children('a.action.delete').click( function() {
                return confirm('Are you sure?');
            });
            $(this).children('a.action').animate({
                left: '-=100px'
            }, 0);
            var config = {    
                over: showActions,   
                timeout: 150,    
                out: hideActions  
            };
            $(this).hover( function() {
                $(this).addClass('hover');
            }, function() {
                $(this).removeClass('hover');
            });
            
            $(this).hoverIntent(config);
            
            function showActions() {
                //$(this).children('a.action').fadeIn('fast');
                $(this).children('a.action').animate({
                    left: '+=100px'
                }, { duration: 400, 'easing': 'easeOutQuad' });
                
            }
            function hideActions() {
                //$(this).children('a.action').fadeOut('slow');
                $(this).children('a.action').animate({
                    left: '-=100px'
                }, { duration: 600, 'easing': 'easeOutQuad' });
            }
        });
    }
});