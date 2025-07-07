@extends('user.layout')
@section('title', 'AI tư vấn ngành học')
@section('content')

<div class="chat-wrapper">
    <div class="chat-container">
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="header-content">
                <div class="ai-avatar">
                    <div class="avatar-circle">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="status-indicator"></div>
                </div>
                <div class="header-text">
                    <h1>AI Tư Vấn Ngành Học</h1>
                    <p>Trợ lý thông minh của Đại học Trà Vinh</p>
                </div>
            </div>
        </div>
        
        <!-- Chat Messages Area -->
        <div class="chat-messages" id="chat-messages">
            <!-- Messages will appear here -->
        </div>
        
        <!-- Typing Indicator -->
        <div class="typing-indicator" id="typing-indicator">
            <div class="typing-bubble">
                <div class="typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        
        <!-- Chat Input -->
        <div class="chat-input-area">
            <div class="input-wrapper">
                <div class="input-container">
                    <input type="text" id="user-input" placeholder="Hỏi tôi về ngành học bạn quan tâm..." maxlength="500">
                    <button id="send-btn" onclick="sendMessage()">
                        <svg viewBox="0 0 24 24" width="20" height="20">
                            <path fill="currentColor" d="M2,21L23,12L2,3V10L17,12L2,14V21Z"/>
                        </svg>
                    </button>
                </div>
                <div class="char-counter">
                    <span id="char-count">0/500</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Chat Interface Styles */
* {
    box-sizing: border-box;
}

.chat-wrapper {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.chat-container {
    width: 100%;
    max-width: 1100px;
    height: 90vh;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    border: 1px solid rgba(226, 232, 240, 0.3);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* Header Styles */
.chat-header {
    background: linear-gradient(135deg, #64748b, #475569);
    padding: 24px 32px;
    border-bottom: 1px solid rgba(148, 163, 184, 0.2);
}

.header-content {
    display: flex;
    align-items: center;
    gap: 16px;
}

.ai-avatar {
    position: relative;
}

.avatar-circle {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #a5b4fc, #c7d2fe);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4338ca;
    font-size: 24px;
    box-shadow: 0 4px 12px rgba(165, 180, 252, 0.2);
}

.status-indicator {
    position: absolute;
    bottom: 4px;
    right: 4px;
    width: 14px;
    height: 14px;
    background: #10b981;
    border-radius: 50%;
    border: 3px solid white;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.header-text h1 {
    color: white;
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 4px 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.header-text p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 14px;
    margin: 0;
}

/* Messages Area */
.chat-messages {
    flex: 1;
    padding: 24px 32px;
    overflow-y: auto;
    scroll-behavior: smooth;
    background: #fafbfc;
}

.chat-messages::-webkit-scrollbar {
    width: 6px;
}

.chat-messages::-webkit-scrollbar-track {
    background: transparent;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: rgba(148, 163, 184, 0.3);
    border-radius: 10px;
}

.chat-messages::-webkit-scrollbar-thumb:hover {
    background: rgba(148, 163, 184, 0.5);
}

/* Message Styles */
.message {
    display: flex;
    margin-bottom: 24px;
    animation: slideUp 0.4s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.message.user {
    justify-content: flex-end;
}

.message-bubble {
    max-width: 70%;
    padding: 16px 20px;
    border-radius: 20px;
    position: relative;
    word-wrap: break-word;
    line-height: 1.5;
}

.message.user .message-bubble {
    background: linear-gradient(135deg, #a5b4fc, #c7d2fe);
    color: #4338ca;
    border-bottom-right-radius: 8px;
    box-shadow: 0 2px 8px rgba(165, 180, 252, 0.15);
}

.message.ai .message-bubble {
    background: white;
    color: #374151;
    border-bottom-left-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(226, 232, 240, 0.5);
}

/* AI Message Content Styling */
.message.ai .message-bubble h1,
.message.ai .message-bubble h2,
.message.ai .message-bubble h3 {
    color: #6366f1;
    margin-top: 0;
    margin-bottom: 12px;
}

.message.ai .message-bubble ul,
.message.ai .message-bubble ol {
    margin: 8px 0;
    padding-left: 20px;
}

.message.ai .message-bubble li {
    margin-bottom: 4px;
}

.message.ai .message-bubble code {
    background: #f1f5f9;
    padding: 2px 6px;
    border-radius: 4px;
    font-family: 'SF Mono', Consolas, monospace;
    font-size: 0.9em;
    color: #dc2626;
}

.message.ai .message-bubble pre {
    background: #f1f5f9;
    padding: 12px;
    border-radius: 8px;
    overflow-x: auto;
    margin: 12px 0;
}

/* Typing Indicator */
.typing-indicator {
    padding: 0 32px 16px;
    display: none;
}

.typing-bubble {
    background: white;
    padding: 16px 20px;
    border-radius: 20px 20px 20px 8px;
    display: inline-block;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(226, 232, 240, 0.5);
}

.typing-dots {
    display: flex;
    gap: 4px;
    align-items: center;
}

.typing-dots span {
    width: 8px;
    height: 8px;
    background: #a5b4fc;
    border-radius: 50%;
    animation: typingAnimation 1.4s infinite ease-in-out;
}

.typing-dots span:nth-child(1) { animation-delay: 0s; }
.typing-dots span:nth-child(2) { animation-delay: 0.2s; }
.typing-dots span:nth-child(3) { animation-delay: 0.4s; }

@keyframes typingAnimation {
    0%, 60%, 100% {
        transform: translateY(0);
        opacity: 0.5;
    }
    30% {
        transform: translateY(-10px);
        opacity: 1;
    }
}

/* Input Area */
.chat-input-area {
    padding: 24px 32px;
    background: rgba(248, 250, 252, 0.8);
    border-top: 1px solid rgba(226, 232, 240, 0.3);
}

.input-wrapper {
    max-width: 100%;
}

.input-container {
    display: flex;
    align-items: center;
    background: white;
    border-radius: 24px;
    padding: 4px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(226, 232, 240, 0.5);
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

.input-container:focus-within {
    border-color: #a5b4fc;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(165, 180, 252, 0.15);
}

#user-input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 16px 20px;
    font-size: 16px;
    color: #374151;
    outline: none;
    font-family: inherit;
}

#user-input::placeholder {
    color: #9ca3af;
}

#send-btn {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    border: none;
    background: linear-gradient(135deg, #a5b4fc, #c7d2fe);
    color: #4338ca;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(165, 180, 252, 0.2);
}

#send-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(165, 180, 252, 0.3);
}

#send-btn:active {
    transform: scale(0.95);
}

#send-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.char-counter {
    text-align: center;
    margin-top: 8px;
}

#char-count {
    font-size: 12px;
    color: #9ca3af;
    transition: color 0.3s ease;
}

/* Responsive Design */
@media (max-width: 768px) {
    .chat-wrapper {
        padding: 10px;
    }
    
    .chat-container {
        height: 95vh;
        border-radius: 16px;
    }
    
    .chat-header {
        padding: 16px 20px;
    }
    
    .header-content {
        gap: 12px;
    }
    
    .avatar-circle {
        width: 44px;
        height: 44px;
        font-size: 20px;
    }
    
    .header-text h1 {
        font-size: 20px;
    }
    
    .chat-messages {
        padding: 16px 20px;
    }
    
    .message-bubble {
        max-width: 90%;
        padding: 12px 16px;
    }
    
    .chat-input-area {
        padding: 16px 20px;
    }
    
    #user-input {
        padding: 12px 16px;
        font-size: 16px;
    }
    
    #send-btn {
        width: 40px;
        height: 40px;
    }
}

