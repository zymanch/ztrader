$(document).on('show.bs.modal', '#callback-request-modal', function (event) {
    var button = $(event.relatedTarget),
        dataAsJson = button.data('request-json'),
        modal = $(this);
    modal.find('.modal-body').html('Loading...');

    var html = '';
    if(dataAsJson == null){
        html = 'No data for this callback';
    } else {
        html = displayJSONObject(dataAsJson);
    }
    modal.find('.modal-body').html(html);
});

function displayJSONObject(dataAsJson) {
    var html = '<table class="json-item">';
    $.each(dataAsJson, function (i, e) {
        if(e != null && typeof e == 'object'){
            e = displayJSONObject(e);
        }
        html += '<tr>' + displayJSONElement(i, e) + '</tr>';
    });
    return html += '</table>';
}
function displayJSONElement(i, e) {
    var tdClass = '';
    if(!isNaN(i)){
        tdClass = 'empty-cell';
        i = '';
    }
    return '<td class="' + (tdClass ? tdClass : '') + '">' + i + '</td><td>' + e + '</td>'
}

$(document).on('show.bs.modal', '#message-modal', function (event) {
    var button = $(event.relatedTarget),
        text = button.data('message'),
        modal = $(this);
    modal.find('.modal-body').html(text);
});