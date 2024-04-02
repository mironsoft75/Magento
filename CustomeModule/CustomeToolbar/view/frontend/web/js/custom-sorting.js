// app/code/CustomeModule/CustomeToolbar/view/frontend/web/js/custom_sort.js

require(['jquery'], function ($) {
    $(document).ready(function () {
        $('.sort-option').on('click', function () {
            var sortType = $(this).data('sort');
            updateProductList(sortType);
        });
    });

    function updateProductList(sortBy) {
        $.ajax({
            url: '/CustomeToolbar/index/index', // Replace with your AJAX endpoint URL
            data: { sort: sortBy },
            type: 'GET',
            dataType: 'html',
            success: function (response) {
                $('.product-items').html(response);
            },
            error: function () {
                alert('Error loading products.');
            }
        });
    }
});
