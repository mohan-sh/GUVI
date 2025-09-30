$(document).ready(function() {
    $('#signupForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '../../backend/api/signup.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response.message);
                if (response.status === 'success') {
                    window.location.href = 'login.html';
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred during registration.');
            }
        });
    });
});
