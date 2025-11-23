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

    const aiSummary = res.data.data.ai_summary;
    const unreadCount = res.data.data.unread_count;
    chatSummaryDiv.innerText = aiSummary && aiSummary.trim() !== ""
      ? aiSummary
      : `You have ${unreadCount} unread message(s).`;

    console.log(chatSummaryDiv.innerText);

  } catch (error) {
    console.error("Error fetching AI summary:", error);
  }
})();
