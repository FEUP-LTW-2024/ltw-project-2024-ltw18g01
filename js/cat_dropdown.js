document.addEventListener("DOMContentLoaded", function() {
    var categoryDropdown = document.getElementById('categoryDropdown');
    var subcategoryDropdown = document.getElementById('subcategoryDropdown');
    
    categoryDropdown.addEventListener('change', function() {
        var categoryId = this.value;
        if (categoryId) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../utils/get_subcategories_ajax.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    subcategoryDropdown.innerHTML = xhr.responseText;
                }
            };
            xhr.send('categoryId=' + categoryId);
        } else {
            subcategoryDropdown.innerHTML = '<option value="">Select a subcategory</option>';
        }
    });
});
