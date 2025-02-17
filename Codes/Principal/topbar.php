<style>
    /* Topbar Styles */
    .topbar {
        position: fixed;
        top: 0;
        right: 0;
        left: var(--sidebar-width);
        height: var(--topbar-height);
        /* background-color: #E4E4E1; */
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.15) 0%, rgba(0, 0, 0, 0.15) 100%), radial-gradient(at top center, rgba(255, 255, 255, 0.40) 0%, rgba(0, 0, 0, 0.40) 120%) #989898;
        background-blend-mode: multiply, multiply;

        box-shadow: var(--card-shadow);
        display: flex;
        align-items: center;
        padding: 0 20px;
        transition: all 0.3s ease;
        z-index: 999;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .brand-logo {
        display: none;
        color: var(--primary-color);
        font-size: 24px;
        margin: 0 auto;
    }

    .sidebar.collapsed+.content .topbar {
        left: var(--sidebar-collapsed-width);
    }

    .hamburger {
        cursor: pointer;
        font-size: 20px;
        color: white;
    }

    .user-profile {
        margin-left: auto;
        color: white;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        position: relative;
        transition: var(--transition);
        border: 2px solid var(--primary-color);
    }

    .user-avatar:hover {
        transform: scale(1.1);
    }

    .online-indicator {
        position: absolute;
        width: 10px;
        height: 10px;
        background: var(--success-color);
        border-radius: 50%;
        bottom: 0;
        right: 0;
        animation: blink 1.5s infinite;
    }

    @keyframes blink {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }

        100% {
            opacity: 1;
        }
    }

    /* User Menu Dropdown */
    .user-menu {
        position: relative;
        cursor: pointer;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        display: none;
        min-width: 200px;
    }

    .dropdown-menu.show {
        display: block;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-10px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .dropdown-item {
        padding: 10px 20px;
        color: var(--secondary-color);
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background: var(--light-bg);
        color: var(--primary-color);
    }

    /* User Profile Styles */
    .user-profile {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .online-indicator {
        position: absolute;
        width: 10px;
        height: 10px;
        background: var(--success-color);
        border-radius: 50%;
        bottom: 0;
        right: 0;
        border: 2px solid white;
        animation: blink 1.5s infinite;
    }

     /* Modal Styling with Wow Effect */
     .modal {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: 9999 !important;
        }

        .modal-dialog {
            transition: all 0.3s ease-in-out;
            transform: scale(0.7);
            opacity: 0;
        }

        .modal.show .modal-dialog {
            transform: scale(1);
            opacity: 1;
        }

        .modal-content {
            border-radius: 15px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
            background: linear-gradient(145deg, #f0f0f0, #ffffff);
            border: none;
            overflow: hidden;
            z-index: 9999 !important;
        }

        .modal-header {
            background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 15px 20px;
            border-bottom: none;
        }

        .modal-header .modal-title {
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .modal-header .btn-close {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            opacity: 1;
            width: 30px;
            height: 30px;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e");
            background-size: 30%;
            background-position: center;
            background-repeat: no-repeat;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .modal-header .btn-close:hover {
            background-color: rgba(255, 255, 255, 0.4);
            transform: scale(1.1);
        }

        .modal-header .btn-close:focus {
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
            outline: none;
        }

        .modal-body {
            padding: 20px;
            background: #f8f9fa;
        }

        .modal-body p {
            margin-bottom: 10px;
            color: #333;
        }

        .modal-body p strong {
            color: #2575fc;
        }

        .modal-body .badge {
            font-size: 0.9em;
            padding: 5px 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Animate entrance */
        @keyframes modalEnter {
            0% {
                opacity: 0;
                transform: scale(0.7) translateY(-50px);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal.show .modal-dialog {
            animation: modalEnter 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

</style>

<div class="topbar">
    <div class="hamburger" id="hamburger">
        <i class="fas fa-bars"></i>
    </div>
    <!-- <div class="brand-logo">
                <i class="fas fa-chart-line"></i>
                MIC
            </div> -->
    <div class="user-profile">
        <div class="user-menu" id="userMenu">
            <div class="user-avatar">
                <img src="../../images\icon\user.png" alt="User">
                <div class="online-indicator"></div>
            </div>
            <div class="dropdown-menu">
            <!-- <a class="dropdown-item" href="#" id="changePasswordTrigger">
                    <i class="fas fa-key"></i>
                    Change Password
                </a> -->
                <a href='../../Logout' class="dropdown-item">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </div>
        <span>Principal</span>
    </div>

    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="changePasswordForm" action="update_password.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function () {
        // Get modal instance once
        const changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));

        // Trigger modal when dropdown item is clicked
        $('#changePasswordTrigger').on('click', function (e) {
            e.preventDefault();
            changePasswordModal.show();
        });

        // Form submission logic
        $('#changePasswordForm').on('submit', function (e) {
            e.preventDefault();

            // Client-side validation
            var newPassword = $('input[name="new_password"]').val();
            var confirmPassword = $('input[name="confirm_password"]').val();

            if (newPassword !== confirmPassword) {
                alert('New passwords do not match!');
                return;
            }

            // AJAX form submission
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        alert('Password updated successfully!');
                        changePasswordModal.hide(); // Use Bootstrap 5 method
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
</script>