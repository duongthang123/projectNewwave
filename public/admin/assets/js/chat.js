const messageElement = $('#message');
const sendElement = $('#send');
let typingTimeout;

messageElement.on('input', function() {
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

sendElement.on('click', function(e) {
    e.preventDefault();
    axios.post('/chats/message', {
        message: messageElement.val(),
    });

    messageElement.val('');
});