let currentUserId = localStorage.getItem("userId");

if (!currentUserId) console.warn("No user logged in");

document.getElementById("newConversationBtn").addEventListener("click", async () => {
    if (!currentUserId) return alert("You must be logged in!");

    const popup = document.getElementById("popup_conversation");
    popup.classList.remove("hidden");

    const container = document.getElementById("conversationUserList");
    container.innerHTML = "<p>Loading...</p>";

    try {
        const contacts = await fetchUserContacts(currentUserId);

        const detailedContacts = await Promise.all(
            contacts.map(c => fetchContactInfo(currentUserId, c.contact_id))
        );

        renderConversationUserList(detailedContacts, container, popup);
    } catch (err) {
        container.innerHTML = "<p>Error loading contacts.</p>";
        console.error(err);
    }
});


async function fetchUserContacts(userId) {
    try {
        const res = await axios.get(`${base_url}/contacts/byuser?user_id=${userId}`);
        return Array.isArray(res.data.data) ? res.data.data : [];
    } catch (err) {
        console.error(err);
        return [];
    }
}


async function fetchContactInfo(userId, contactId) {
    try {
        const res = await axios.get(`${base_url}/contact/info?user_id=${userId}&contact_id=${contactId}`);
        if (res.data.status === 200) {
            return res.data.data;
        } else {
            return { contact_id: contactId, name: "Unknown", email: "No Email" };
        }
    } catch (err) {
        console.error(err);
        return { contact_id: contactId, name: "Unknown", email: "No Email" };
    }
}


function renderConversationUserList(contacts, container, popup) {
    container.innerHTML = "";
    if (!contacts.length) {
        container.innerHTML = "<p>No contacts available</p>";
        return;
    }

    contacts.forEach(contact => {
        const row = document.createElement("div");
        row.className = "user-item";

        const label = document.createElement("span");
        label.textContent = `${contact.name} (${contact.email})`;

        const startBtn = document.createElement("button");
        startBtn.textContent = "Start Chat";
        startBtn.className = "add-btn";

    startBtn.addEventListener("click", async () => {
    try {
        const existingRes = await axios.get(`${base_url}/chat/check?user1=${currentUserId}&user2=${contact.contact_id}`);
        if (existingRes.data.status === 200 && existingRes.data.data.chat_id) {
            showConversationMessage("A conversation already exists!");
            popup.classList.add("hidden");
            return; 
        }

        const res = await axios.post(`${base_url}/chat/create`, { chat_type: "single" });
        if (res.data.status !== 200) {
            showConversationMessage(res.data.data || "Failed to start conversation");
            return;
        }

        const chatId = res.data.data.chat_id; 

        await Promise.all([
            axios.post(`${base_url}/users_chat/create`, { chats_id: chatId, user_id: parseInt(currentUserId) }),
            axios.post(`${base_url}/users_chat/create`, { chats_id: chatId, user_id: parseInt(contact.contact_id) })
        ]);

        showConversationMessage("Conversation started!");
        popup.classList.add("hidden");

        await fetchUserConversations(); 

    } catch (err) {
        console.error(err);
        showConversationMessage("Failed to start conversation");
    }
});

        const btnContainer = document.createElement("div");
        btnContainer.style.display = "flex";
        btnContainer.style.gap = "8px";
        btnContainer.appendChild(startBtn);

        row.appendChild(label);
        row.appendChild(btnContainer);
        container.appendChild(row);
    });
}

document.getElementById("cancelConversationBtn").addEventListener("click", () => {
    document.getElementById("popup_conversation").classList.add("hidden");
});

function showConversationMessage(text) {
    const msg = document.getElementById("conversationMessage");
    msg.textContent = text;
    msg.classList.remove("hidden");

    setTimeout(() => {
        msg.classList.add("hidden");
    }, 2000); 
}
