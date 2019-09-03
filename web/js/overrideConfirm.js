yii.confirm = function (message, okCallback, cancelCallback) {
    swal({
        title: message,
        type: 'error',
        cancelButtonText: 'Cancelar',
        showCancelButton: true,
        closeOnConfirm: true,
        allowOutsideClick: true
    }, okCallback);
};