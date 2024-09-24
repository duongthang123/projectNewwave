const currentUser = window.currentUser;
const listMessage = [];
const scrollMessage = $('#scroll-list-message');
const usersElement = $('#users');
const messagesElement = $('#messages');
const typingElement = $('#typing-status');

Echo.join('chat')
    .here((users) => {
        users.forEach((user, index) => {
            const element = `
                <li id="${user.id}" class="p-2 border-bottom">
                    <a href="#" class="d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-row align-items-center">
                            <div>
                                <img src="${user.images}" style="border-radius:50%" alt="avatar" class="d-flex align-self-center me-3" width="60">
                                <span class="badge bg-warning badge-dot"></span>
                            </div>
                            <div class="pt-1 ml-2">
                                <p class="fw-bold mb-0">${user.name}</p>
                            </div>
                        </div>
                        <div class="pt-1">
                            <p style="color: #31a24c; font-weight: 600" class="small mb-1">Online</p>
                        </div>
                    </a>
                </li>
            `;
            usersElement.append(element);
        });
    })
    .joining(user => {
        const element = `
            <li id="${user.id}" class="p-2 border-bottom">
                <a href="#" class="d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-row align-items-center">
                        <div>
                            <img src="${user.images}" alt="avatar" class="d-flex align-self-center me-3" style="border-radius:50%" width="60">
                            <span class="badge bg-warning badge-dot"></span>
                        </div>
                        <div class="pt-1 ml-2">
                            <p class="fw-bold mb-0">${user.name}</p>
                        </div>
                    </div>
                    <div class="pt-1">
                        <p style="color: #31a24c; font-weight: 600" class="small mb-1">Online</p>
                    </div>
                </a>
            </li>
        `;
        usersElement.append(element);
        showNotify(`${user.name} đã tham gia trò chuyện`, 'success');
    })
    .leaving(user => {
        $(`#${user.id}`).remove();
        showNotify(`${user.name} đã rời cuộc trò chuyện`, 'danger');
    })
    .listen('MessageSent', (e) => {
        const time = new Date();
        const timeFormat = time.getHours() + ':' + time.getMinutes() + ', Hôm nay ';

        let element;
        if (e.user.name === currentUser.name) {
            element = `
                <li class="d-flex flex-row justify-content-end">
                    <div>
                        <p style="border-radius:4px " class="small p-2 me-3 mb-1 text-white mr-2 rounded-3 bg-primary">${e.message}</p>
                        <p class="small me-3 mb-3 rounded-3 text-muted">${timeFormat}</p>
                    </div>
                    <img src="${e.image}" alt="avatar 1" style="width: 45px; height: 100%;border-radius:50%">
                </li>
            `;
        } else {
            element = `
                <li class="d-flex flex-row justify-content-start">
                    <img src="${e.image}" alt="avatar 1" style="width: 45px; height: 100%;border-radius:50%">
                    <div>
                        <p class="small me-3 mb-2 rounded-3 text-muted ml-2">${e.user.name}</p>
                        <p class="small p-2 ms-3 mb-1 ml-2 rounded-3" style="border-radius:4px;background-color: #ddd;">
                            ${e.message}
                        </p>
                        <p class="small ms-3 mb-3 rounded-3 text-muted float-end">${timeFormat}</p>
                    </div>
                </li>
            `;
        }
        messagesElement.append(element);
        scrollMessage.scrollTop(scrollMessage.prop('scrollHeight'));
    })
    .listenForWhisper('typing', (e) => {
        if (e.typing) {
            typingElement.text('Người khác đang nhập...');
        } else {
            typingElement.text('');
        }
    });