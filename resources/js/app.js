import './bootstrap';

Echo.private('notifications')
    .listen('UserSessionChanged', (e) => {
        console.log(e);
        const notiElement = document.getElementById('notification');
        notiElement.innerHTML = `
                <span>Thông báo: ${e.message}</span>
             `

        notiElement.classList.remove('invisible')
        notiElement.classList.remove('alert-success')
        notiElement.classList.remove('alert-danger')
        notiElement.classList.remove('show')
        notiElement.classList.add('alert-'+e.type)
        notiElement.classList.add('show')

        setTimeout(() => {
            notiElement.classList.remove('show');
            notiElement.classList.add('invisible');
        }, 5000); // 5 giây
    })