@media (max-width: 480px) {
    .header-text h1 {
        font-size: 18px;
    }
    
    .header-text p {
        font-size: 13px;
    }
    
    .message-bubble {
        max-width: 95%;
        padding: 10px 14px;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    let chatMessages = document.getElementById('chat-messages');
    let userInput = document.getElementById('user-input');
    let sendBtn = document.getElementById('send-btn');
    let typingIndicator = document.getElementById('typing-indicator');

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function showTypingIndicator() {
        typingIndicator.style.display = 'block';
        scrollToBottom();
    }

    function hideTypingIndicator() {
        typingIndicator.style.display = 'none';
    }

    function addMessage(content, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isUser ? 'user' : 'ai'}`;
        
        const messageBubble = document.createElement('div');
        messageBubble.className = 'message-bubble';
        
        if (isUser) {
            messageBubble.textContent = content;
        } else {
            messageBubble.innerHTML = marked.parse(content);
        }
        
        messageDiv.appendChild(messageBubble);
        chatMessages.appendChild(messageDiv);
        
        // Smooth scroll with delay for animation
        setTimeout(() => {
            scrollToBottom();
        }, 100);
    }

    function loadMessage() {
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('/load-message', {  
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
        })
        .then(response => response.json())  
        .then(data => {
            if (data.dataMessage && data.dataMessage.length > 0) {
                data.dataMessage.forEach(element => {
                    addMessage(element.message_content, element.type_message == 0);
                });
            } else {
                // Welcome message
                addMessage(`Xin chào! 👋 Tôi là AI tư vấn ngành học của **Đại học Trà Vinh**. 

Tôi có thể giúp bạn:

🎓 **Tư vấn chọn ngành phù hợp** với năng lực và sở thích
📚 **Thông tin chi tiết** về chương trình đào tạo  
💼 **Cơ hội nghề nghiệp** và mức lương sau tốt nghiệp
📋 **Điều kiện tuyển sinh** và phương thức xét tuyển
🏫 **Môi trường học tập** và cơ sở vật chất

Hãy hỏi tôi bất cứ điều gì bạn muốn biết! 😊`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            addMessage('❌ **Xin lỗi!** Có lỗi xảy ra khi tải tin nhắn. Vui lòng thử lại sau.');
        });
    }

    function sendMessage() {
        const message = userInput.value.trim();
        if (!message) return;

        // Disable input
        userInput.disabled = true;
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M12,4V2A10,10 0 0,0 2,12H4A8,8 0 0,1 12,4Z"><animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="1s" repeatCount="indefinite"/></path></svg>';

        // Add user message
        addMessage(message, true);
        userInput.value = '';

        // Show typing indicator
        showTypingIndicator();

        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/chat', {  
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ content: message })
        })
        .then(response => response.json())  
        .then(data => {
            hideTypingIndicator();
            addMessage(data.message);
        })
        .catch(error => {
            console.error('Error:', error);
            hideTypingIndicator();
            addMessage('❌ **Xin lỗi!** Có lỗi xảy ra. Vui lòng thử lại sau.');
        })
        .finally(() => {
            // Re-enable input
            userInput.disabled = false;
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<svg viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M2,21L23,12L2,3V10L17,12L2,14V21Z"/></svg>';
            userInput.focus();
        });
    }

    // Enter key to send
    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    // Character count
    userInput.addEventListener('input', function() {
        const charCount = document.getElementById('char-count');
        const currentLength = this.value.length;
        charCount.textContent = `${currentLength}/500`;
        
        if (currentLength > 450) {
            charCount.style.color = '#f59e0b';
        } else if (currentLength > 400) {
            charCount.style.color = '#fbbf24';
        } else {
            charCount.style.color = '#9ca3af';
        }
    });

    // Load messages on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadMessage();
        userInput.focus();
    });
</script>

@endsection