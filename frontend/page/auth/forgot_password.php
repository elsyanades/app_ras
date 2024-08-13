<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="/app/frontend/assets/css/styles.min.css" />
</head>

<body>
  <div class="container">
    <h2>Forgot Password</h2>
    <form id="forgotPasswordForm">
      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="email" required>
      </div>
      <button type="submit" class="btn btn-primary">Send Reset Link</button>
    </form>
    <div id="message"></div>
  </div>
  
  <script src="/app/frontend/assets/libs/jquery/dist/jquery.min.js"></script>
  <script>
    $('#forgotPasswordForm').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: 'http://localhost/app/auth_management/api/forgot_password.php', // Ensure this path is correct
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ email: $('#email').val() }),
            success: function (response) {
                // Try to parse JSON response
                try {
                    const result = JSON.parse(response);
                    if (result.success) {
                        $('#message').text(result.success);
                    } else {
                        $('#message').text(result.error || 'An error occurred');
                    }
                } catch (e) {
                    $('#message').text('Unexpected response format');
                    console.error('Error:', e);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                $('#message').text('An error occurred. Please try again.');
            }
        });
    });

  </script>
</body>

</html>
