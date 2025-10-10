const chatToggle = document.getElementById('chat-toggle');
const chatbot = document.getElementById('chatbot');
const closeChat = document.getElementById('close-chat');
const sendBtn = document.getElementById('send-btn');
const userInput = document.getElementById('user-input');
const messages = document.getElementById('messages');

// Open chat
chatToggle.addEventListener('click', () => {
    chatbot.style.display = 'flex';
    chatToggle.style.display = 'none';
});

// Close chat
closeChat.addEventListener('click', () => {
    chatbot.style.display = 'none';
    chatToggle.style.display = 'block';
});

// Send message
sendBtn.addEventListener('click', () => {
    const text = userInput.value.trim();
    if (text === '') return;

    // Show user message
    const userMsg = document.createElement('div');
    userMsg.textContent = "You: " + text;
    userMsg.style.marginBottom = "5px";
    userMsg.style.fontWeight = "bold";
    messages.appendChild(userMsg);

    userInput.value = '';

    // Show bot response (dummy PHP response)
    fetch('chatbot.php?message=' + encodeURIComponent(text))
        .then(res => res.text())
        .then(reply => {
            const botMsg = document.createElement('div');
            botMsg.textContent = "Bot: " + reply;
            botMsg.style.marginBottom = "5px";
            messages.appendChild(botMsg);
            messages.scrollTop = messages.scrollHeight;
        });
});
