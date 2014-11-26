jQuery(document).ready(function($){
    // Post function
    function checkTitle(title, id,post_type) {
        var data = {
            action: 'title_check',
            post_title: title,
            post_type: post_type,
            post_id: id
        };

        //var ajaxurl = 'wp-admin/admin-ajax.php';
        $.post(ajaxurl, data, function(response) {
            $('#message').remove();
            $('#poststuff').prepend('<div id=\"message\" class=\"updated fade\"><p>'+response+'</p></div>');
        }); 
    };

    // Add button to "Check Titles" below title field in post editor
    //$('#edit-slug-box').append('<span id="check-title-btn"><a class="button" href="#">Check Title</a></span>');

    // Click function to initiate post function
    $('#title').change(function() {
        var title = $('#title').val();
        var id = $('#post_ID').val();
        var post_type = $('#post_type').val();
        checkTitle(title, id,post_type);
    });

});
