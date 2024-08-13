<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password</title>
  <link rel="stylesheet" href="/app/frontend/assets/css/styles.min.css" />
</head>

<body>
  <div class="container">
    <h2>Reset Password</h2>
    <form id="resetPasswordForm">
      <input type="hidden" id="token" value="<?php echo $_GET['token'] ?? ''; ?>">
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">New Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" required>
      </div>
      <button type="submit" class="btn btn-primary">Reset Password</button>
      <div id="message" class="mt-3"></div>
    </form>
  </div>
  
  <script src="/app/frontend/assets/libs/jquery/dist/jquery.min.js"></script>
  <script>
    $('#resetPasswordForm').on('submit', function (event) {
      event.preventDefault();
      $.ajax({
        url: 'http://localhost/app/auth_management/api/reset_password.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
          token: $('#token').val(),
          password: $('#exampleInputPassword1').val()
        }),
        success: function (response) {
          $('#message').text(response.success || response.error);
        },
        error: function (xhr, status, error) {
          $('#message').text('An error occurred: ' + error);
        }
      });
    });
  </script>
</body>

</html>
