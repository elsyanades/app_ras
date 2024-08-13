// refresh.js

function refreshToken() {
    // Ambil token dari localStorage
    const token = localStorage.getItem('token');
    
    if (token) {
        $.ajax({
            url: 'http://localhost/app/?module=auth_management&endpoint=refresh',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ token: token }),
            success: function(response) {
                if (response.token) {
                    // Simpan token baru di localStorage
                    localStorage.setItem('token', response.token);

                    // Tampilkan token baru di console log
                    console.log('New Token:', response.token);

                    Swal.fire({
                        icon: 'success',
                        title: 'Token Refreshed',
                        text: 'Your session token has been refreshed successfully.'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Refresh Failed',
                        text: response.error || 'Unable to refresh token at the moment.'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'An error occurred',
                    text: 'Unable to refresh the token at the moment.'
                });
            }
        });
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'No Token Found',
            text: 'No token found in localStorage to refresh.'
        });
    }
}

// Refresh token every 1 hour (3600000 milliseconds)
setInterval(refreshToken, 3600000);
