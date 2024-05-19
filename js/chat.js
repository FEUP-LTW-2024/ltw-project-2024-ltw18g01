document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("send-message-form");
    const messagesContainer = document.getElementById("messages");
    const sidebar = document.querySelector(".sidebar");

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
                if (data.conversations) {
                    updateConversations(data.conversations);
                }
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
            <p class="sender-name"><strong>${message.isUserSender ? "You" : `User ${message.senderId}`}</strong></p>
            <p>${message.message}</p>
            <p class="message-time"><em>${message.sentAt}</em></p>
        `;
        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function updateConversations(conversations) {
        const existingConversations = {};

        sidebar.querySelectorAll('.conversation').forEach(conv => {
            const itemId = conv.getAttribute('data-item-id');
            const otherUserId = conv.getAttribute('data-other-user-id');
            existingConversations[`${itemId}-${otherUserId}`] = conv;
        });

        conversations.forEach(conversation => {
            const key = `${conversation.itemId}-${conversation.otherUserId}`;
            const existingConv = existingConversations[key];

            let message = conversation.message;
            if (message.length > 50) {
                message = message.substring(0, 50) + '...';
            }

            if (existingConv) {
                existingConv.querySelector('p').innerText = message;
                existingConv.querySelector('small').innerText = `Sent at: ${conversation.sentAt}`;
            } else {
                const convDiv = document.createElement("div");
                convDiv.classList.add("conversation");
                convDiv.setAttribute('data-item-id', conversation.itemId);
                convDiv.setAttribute('data-other-user-id', conversation.otherUserId);
                convDiv.innerHTML = `
                    <img src="${conversation.otherUserImage}" alt="${conversation.otherUsername}">
                    <h3>${conversation.otherUsername}</h3>
                    <p>${message}</p>
                    <small>Sent at: ${conversation.sentAt}</small>
                    <a href="chat.php?receiverId=${conversation.otherUserId}&itemId=${conversation.itemId}">Chat</a>
                `;
                sidebar.appendChild(convDiv);
            }
        });
    }
});

