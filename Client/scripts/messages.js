(async function () {
    const chatMessages = document.getElementById("chatMessages");
    const sendBtn = document.getElementById("sendBtn");
    const msgInput = document.getElementById("messageInput");
    const currentUserId = parseInt(localStorage.getItem("userId"));

    async function loadMessages() {
        const chatId = localStorage.getItem("currentChatId");
        if (!chatId) { chatMessages.innerHTML = "<p>Select a conversation to see messages.</p>"; return; }

        await markChatDelivered(chatId);

        const res = await axios.get(`${base_url}/messages/by-chat?chats_id=${chatId}`);
        chatMessages.innerHTML = "";
        if (res.data.status === 200 && Array.isArray(res.data.data)) {
            res.data.data.forEach(renderMessage);
            await markChatRead(chatId);
        } else {
            chatMessages.innerHTML = "<p>No messages in this chat yet.</p>";
        }
    }

    function renderMessage(message) {
        const div = document.createElement("div");
        div.classList.add("message", message.sender_id === currentUserId ? "sent" : "received");

        const contentDiv = document.createElement("span");
        contentDiv.classList.add("message-content");
        contentDiv.textContent = message.content;
        div.appendChild(contentDiv);

        const timeDiv = document.createElement("span");
        timeDiv.classList.add("message-time");
        timeDiv.textContent = new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        div.appendChild(timeDiv);

        if (message.sender_id === currentUserId) {
            const ticksDiv = document.createElement("span");
            ticksDiv.classList.add("message-tick");

            if (message.read_at) {
                ticksDiv.innerHTML = "✔✔";
                ticksDiv.style.color = "blue";
                ticksDiv.title = `Read at ${new Date(message.read_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
            } else if (message.delivered_at) {
                ticksDiv.innerHTML = "✔✔";
                ticksDiv.style.color = "grey";
                ticksDiv.title = `Delivered at ${new Date(message.delivered_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
            } else {
                ticksDiv.innerHTML = "✔";
                ticksDiv.style.color = "grey";
                ticksDiv.title = "Sent";
            }

            div.appendChild(ticksDiv);
        }

        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    sendBtn.addEventListener("click", async () => {
        const chatId = localStorage.getItem("currentChatId");
        const content = msgInput.value.trim();
        if (!chatId || !content) return;

        const body = { chats_id: parseInt(chatId), sender_id: currentUserId, content };
        const res = await axios.post(`${base_url}/message/create`, body);
        if (res.data.status === 200) {
            renderMessage({ ...body, created_at: new Date().toISOString(), delivered_at: null, read_at: null });
            msgInput.value = "";
        }
    });

    async function markChatDelivered(chatId) { 
        await axios.post(`${base_url}/messages/mark-delivered`, 
            { chats_id: parseInt(chatId), user_id: currentUserId

             });
     }

     
    async function markChatRead(chatId) { 
        await axios.post(`${base_url}/messages/mark-read`,
             { chats_id: parseInt(chatId), user_id: currentUserId 

             }); }

    window.loadChatMessages = loadMessages;
    chatMessages.innerHTML = "<p>Select a conversation to see messages.</p>";
})();


