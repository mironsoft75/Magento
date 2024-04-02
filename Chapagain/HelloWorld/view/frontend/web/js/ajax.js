require(['jquery'], function($) {
    $(document).ready(function() {
        $('#load-data-button').click(function() { // Add a button with id="load-data-button" in your HTML
            $.ajax({
                url: '/helloworld/index/ajaxload', // Replace with the correct URL for your Ajax controller
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Handle the data here, e.g., update the HTML
                    $('#product-list').html(data.html);
                },
                error: function() {
                    console.error('Error loading data.');
                }
            });
        });
    });
});
