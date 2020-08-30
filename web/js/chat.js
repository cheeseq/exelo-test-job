$(function () {
  const chat = new WebSocket('ws://localhost:8081');
  
  const currentChatUsername = $('#send_chat_username').val();
  const messagesContainer = $('.msg_history');
  const sendMessageForm = $('#send_msg_form');
  
  const incomingMessageTemplate = (response) => `
    <div class="incoming_msg">
        <div class="received_msg">
            <div class="received_withd_msg">
              <p>${response.message}</p>
              <span class="time_date">From: ${response.from} | ${response.date}</span>
            </div>
        </div>
    </div>`;
  
  const outgoingMessageTemplate = (response) => `
    <div class="outgoing_msg">
        <div class="sent_msg">
            <p>${response.message}</p>
            <span class="time_date">From: ${response.from} | ${response.date}</span>
        </div>
    </div>`;
  
  const scrollChatToBottom = () => {
    messagesContainer.scrollTop(messagesContainer.prop("scrollHeight"));
  };
  
  scrollChatToBottom();
  
  chat.onmessage = (e) => {
    let response = JSON.parse(e.data);
    
    if (!response.success) {
      alert(response.error);
      return;
    }
    
    if (response.type && response.type === 'chat') {
      messagesContainer.append(response.from === currentChatUsername ? outgoingMessageTemplate(response) : incomingMessageTemplate(response));
      scrollChatToBottom();
    }
  };
  
  sendMessageForm.on("submit", (e) => {
    e.preventDefault();
    
    if ($('.write_msg').val()) {
      chat.send(JSON.stringify({'action': 'chat', 'message': $('.write_msg').val(), 'name': currentChatUsername}));
      $('.write_msg').val("");
    } else {
      alert('Enter the message')
    }
  })
})
