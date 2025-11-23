document.getElementById("logoutBtn").addEventListener("click", () => {
    localStorage.removeItem("userId");
    localStorage.removeItem("currentChatId");

    window.location.href = "login.html";
});

if (!localStorage.getItem("userId")) {
    window.location.href = "login.html";
}