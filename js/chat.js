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
                loadMessages(formData.get("receiverId"));
                form.reset();
            } else {
                alert("Failed to send message.");
            }
        })
        .catch(error => console.error("Error:", error));
    });

    function loadMessages(receiverId) {
        fetch(`../actions/getmessages.php?receiverId=${receiverId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayMessages(data.messages);
            } else {
                alert("Failed to load messages.");
            }
        })
        .catch(error => console.error("Error:", error));
    }

    function displayMessages(messages) {
        messagesContainer.innerHTML = "";
        messages.forEach(message => {
            const messageDiv = document.createElement("div");
            messageDiv.classList.add("message", message.isUserSender ? "sent" : "received");
            messageDiv.innerHTML = `
                <p><strong>${message.isUserSender ? "You" : "User " + message.senderId}:</strong> ${message.message}</p>
                <p><em>${message.sentAt}</em></p>
            `;
            messagesContainer.appendChild(messageDiv);
        });
    }
});
