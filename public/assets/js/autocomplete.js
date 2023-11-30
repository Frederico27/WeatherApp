$(document).ready(function(){
    $('#search').keyup(function(){
        var Search = $('#search').val();
        
        if(Search != ""){
            $.ajax({
                url: '/dadus_klima',
                method: 'POST',
                data: {search: Search},
                success: function(data){
                    $('#content').html(data);
                }
            });
        } else {
            $('#content').html('');
        }
    });

    $(document).on('click', '#d', function(){
        $('#search').val($(this).text());
        $('#content').html('');
        
        // Trigger a click on the "btn_search" button
        $('#btn_search').click();
    });
});


$(document).ready(function () {
    // Add an event listener to the button
    $('#btn_search').on('submit', function () {

        $.ajax({
            url: '/dadus_klima/buka', // Your backend endpoint
            method: 'GET',
            data: $('#weatherForm').serialize(), // Serialize the form data
            success: function (data) {
                // Assuming your backend returns HTML
                $('#content-prinsipal').html(data);
                  // Hide the footer
                $('#footer').hide();
            },
            error: function (error) {
                console.error('AJAX request failed:', error);
            }
        });
    });
    
});