function createDateRange($target, callback) {
    var inputDateFormat = 'YYYY-MM-DD';
    var $fromInput = $target.find('#from');
    var $toInput = $target.find('#to');
    var created_from = $fromInput.val();
    var created_to = $toInput.val();

    $target.find('span').html(moment(created_from).format('MMMM D, YYYY') + ' - ' + moment(created_to).format('MMMM D, YYYY'));

    $target.daterangepicker({
        startDate: moment(created_from).format('MM/DD/YYYY HH:mm:ss'),
        endDate: moment(created_to).format('MM/DD/YYYY HH:mm:ss'),
        format: 'MM/DD/YYYY HH:mm:ss',
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        alwaysShowCalendars: true,
        opens: $target.data('opens'),
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function (start, end) {
        $fromInput.val(start.format(inputDateFormat));
        $toInput.val(end.format(inputDateFormat));
        $target.find('span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        callback($target, start.format(inputDateFormat), end.format(inputDateFormat));
    });
}

$(document).ready(function () {

    $(".multiselect").select2({});
    $(".sync-types").chosen().on('change', function () {
        var values = $(this).val().toString();
        $('#sync-mode').val(values);
    });

    //fastFilter is grid view TD click to fast select or type value in
    $('.fastFilter').each(function () {
        $(this).css('color', 'rgb(51, 122, 183)');
        $(this).css('cursor', 'pointer');
        $(this).attr('title', 'fast filter by this value');
    });
    $('.fastFilter').on('click', function () {
        var value = $(this).html();
        var index = $(this).index();
        var filter = $(this).parents('table').first().find('.filters td').eq(index);
        var input = filter.find('input[type="text"]');
        var select = filter.find('select');
        if (input.length == 1) {
            input.val(value);
            input.change();
            return;
        }
        if (select.length == 1) {
            select.find('option').each(function () {
                if ($(this).html() == value) {
                    $(this).attr('selected', 'selected');
                    return false;
                }
            });
            select.change();
            return;
        }
    });
});