let messages = [];

window.addEventListener('load', () => {
    addToMessages(0);
});
setInterval(() => {
    addToMessages(messages.length);
}, 2000);

function addToMessages(id){
  fetch('/text_chat/api/sendMessages.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
  },
  body: JSON.stringify({lastKnownMessage: id})
  })
  .then(response => {
    if (!response.ok) {
      throw new Error(`HTTP-Fehler: ${response.status}`);
    }
  return response.json();
  })
  .then(data => {
    if (Array.isArray(data)) {
      renderMessages(data);
      messages.push(...data);
    } else {
      console.error('Antwort ist kein Array:', data);
    }
  })
  .catch(error => {
    console.error('Fehler beim Abrufen der Nachrichten:', error);
  });
  };

function renderMessages(newMessages) {
  const textbox = document.getElementById('textBox');

  newMessages.forEach(msg => {
    const messageDiv = document.createElement('div');
    
    if (msg.ownMessage) {
      messageDiv.classList.add('ownMessage');
    } else{
      messageDiv.classList.add('notOwnMessage');
    }
    messageDiv.innerHTML = `${msg.creator}: <br> ${msg.content}`;
    textbox.appendChild(messageDiv);
  });
}

document.addEventListener('DOMContentLoaded', function () {
const sendButton = document.getElementById('sendButton');

sendButton.addEventListener('click', function () {
    const messageBox = document.getElementById('messageBox');
    const message = messageBox.value;
    document.getElementById("messageBox").value = "";
    fetch('/text_chat/api/getMessage.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ message: message })
    })
    .catch(error => {
      console.error('Fehler beim Senden der Nachricht:', error);
    });
  });
});
