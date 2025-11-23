document.getElementById("loginBtn").addEventListener("click", async () => {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const message = document.getElementById("message");

    if (!email || !password) {
        message.style.color = "red";
        message.textContent = "Enter your email and password";
        return;
    }

        const response = await axios.post(`${base_url}/auth/login`, { email, password });

        if (response.data.status === 200) {
            message.style.color = "green";
            message.textContent = "Login successful!";

            localStorage.setItem("userId", response.data.data.id);
            localStorage.setItem("userName", response.data.data.name);
            
            const chats = await axios.get(`${base_url}/chats/user?user_id=${response.data.data.id}`);
               if (chats.data.status === 200) {
               const chatList = chats.data.data;
 
             const chatIds = chatList.map(chat => chat.id);

             let firstChatId = chatIds.length > 0 ? chatIds[0] : null;
             
             localStorage.setItem("currentChatId", firstChatId);

            window.location.href = "index.html";
        } else {
            message.style.color = "red";
            message.textContent = response.data.data || "Login failed";
        }
    }
});
