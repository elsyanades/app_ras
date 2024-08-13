<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="shortcut icon" type="image/png" href="/app/frontend/assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="/app/frontend/assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <!-- Body Wrapper -->
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
                                <p class="text-center">Login to Your Account</p>
                                <form id="loginForm">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="username"
                                            aria-describedby="emailHelp" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                            name="password" required>
                                    </div>
                                    <!-- <div class="d-flex align-items-center justify-content-between mb-4">
                                        <a class="text-primary fw-bold" href="http://localhost/app/frontend/index.php?page=forgot">Forgot Password?</a>
                                    </div> -->
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign
                                        In</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a class="text-primary fw-bold ms-2"
                                            href="http://localhost/app/frontend/index.php?page=register">Create an account</a>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/app/frontend/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $('#loginForm').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                url: 'http://localhost/app/?module=auth_management&endpoint=login',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    username: $('#exampleInputEmail1').val(),
                    password: $('#exampleInputPassword1').val()
                }),
                success: function (response) {
                    if (response.token) {
                        localStorage.setItem('token', response.token);

                        // Validate the token before redirecting
                        $.ajax({
                            url: 'http://localhost/app/?module=auth_management&endpoint=validate',
                            type: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({
                                token: response.token
                            }),
                            success: function (validateResponse) {
                                if (validateResponse.success) {
                                    // Save the role and token in session
                                    $.ajax({
                                        url: 'http://localhost/app/?module=auth_management&endpoint=save_session',
                                        type: 'POST',
                                        contentType: 'application/json',
                                        data: JSON.stringify({
                                            token: response.token,
                                            role: response.role
                                        }),
                                        success: function () {
                                            // Determine the dashboard URL based on the role
                                            let dashboardUrl;
                                            switch (response.role) {
                                                case 'admin':
                                                    dashboardUrl = 'http://localhost/app/frontend/index.php?page=dashboard-admin';
                                                    break;
                                                case 'Superuser':
                                                    dashboardUrl = 'http://localhost/app/frontend/index.php?page=dashboard';
                                                    break;
                                                case 'manager':
                                                    dashboardUrl = 'http://localhost/app/frontend/index.php?page=dashboard-manager';
                                                    break;
                                                case 'finance':
                                                    dashboardUrl = 'http://localhost/app/frontend/index.php?page=dashboard-finance';
                                                    break;
                                                case 'employee':
                                                    dashboardUrl = 'http://localhost/app/frontend/index.php?page=dashboard-employee';
                                                    break;
                                                default:
                                                    dashboardUrl = 'http://localhost/app/frontend/index.php?page=dashboard'; // fallback if role is not recognized
                                            }

                                            // Redirect after showing the alert
                                            Swal.fire({
                                                icon: 'success',
                                                title: `Welcome ${response.username}!`,
                                                text: `Role: ${response.role}`,
                                                showConfirmButton: false,
                                                timer: 1500
                                            }).then(() => {
                                                window.location.href = dashboardUrl;
                                            });
                                        },
                                        error: function (xhr, status, error) {
                                            console.error('Error:', error);
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'An error occurred',
                                                text: 'Unable to save session token and role.'
                                            });
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Token Validation Failed',
                                        text: 'Your session token is invalid. Please login again.'
                                    });
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'An error occurred',
                                    text: 'Unable to validate the token at the moment.'
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: response.error || 'Incorrect username or password. Please try again.'
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


        function refreshToken() {
            const refreshToken = localStorage.getItem('refresh_token');
            if (refreshToken) {
                $.ajax({
                    url: 'http://localhost/app/?module=auth_management&endpoint=refresh',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ refresh_token: refreshToken }),
                    success: function (response) {
                        if (response.token) {
                            localStorage.setItem('token', response.token);
                        } else {
                            console.error('Error refreshing token:', response.error);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }

        function validateToken() {
            const token = localStorage.getItem('token');
            if (token) {
                $.ajax({
                    url: 'http://localhost/app/?module=auth_management&endpoint=validate',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ token: token }),
                    success: function (response) {
                        if (response.success) {
                            console.log('Token is valid:', response.data);
                        } else {
                            console.error('Token validation error:', response.error);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }

        // Call these functions as needed
        // refreshToken();
        // validateToken();
    </script>
</body>

</html>
