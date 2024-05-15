// ajax ver. of like-action
/*

document.addEventListener("DOMContentLoaded", function() {
        var buttons = document.querySelectorAll(".like-button");

        buttons.forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();

                var itemId = button.getAttribute("data-item");
                var userId = button.getAttribute("data-user");

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "/../actions/like_action.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Request was successful, do something if needed
                        } else {
                            // Request failed, handle error if needed
                        }
                    }
                };
                xhr.send("itemId=" + encodeURIComponent(itemId) + "&userId=" + encodeURIComponent(userId));
            });
        });
    });

    */