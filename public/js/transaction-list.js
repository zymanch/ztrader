$(document).on('show.bs.modal', '#transaction-data-modal', function (event) {
    var button = $(event.relatedTarget),
        paymentId = button.data('payment-id'),
        modal = $(this);
    modal.find('.modal-title').text('Transaction #' + paymentId);
    modal.find('.modal-body').html('Loading...');

    $.get('/transactions/transaction-data', {id: paymentId}, function (response) {
        if(response.result == 'error'){
            alert(response.message);
        } else {
            var html = '';
            if(!response.transaction_data.length){
                html = 'No data for this transaction';
            } else {
                $.each(response.transaction_data, function (i, e) {
                    html += '<p>' + i + ': ' + e + '</p>'
                });
            }
            modal.find('.modal-body').html(html);
        }
    }).fail(function (jqXHR, msg) {
        alert(msg);
    })
});

$(document).on('click', '#refund-transaction-button', function (event) {
    var button = $(this),
        refundAmount = $('#refund-amount').val(),
        refundReason = $('#refund-reason').val(),
        websiteUserId = $('#refund-user-id').val(),
        paymentId = $('#refund-payment-id').val();
    if(!refundAmount || !refundReason || !websiteUserId || !paymentId){
        toastr.warning('Fill all fields');
        return false;
    }
    button.text('Processing...');
    button.prop('disabled', true);
    $.post('/transactions/refund', {
        amount: refundAmount,
        reason: refundReason,
        websiteUserId: websiteUserId,
        paymentId: paymentId
    }, function (result) {
        if(result.result == 'error'){
            alert(result.message);
        } else if(result.result == 'ok'){
            alert(result.message);
            location.reload();
        }
        button.text('Refund');
        button.prop('disabled', false);
    }).fail(function (jqXHR, error) {
        alert(jqXHR.responseText);
        button.text('Refund');
        button.enable();
    });
    return false;
});

$(document).on('show.bs.modal', '#transaction-refund-modal', function (event) {
    var button = $(event.relatedTarget),
        paymentId = button.data('payment-id'),
        transactionAmount = button.data('payment-amount'),
        userId = button.data('website-user-id'),
        modal = $(this);
    modal.find('.modal-title').text('Refunding Transaction #' + paymentId);
    modal.find('textarea').val('');
    modal.find('#refund-amount').val(transactionAmount);
    modal.find('#refund-user-id').val(userId);
    modal.find('#refund-payment-id').val(paymentId);
});


$(document).on('show.bs.modal', '#message-modal', function (event) {
    var button = $(event.relatedTarget),
        text = button.data('message'),
        modal = $(this);
    modal.find('.modal-body').html(text);
});