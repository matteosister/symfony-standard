/* 
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

jQuery.fn.exists = function(){return jQuery(this).length>0;}

$(document).ready( function() {
    $('section.assets-list').sortable({
        cursor: 'crosshair',
        items:  'article.folder'
    });
    
    $('section.assets-list').bind( "sortstop", function(event, ui) {
        console.log($(this).sortable("toArray"));
    });
    
    $('section.assets-list').disableSelection();
    $('section.assets-list article').each (function() {
        $(this).children('a.action.delete').click( function() {
            return confirm('Are you sure?');
        });
        $(this).children('a.action').animate({
            left: '-=100px'
        }, 0);

        $(this).hover( function() {
            $(this).addClass('hover');
        }, function() {
            $(this).removeClass('hover');
        });

        var config = {    
            over: showActions,   
            timeout: 50,    
            out: hideActions  
        };
        $(this).hoverIntent(showActions, hideActions);
        function showActions() {
            //$(this).children('a.action').fadeIn('fast');
            $(this).children('a.action').animate({
                left: '+=100px'
            }, {duration: 400, 'easing': 'easeOutQuad'});
        }
        function hideActions() {
            //$(this).children('a.action').fadeOut('slow');
            $(this).children('a.action').animate({
                left: '-=100px'
            }, {duration: 600, 'easing': 'easeOutQuad'});
        }
    });
});