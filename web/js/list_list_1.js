/* 
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

var urlCallSort; // from template

$(document).ready( function() {
    
    // UI Sortable
    $('section.assets-list').sortable({
        cursor: 'crosshair',
        items:  'article.folder',
        handle: 'a.action.drag',
        opacity: 0.5,
        placeholder: "highlight"
    });
    
    $('section.assets-list').bind( "sortstop", function(event, ui) {
        folderId = ui.item.attr('id');
        newPosition = $(this).sortable('toArray').indexOf(ui.item.attr('id'));
        
        $.ajax({
            url: urlCallSort,
            type: 'POST',
            data: 'folder_id=' + folderId + '&new_position=' + newPosition,
            success: function(msg){
            }
        });
    });
    
    $('section.assets-list').disableSelection();
    
    // List actions
    $('section.assets-list article').each (function() {
        $(this).children('a.action.delete').click( function() {
            return confirm('Are you sure?');
        });
        setDefaultActionsPosition($(this), 0);

        $(this).hover( function() {
            $(this).addClass('hover');
        }, function() {
            $(this).removeClass('hover');
        });

        var config = {    
            over: showActions,   
            timeout: 2000,    
            out: hideActions  
        };
        $(this).hoverIntent(config);
        function showActions() {
            $(this).children('a.action').animate({
                opacity: 1,
                left: "+=5px"
            }, 200);
        }
        function hideActions() {
            setDefaultActionsPosition($(this), 400);
        }
        function setDefaultActionsPosition(elm, time)
        {
            elm.children('a.action').animate({
                opacity: 0.5,
                left: "-=5px"
            }, time);
        }
    });
    
});