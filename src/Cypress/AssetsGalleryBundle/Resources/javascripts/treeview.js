/* 
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */


$(document).ready( function() {
    $('.treeview').treeview();
    $('.treeview').find('a.icon-folder').each (function() {
        $(this).click( function() {
            parent.$.fancybox.close();
            parent.selectFolder($(this).attr('id'));
        })
    });
});