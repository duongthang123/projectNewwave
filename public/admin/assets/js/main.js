$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

document.querySelectorAll('.delete-button').forEach(button => {
    button.addEventListener('click', function() {
        const url = this.getAttribute('data-url');
        document.getElementById('confirm-delete').setAttribute('data-url', '/' + url);
    });
})

document.getElementById('confirm-delete').addEventListener('click', function() {
    const url = this.getAttribute('data-url');
    removeUrl(url);
    $('#modal-default').modal('hide');
})

function removeUrl(url) {
    $.ajax({
        type: 'DELETE',
        url: url,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result) {
            if(result.error === false) {
                const parts = url.split('/');
                window.location.href = '/' + parts[1];
            }
        }
    })
}