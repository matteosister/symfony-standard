/* 
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

var width = 950;

$(document).ready( function() {
    //alert('si');
    $('#folder-chooser').show();
    var link = $('#folder-chooser').children('a');
    link.fancybox({
        width:  600,
        height: 600
    });
});

function selectFolder(id)
{
    $('#' + folder_widget_id).val(id);
}