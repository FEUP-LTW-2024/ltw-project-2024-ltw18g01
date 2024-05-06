$(document).ready(function(){
    $('#categoryDropdown').change(function(){
        var categoryId = $(this).val();
        if(categoryId){
            $.ajax({
                type:'POST',
                url:'../utils/get_subcategories_ajax.php',
                data:'categoryId='+categoryId,
                success:function(html){
                    $('#subcategoryDropdown').html(html);
                }
            });
        }else{
            $('#subcategoryDropdown').html('<option value="">Select a subcategory</option>');
        }
    });
});