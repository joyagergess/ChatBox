document.getElementById("newContactBtn").addEventListener("click", async () => {
    const popup = document.getElementById("popup_contact");
    popup.classList.remove("hidden");

    const userListDiv = document.getElementById("userList");
    userListDiv.innerHTML = "<p>Loading...</p>";

    const currentUserId = localStorage.getItem("userId");
    if (!currentUserId) {
        showContactMessage("You must be logged in!");
        return;
    }

    try {
        const users = await fetchUsers();
        const myContacts = await fetchUserContacts(currentUserId);
        renderUserList(users, myContacts, currentUserId, userListDiv);
    } catch (err) {
        userListDiv.innerHTML = "<p>Error loading users.</p>";
        console.error(err);
    }
});

async function fetchUsers() {
    const response = await axios.get(`${base_url}/users`);
    return response.data.data;
}

async function fetchUserContacts(userId) {
    const response = await axios.get(`${base_url}/contacts/byuser?user_id=${userId}`);
    return Array.isArray(response.data.data) ? response.data.data : [];
}

function renderUserList(users, contacts, currentUserId, container) {
    container.innerHTML = "";
    const existingContactIds = contacts.map(c => c.contact_id);

    users.forEach(user => {
        if (user.id == currentUserId) return;

        const row = document.createElement("div");
        row.classList.add("user-item");

        const label = document.createElement("span");
        label.textContent = `${user.name} (${user.email})`;

        const btns = document.createElement("div");
        btns.style.display = "flex";
        btns.style.gap = "10px";

        const addBtn = createAddButton(user.id, existingContactIds, currentUserId);
        const removeBtn = createRemoveButton(user.id, existingContactIds, currentUserId);

        btns.appendChild(addBtn);
        btns.appendChild(removeBtn);
        row.appendChild(label);
        row.appendChild(btns);
        container.appendChild(row);
    });
}

function createAddButton(userId, existingContactIds, currentUserId) {
    const btn = document.createElement("button");
    btn.textContent = "Add";
    btn.classList.add("add-btn");

    if (existingContactIds.includes(userId)) btn.style.display = "none";

    btn.addEventListener("click", async () => {
        try {
            const res = await axios.post(`${base_url}/contact/create`, {
                user_id: currentUserId,
                contact_id: userId
            });

            if (res.data.status === 200) {
                showContactMessage("Contact added");
                btn.style.display = "none";
                btn.nextSibling.style.display = "inline-block";
                existingContactIds.push(userId);
            } else {
                showContactMessage(res.data.data);
            }

        } catch (err) {
            console.error(err);
            showContactMessage("Failed to add contact");
        }
    });

    return btn;
}
function createRemoveButton(userId, existingContactIds, currentUserId) {
    const btn = document.createElement("button");
    btn.textContent = "Remove";
    btn.classList.add("remove-btn");

    if (!existingContactIds.includes(userId)) btn.style.display = "none";

    btn.addEventListener("click", async () => {
        try {
            const res = await axios.delete(`${base_url}/contact/delete`, {
                data: { user_id: currentUserId, contact_id: userId }
            });

            if (res.data.status === 200) {
                showContactMessage(res.data.data); 
                btn.style.display = "none";
                btn.previousSibling.style.display = "inline-block";

                const index = existingContactIds.indexOf(userId);
                if (index > -1) existingContactIds.splice(index, 1);

            } else {
                showContactMessage(res.data.data || "Failed to remove contact");
            }

        } catch (err) {
            console.error(err);
            showContactMessage("Failed to remove contact");
        }
    });

    return btn;
}

document.getElementById("cancelContactBtn").addEventListener("click", () => {
    const popup = document.getElementById("popup_contact");
    popup.classList.add("hidden");
});


function showContactMessage(text) {
    const msg = document.getElementById("contactMessage");
    msg.textContent = text;
    msg.style.display = "block";
     msg.style.color = "green";

    setTimeout(() => {
        msg.style.display = "none";

    }, 2000);
}
