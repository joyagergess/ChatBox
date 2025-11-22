document.getElementById("signupBtn").addEventListener("click", async () => {
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const message = document.getElementById("message");

    if (!name || !email || !password) {
        message.style.color = "red";
        message.textContent = "Enter your name, email, and password";
        return;
    }

    try {
        const response = await axios.post(`${base_url}/auth/signup`, { name, email, password });

        if (response.data.status === 201) {
            message.style.color = "green";
            message.textContent = "Signup successful! You can now log in.";

            window.location.href = "login.html";

        } else {
            message.style.color = "red";
            message.textContent = response.data.data || "Signup failed";
        }
    } catch (error) {
        message.style.color = "red";
        message.textContent = "An error occurred. Please try again.";
        console.error(error);
    }
});
