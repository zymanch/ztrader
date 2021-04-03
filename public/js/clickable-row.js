/**
 * Created by aleksey on 27.10.16.
 */
$(document).ready(function () {
    $('tr.clickable-row').click(function (e) {
        var id = $(this).data('key'),
            url = $(this).data('click-path');
        location.href = url + '?id=' + id;
    });
});
