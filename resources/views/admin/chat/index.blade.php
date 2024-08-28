@extends('admin.layouts.index')

@section('title', 'Trò chuyện')
@section('content')
    <div class="card-body">
            <div class="row">
                <div style="overflow: scroll" class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0 d-none d-md-block">
                    <div class="p-3">

                        <div class="input-group rounded mb-3">
                            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon">
                            <span class="input-group-text border-0" id="search-addon">
                                                <i class="fas fa-search"></i>
                                        </span>
                        </div>

                        <div data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px;">
                            <ul id="users" class="list-unstyled mb-0">
                            </ul>
                        </div>

                    </div>
                </div>

                <div  class="col-md-6 col-lg-7 col-xl-8">

                    <div id="scroll-list-message" class="pt-3 pe-3" data-mdb-perfect-scrollbar="true" style="position: relative; min-height: 85vh; overflow: scroll">


                        <div  data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px;">
                            <ul id="messages" class="messages list-unstyled mb-0">
                            </ul>
                        </div>

                    </div>

                    <div id="typing-status" class="p-2 text-muted" style="font-style: italic;"></div>

                    <form class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                        <input type="text" id="message" class="form-control" placeholder="Nhập tin nhắn...">
                        <button id="send" class="ms-3 btn btn-primary sm"><i class="fas fa-paper-plane"></i></button>
                    </form>

                </div>
            </div>
    </div>
@endsection

{{-- @section('script')
    <script type="module">
        const usersElement = document.getElementById('users');
        const messagesElement = document.getElementById('messages');
        const currentUser = @json(auth()->user());
        const listMessage = [];
        const scrollMessage = document.getElementById('scroll-list-message')

        const typingElement = document.getElementById('typing-status');

        Echo.join('chat')
            .here((users) => {
                users.forEach((user, index) => {
                    const element = `
                        <li id="${user.id}" class="p-2 border-bottom">
                            <a href="#" class="d-flex justify-content-between  align-items-center">
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
                    usersElement.insertAdjacentHTML('beforeend', element);
                });
            })
            .joining(user => {
                const element = `
                        <li id="${user.id}" class="p-2 border-bottom">
                            <a href="#" class="d-flex justify-content-between  align-items-center">
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
                usersElement.insertAdjacentHTML('beforeend', element);
                showNotify(user.name + ' đã tham gia trò chuyện', 'success');
            })
            .leaving(user => {
                const element = document.getElementById(user.id)
                element.parentNode.removeChild(element)
                showNotify(user.name + ' đã rời cuộc trò chuyện', 'danger');
            })
            .listen('MessageSent', (e) => {
                const time = new Date();
                const timeFormat = time.getHours() + ':' + time.getMinutes() + ', Hôm nay '
                
                if(e.user.name === currentUser.name) {
                    const element = `
                                <li class="d-flex flex-row justify-content-end">
                                    <div>
                                        <p style="border-radius:4px " class="small p-2 me-3 mb-1 text-white mr-2 rounded-3 bg-primary">${e.message}</p>
                                        <p class="small me-3 mb-3 rounded-3 text-muted">${timeFormat}</p>
                                    </div>
                                    <img src="${e.image}" alt="avatar 1" style="width: 45px; height: 100%;border-radius:50%">
                                </li>

                 `;
                    messagesElement.insertAdjacentHTML('beforeend', element)
                } else {
                    const element = `
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
                    messagesElement.insertAdjacentHTML('beforeend', element)
                }

                scrollMessage.scrollTop = scrollMessage.scrollHeight;
            })
            .listenForWhisper('typing', (e) => {
                if (e.typing) {
                    typingElement.textContent = 'Người khác đang nhập...';
                } else {
                    typingElement.textContent = '';
                }
            });
    </script>

    <script type="module">
        const messageElement = document.getElementById('message');
        const sendElement = document.getElementById('send')

        let typingTimeout;
        messageElement.addEventListener('input', (e) => {
            Echo.join('chat').whisper('typing', {
                typing: true
            })

            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
                Echo.join('chat').whisper('typing', {
                    typing: false
                })
            }, 1000);
        });
        
        sendElement.addEventListener('click', (e) => {
            e.preventDefault();
            window.axios.post('/chats/message', {
                message: messageElement.value,
            })

            messageElement.value = '';

            Echo.join('chat')
                .whisper('typing', { typing: false });
        });
    </script>
    <script>
        function showNotify(message, type) {
            const notiElement = document.getElementById('notification');
            notiElement.innerHTML = `
                <span>Thông báo: ${message}</span>
             `

            notiElement.classList.remove('invisible')
            notiElement.classList.remove('alert-success')
            notiElement.classList.remove('alert-danger')
            notiElement.classList.remove('show')
            notiElement.classList.add('alert-'+type)
            notiElement.classList.add('show')

            setTimeout(() => {
                notiElement.classList.remove('show');
                notiElement.classList.add('invisible');
            }, 5000); 
        }
    </script>
@endsection --}}

@section('script')
<script type="module">
    const currentUser = @json(auth()->user());
    const listMessage = [];
    const $scrollMessage = $('#scroll-list-message');
    const $usersElement = $('#users');
    const $messagesElement = $('#messages');
    const $typingElement = $('#typing-status');

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
                $usersElement.append(element);
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
            $usersElement.append(element);
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
            $messagesElement.append(element);
            $scrollMessage.scrollTop($scrollMessage.prop('scrollHeight'));
        })
        .listenForWhisper('typing', (e) => {
            if (e.typing) {
                $typingElement.text('Người khác đang nhập...');
            } else {
                $typingElement.text('');
            }
        });
</script>

<script type="module">
    const $messageElement = $('#message');
    const $sendElement = $('#send');

    let typingTimeout;
    $messageElement.on('input', function() {
        Echo.join('chat').whisper('typing', {
            typing: true
        });

        clearTimeout(typingTimeout);
        typingTimeout = setTimeout(() => {
            Echo.join('chat').whisper('typing', {
                typing: false
            });
        }, 1000);
    });

    $sendElement.on('click', function(e) {
        e.preventDefault();
        axios.post('/chats/message', {
            message: $messageElement.val(),
        });

        $messageElement.val('');

        Echo.join('chat')
            .whisper('typing', { typing: false });
    });
</script>

<script>
    function showNotify(message, type) {
        const notiElement = document.getElementById('notification');
        notiElement.innerHTML = `
            <span>Thông báo: ${message}</span>
         `

        notiElement.classList.remove('invisible')
        notiElement.classList.remove('alert-success')
        notiElement.classList.remove('alert-danger')
        notiElement.classList.remove('show')
        notiElement.classList.add('alert-'+type)
        notiElement.classList.add('show')

        setTimeout(() => {
            notiElement.classList.remove('show');
            notiElement.classList.add('invisible');
        }, 5000); 
    }
</script>
@endsection