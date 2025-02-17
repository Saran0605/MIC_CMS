<!-- change_password.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .password-change-form {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-floating {
            margin-bottom: 1rem;
        }
        .password-requirements {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 10px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="password-change-form bg-white">
            <h2 class="text-center mb-4">Change Password</h2>
            <form id="passwordChangeForm">
                <div class="form-floating">
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password" required>
                    <label for="currentPassword">Current Password</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" required>
                    <label for="newPassword">New Password</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm New Password" required>
                    <label for="confirmPassword">Confirm New Password</label>
                </div>
                <div class="password-requirements">
                    Password must contain:
                    <ul>
                        <li>At least 8 characters</li>
                        <li>One uppercase letter</li>
                        <li>One lowercase letter</li>
                        <li>One number</li>
                    </ul>
                </div>
                <div class="alert alert-danger d-none" id="errorMessage"></div>
                <div class="alert alert-success d-none" id="successMessage"></div>
                <button type="submit" class="btn btn-primary w-100">Change Password</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#passwordChangeForm').on('submit', function(e) {
                e.preventDefault();
                
                // Hide previous messages
                $('#errorMessage, #successMessage').addClass('d-none');
                
                // Basic client-side validation
                const newPass = $('#newPassword').val();
                const confirmPass = $('#confirmPassword').val();
                
                if (newPass !== confirmPass) {
                    $('#errorMessage').text('New passwords do not match!').removeClass('d-none');
                    return;
                }
                
                // Password strength validation
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d!@#$%^&*()_+\-=\[\]{};:'",.<>/?]{8,}$/;
                if (!passwordRegex.test(newPass)) {
                    $('#errorMessage').text('Password does not meet requirements!').removeClass('d-none');
                    return;
                }
                // Send AJAX request
                $.ajax({
                    url: 'change_password.php',
                    type: 'POST',
                    data: {
                        currentPassword: $('#currentPassword').val(),
                        newPassword: newPass,
                        confirmPassword: confirmPass
                    },

                    success: function(response) {
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }
                        if (response.success) {
                            $('#successMessage').text(response.message).removeClass('d-none');
                            $('#passwordChangeForm')[0].reset();
                        } else {
                            $('#errorMessage').text(response.message).removeClass('d-none');
                        }
                    },
                    error: function() {
                        $('#errorMessage').text('An error occurred. Please try again.').removeClass('d-none');
                    }
                });
            });
        });
    </script>
</body>
</html>

