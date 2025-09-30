$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '../../backend/api/login.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    localStorage.setItem('session_token', response.session_token);
                    localStorage.setItem('user_email', response.user_email);
                    alert(response.message);
                    window.location.href = 'profile.html';
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred during login.');
            }
        });
    });
});
