const conversationsDiv = document.getElementById("conversations");
let userConversations = [];

async function fetchUserConversations() {
    const currentUserId = localStorage.getItem("userId");
    if (!currentUserId) return [];

    try {
        const res = await axios.get(`${base_url}/users_chats/byuser?user_id=${currentUserId}`);
        userConversations = Array.isArray(res.data.data) ? res.data.data : [];
        renderConversations(userConversations, currentUserId);
        return userConversations;
    } catch (err) {
        console.error("Failed to fetch conversations", err);
        conversationsDiv.innerHTML = "<p>Error loading conversations.</p>";
        return [];
    }
}

function renderConversations(conversations, currentUserId) {
    conversationsDiv.innerHTML = "";
    if (!conversations.length) {
        conversationsDiv.innerHTML = "<p>No conversations yet</p>";
        return;
    }

    conversations.forEach(chat => {
        const row = document.createElement("div");
        row.className = "conversation-item";
        row.dataset.chatId = chat.chats_id;

        const userNames = chat.user_names || "";
        const otherUsers = userNames
            .split(",")
            .map(n => n.trim())
            .filter(n => n !== localStorage.getItem("userName"));

        const displayName = otherUsers.join(", ") || "Unknown";

        const avatar = document.createElement("img");
        avatar.className = "conversation-avatar";
        avatar.src = "assets/Unknown_person.jpg"; 
        avatar.alt = displayName;

       
        const nameDiv = document.createElement("div");
        nameDiv.className = "conversation-name";
        nameDiv.textContent = displayName;

        row.appendChild(avatar);
        row.appendChild(nameDiv);

        row.addEventListener("click", () => openConversation(chat.chats_id, otherUsers));

        conversationsDiv.appendChild(row);
    });


}

function openConversation(chatId, users) {
    const chatName = document.getElementById("chatName");
    chatName.textContent = users.length > 0
        ? `Chat with: ${users.join(", ")}`
        : "Chat with: Unknown";

    const chatMessages = document.getElementById("chatMessages");
    chatMessages.innerHTML = `<p>Loading messages for chat ${chatId}...</p>`;

}


document.addEventListener("DOMContentLoaded", fetchUserConversations);
