document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("send-message-form");
    const messagesContainer = document.getElementById("messages");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("../actions/sendmessage_action.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                addMessage(data.message);
                form.reset();
                updateConversationsList();
            } else {
                alert("Failed to send message.");
            }
        })
        .catch(error => console.error("Error:", error));
    });

    function addMessage(message) {
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("message", message.isUserSender ? "sent" : "received");
        messageDiv.innerHTML = `
            <p><strong>${message.isUserSender ? "You" : "User " + message.senderId}:</strong> ${message.message}</p>
            <p><em>${message.sentAt}</em></p>
        `;
        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function updateConversationsList() {
        fetch("../actions/getmessages_action.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const sidebar = document.querySelector(".sidebar");
                sidebar.innerHTML = "";
                data.conversations.forEach(conversation => {
                    const convDiv = document.createElement("div");
                    convDiv.classList.add("conversation");
                    convDiv.innerHTML = `
                        <img src="${conversation.image_url}" alt="${conversation.title}" class="item-image">
                        <h3>${conversation.title}</h3>
                        <p>${conversation.otherUsername}: ${conversation.message}</p>
                        <small>Sent at: ${conversation.sentAt}</small>
                        <a href="chat.php?receiverId=${conversation.otherUserId}&itemId=${conversation.itemId}">Chat</a>
                    `;
                    sidebar.appendChild(convDiv);
                });
            } else {
                alert("Failed to update conversations list.");
            }
        })
        .catch(error => console.error("Error:", error));
    }
});
