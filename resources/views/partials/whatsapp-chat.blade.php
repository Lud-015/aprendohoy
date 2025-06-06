<!-- Chat Personalizado -->
<div class="chat-container" id="chatContainer">
    <div class="chat-header">
        <div class="chat-header-info">
            <img src="https://cdn-icons-png.flaticon.com/512/4712/4712107.png" alt="Bot Avatar" class="bot-avatar">
            <div class="bot-info">
                <h3>Asistente Virtual</h3>
                <span class="status">En línea</span>
            </div>
        </div>
        <button class="minimize-btn" id="minimizeBtn">−</button>
    </div>

    <div class="chat-messages" id="chatMessages">
        <div class="message bot-message">
            <div class="message-content">
                ¡Hola! Soy tu asistente virtual. ¿En qué puedo ayudarte hoy?
            </div>
        </div>
    </div>

    <div class="chat-input">
        <input type="text" id="messageInput" placeholder="Escribe tu mensaje...">
        <button id="sendButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
            </svg>
        </button>
    </div>
</div>

<button class="chat-toggle" id="chatToggle">
    <img src="https://cdn-icons-png.flaticon.com/512/4712/4712107.png" alt="Chat">
</button>

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
.chat-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
    z-index: 1000;
    transition: all 0.3s ease;
}

.chat-container.minimized {
    height: 60px;
}

.chat-header {
    padding: 15px;
    background: #007bff;
    color: white;
    border-radius: 10px 10px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-header-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.bot-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
}

.bot-info h3 {
    margin: 0;
    font-size: 16px;
}

.status {
    font-size: 12px;
    opacity: 0.8;
}

.minimize-btn {
    background: none;
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
    padding: 0 5px;
}

.chat-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.message {
    max-width: 80%;
    padding: 10px 15px;
    border-radius: 15px;
    margin: 5px 0;
}

.bot-message {
    align-self: flex-start;
    background: #f0f2f5;
}

.user-message {
    align-self: flex-end;
    background: #007bff;
    color: white;
}

.message-content {
    word-wrap: break-word;
}

.chat-input {
    padding: 15px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 10px;
}

.chat-input input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 20px;
    outline: none;
}

.chat-input button {
    background: #007bff;
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s ease;
}

.chat-input button:hover {
    background: #0056b3;
}

.chat-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #007bff;
    border: none;
    cursor: pointer;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    z-index: 999;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}

.chat-toggle img {
    width: 35px;
    height: 35px;
}

.chat-toggle:hover {
    transform: scale(1.1);
}

.buttons-container {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin-top: 10px;
}

.chat-button {
    background: #007bff;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 15px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s ease;
}

.chat-button:hover {
    background: #0056b3;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatContainer = document.getElementById('chatContainer');
    const chatToggle = document.getElementById('chatToggle');
    const minimizeBtn = document.getElementById('minimizeBtn');
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    const chatMessages = document.getElementById('chatMessages');

    // Inicialmente ocultar el chat
    chatContainer.style.display = 'none';

    // Función para mostrar/ocultar el chat
    chatToggle.addEventListener('click', () => {
        chatContainer.style.display = chatContainer.style.display === 'none' ? 'flex' : 'none';
        chatToggle.style.display = chatContainer.style.display === 'none' ? 'flex' : 'none';
    });

    // Función para minimizar/maximizar el chat
    minimizeBtn.addEventListener('click', () => {
        chatContainer.classList.toggle('minimized');
        minimizeBtn.textContent = chatContainer.classList.contains('minimized') ? '+' : '−';
    });

    // Función para enviar mensaje
    async function sendMessage() {
        const message = messageInput.value.trim();
        if (message) {
            try {
                // Agregar mensaje del usuario
                addMessage(message, 'user');
                messageInput.value = '';

                // Obtener el token CSRF
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Enviar mensaje al servidor
                const response = await fetch('/botman', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: message })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.status === 'success' && Array.isArray(data.messages)) {
                    data.messages.forEach(msg => {
                        if (msg.type === 'text') {
                            addMessage(msg.text, 'bot');
                        } else if (msg.type === 'buttons' && Array.isArray(msg.buttons)) {
                            addButtons(msg.buttons);
                        }
                    });
                } else {
                    throw new Error('Formato de respuesta inválido');
                }
            } catch (error) {
                console.error('Error:', error);
                addMessage('Lo siento, ha ocurrido un error. Por favor, intenta de nuevo.', 'bot');
            }
        }
    }

    // Función para agregar mensaje al chat
    function addMessage(text, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}-message`;
        messageDiv.innerHTML = `<div class="message-content">${text}</div>`;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Función para agregar botones
    function addButtons(buttons) {
        const buttonsContainer = document.createElement('div');
        buttonsContainer.className = 'buttons-container';

        buttons.forEach(button => {
            const buttonElement = document.createElement('button');
            buttonElement.className = 'chat-button';
            buttonElement.textContent = button.text;
            buttonElement.onclick = () => {
                addMessage(button.text, 'user');
                // Enviar el valor del botón como mensaje
                messageInput.value = button.value;
                sendMessage();
            };
            buttonsContainer.appendChild(buttonElement);
        });

        const messageDiv = document.createElement('div');
        messageDiv.className = 'message bot-message';
        messageDiv.appendChild(buttonsContainer);
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Eventos para enviar mensaje
    sendButton.addEventListener('click', sendMessage);
    messageInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
});

</script>
