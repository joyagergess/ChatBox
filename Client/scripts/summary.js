
const chatSummaryDiv = document.getElementById("summaryContent");

(async () => {
  try {
    const userId = parseInt(localStorage.getItem("userId"));
    const chatId = parseInt(localStorage.getItem("currentChatId"));

    if (!userId || !chatId) {
      console.warn("User ID or Chat ID missing in localStorage");
      return;
    }

    const res = await axios.post(`${base_url}/Summary`, {
      chats_id: chatId,
      user_id: userId
    });

    console.log(res.data.data.ai_summary);
    chatSummaryDiv.innerText = res.data.data.ai_summary;

  } catch (error) {
    console.error("Error fetching AI summary:", error);
  }
})();