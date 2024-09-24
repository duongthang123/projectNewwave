function showNotify(message, type) {
    const notiElement = $('#notification')
    notiElement.html(`<span>Thông báo: ${message}</span>`)

    notiElement.removeClass('invisible')
    notiElement.removeClass('alert-success')
    notiElement.removeClass('alert-danger')
    notiElement.removeClass('show')
    notiElement.addClass('alert-' + type)
    notiElement.addClass('show')

    setTimeout(() => {
        notiElement.removeClass('show')
        notiElement.addClass('invisible')
    }, 5000); 
}