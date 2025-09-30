$(document).ready(function() {
    const sessionToken = localStorage.getItem('session_token');
    const userEmail = localStorage.getItem('user_email');

    if (!sessionToken || !userEmail) {
        window.location.href = 'login.html';
        return;
    }

    // Fetch profile data
    $.ajax({
        url: '../../backend/api/profile.php',
        type: 'GET',
        data: { email: userEmail, session_token: sessionToken },
        success: function(response) {
            if (response.status === 'success') {
                $('#profileName').val(response.data.name);
                $('#profileEmail').val(response.data.email);
                $('#age').val(response.data.age);
                $('#dob').val(response.data.dob);
                $('#contact').val(response.data.contact);
            } else {
                alert(response.message);
                window.location.href = 'login.html';
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('An error occurred while fetching profile data.');
            window.location.href = 'login.html';
        }
    });

    // Update profile data
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();

        const formData = $(this).serializeArray();
        formData.push({ name: "email", value: userEmail });
        formData.push({ name: "session_token", value: sessionToken });

        $.ajax({
            url: '../../backend/api/profile.php',
            type: 'POST',
            data: $.param(formData),
            success: function(response) {
                alert(response.message);
                if (response.status !== 'success') {
                    window.location.href = 'login.html';
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred during profile update.');
            }
        });
    });

    // Logout functionality
    $('#logoutButton').on('click', function() {
        localStorage.removeItem('session_token');
        localStorage.removeItem('user_email');
        alert('Logged out successfully.');
        window.location.href = 'login.html';
    });
});
