<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize Free</title>
  <link rel="shortcut icon" type="image/png" href="/app/frontend/assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="/app/frontend/assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="/app/frontend/assets/images/logos/dark-logo.svg" width="180" alt="">
                </a>
                <p class="text-center">Your Social Campaigns</p>
                <form id="registerForm">
                  <div class="mb-3">
                    <label for="exampleInputtext1" class="form-label">Name</label>
                    <input type="text" class="form-control" id="exampleInputtext1" aria-describedby="textHelp" name="name">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputtext2" class="form-label">Username</label>
                    <input type="text" class="form-control" id="exampleInputtext2" aria-describedby="textHelp" name="username">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                  </div>
                  <div class="mb-3">
                    <label for="roleSelect" class="form-label">Role</label>
                    <select class="form-select" id="roleSelect" name="role" aria-describedby="roleHelp">
                      <option value="admin">Admin</option>
                      <option value="manager">Manager</option>
                      <option value="finance">Finance</option>
                      <option value="employee">Employee</option>
                      <!-- <option value="superuser">Superadmin</option> -->
                    </select>
                    <div id="roleHelp" class="form-text">Select the role for the user.</div>
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign Up</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                    <a class="text-primary fw-bold ms-2" href="http://localhost/app/frontend/index.php?page=login">Sign In</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="/app/frontend/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="/app/frontend/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function () {
      $('#registerForm').on('submit', function (event) {
        event.preventDefault();

        // Ambil data dari form
        var formData = {
          name: $('#exampleInputtext1').val(),
          username: $('#exampleInputtext2').val(),
          email: $('#exampleInputEmail1').val(),
          role: $('#roleSelect').val(),
          password: $('#exampleInputPassword1').val()
        };

        $.ajax({
          url: 'http://localhost/app/?module=auth_management&endpoint=register', // Pastikan path ini benar
          type: 'POST',
          contentType: 'application/json',
          data: JSON.stringify(formData),
          success: function (response) {
            if (response.success) {
              Swal.fire({
                icon: 'success',
                title: 'Registration successful!',
                showConfirmButton: false,
                timer: 1500
              }).then(() => {
                window.location.href = 'http://localhost/app/frontend/index.php?page=login';
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Registration failed',
                text: response.error || 'An error occurred during registration.'
              });
            }
          },
          error: function (xhr, status, error) {
            console.error('Error:', error);
            Swal.fire({
              icon: 'error',
              title: 'An error occurred',
              text: 'Unable to process the request at the moment.'
            });
          }
        });
      });
    });
</script>

</body>

</html>
