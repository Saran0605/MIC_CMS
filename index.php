<html>

<head>
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-5/bootstrap-5.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

</html>
<?php
include("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form 
    $type = mysqli_real_escape_string($db, $_POST['type']);
    $myusername = mysqli_real_escape_string($db, $_POST['email']);
    $mypassword = mysqli_real_escape_string($db, $_POST['pass']);

    if ($type == "faculty") {
        if ($myusername == "hroffice" || $myusername == "hr" || $myusername == "busadmin" || $myusername=="principal" || $myusername == "civil" || $myusername == "electrical" || $myusername == "itkm" || $myusername == "transport" || $myusername == "house") {
            $sql = "SELECT * FROM ofaculty WHERE uname = ? AND pass = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ss", $myusername, $mypassword);
        } else {
            $sql = "SELECT * FROM faculty WHERE id = ? AND pass = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ss", $myusername, $mypassword);
        }
    } elseif ($type == "student") {
        $sql = "SELECT * FROM student WHERE sid = ? AND pass = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ss", $myusername, $mypassword);
    } else {
        // Handle invalid type
        echo "<script>
                swal.fire({
                    icon: 'error',
                    title: 'Login Failure',
                    text: 'Invalid user type'
                }).then(function() {
                    window.location = 'index';
                });
              </script>";
        exit;
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;

    if ($count == 1) {
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['login_user'] = $myusername;

        
        // $redirectUrl = ($type == "student") ? "smain" : ($myusername == "hroffice" ? "hr" : ($myusername == "hr" ? "dash.php" : ($myusername == "principal" ? "dash.php" : ($myusername == "busadmin" ? "busadmin/index" : "main"))));
        if ($type == "student") {
            $redirectUrl = "smain.php";
        } else {
            switch ($myusername) {
                case "hroffice":
                    $redirectUrl = "hr.php";
                    break;
                case "hr":
                    $redirectUrl = "dash.php";
                    break;
                case "principal":
                    $redirectUrl = "Codes/Principal/dash.php";
                    break;
                case "busadmin":
                    $redirectUrl = "busadmin2/dashboard";
                    break;
                case "civil":
                    $redirectUrl = "cms_windex.php";
                    break;
                    case "electrical":
                        $redirectUrl = "cms_windex.php";
                        break;
                        case "itkm":
                            $redirectUrl = "cms_windex.php";
                            break;
                            case "transport":
                                $redirectUrl = "cms_windex.php";
                                break;
                                case "home":
                                    $redirectUrl = "cms_windex.php";
                                    break;
                default:
                    $redirectUrl = "main.php";
            }
        }
        echo "<script>
                swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Login Successful'
                }).then(function() {
                    window.location = '$redirectUrl';
                });
              </script>";
    } else {
        echo "<script>
                swal.fire({
                    icon: 'error',
                    title: 'Login Failure',
                    text: 'Check login credentials'
                }).then(function() {
                    window.location = 'index';
                });
              </script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIC</title>
    <link rel="icon" type="image/png" sizes="32x32" href="image/icons/mkce_s.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-5/bootstrap-5.css" rel="stylesheet">
    <style>
        .split-screen {
            display: flex;
            min-height: 100vh;
        }

        .left {
            flex: 0 0 50%;
            background: linear-gradient(135deg, #1e4d92 0%, #1fb5ac 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
            padding: 2rem;
        }

        .right {
            flex: 0 0 50%;
            background: #f0f2f5;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        #particles-left,
        #particles-right {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        #particles-right {
            opacity: 0.3;
        }

        .transport-icon {
            font-size: 6rem;
            margin-bottom: 2rem;
            position: relative;
            z-index: 2;
        }

        .system-title {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
            font-weight: bold;
        }

        .login-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }

        .login-container {
            width: 100%;
            max-width: 700px;
            position: relative;
            z-index: 2;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1),
                0 1px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(120deg, #1e4d92, #1fb5ac);
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 50px;
            background: white;
            border-radius: 50% 50% 0 0;
        }

        .logo-img {
            max-width: 490px;
            margin-bottom: 1rem;
            border-radius: 15px;
            padding: 10px;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .login-form-container {
            padding: 2rem 3rem 3rem;
            position: relative;
            overflow: hidden;
            min-height: 400px;
        }

        .login-tabs-content {
            transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
            position: relative;
            width: 100%;
            background: white;
        }

        .input-group {
            margin-bottom: 1.5rem;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .input-group-text {
            background-color: #1e4d92;
            color: white;
            border: none;
            width: 50px;
            justify-content: center;
        }

        .form-control {
            height: 50px;
            font-size: 1.1rem;
            border: none;
            padding-left: 15px;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .nav-pills {
            margin-bottom: 2rem;
            padding: 4px;
            background: #f8f9fa;
            border-radius: 12px;
            display: flex;
            gap: 10px;
        }

        .nav-item.flex-fill {
            margin: 0 5px;
        }

        .nav-pills .nav-link {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .nav-pills .nav-link.active {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-student,
        .btn-faculty,
        .btn-lostfaculty {
            height: 50px;
            font-size: 1.1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-student {
            background: linear-gradient(135deg, #1e4d92, #2c5aa0);
            color: white;
        }

        .btn-faculty {
            background: linear-gradient(135deg, #1fb5ac, #23c5bb);
            color: white;
        }

        .btn-lostfaculty {
            background: linear-gradient(135deg, #1e4d92, #1fb5ac);
            color: white;
        }

        .btn-student:hover,
        .btn-faculty:hover,
        .btn-lostfaculty:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            color: white;
        }

        .recover-form {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 2rem;
            background: white;
            transform: translateY(100%);
            transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
            opacity: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .recover-form.active {
            transform: translateY(0);
            opacity: 1;
        }

        .login-tabs-content.hide {
            transform: translateY(-100%);
            opacity: 0;
        }

        .recover-title {
            color: #1e4d92;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .recover-description {
            color: #666;
            text-align: center;
            margin-bottom: 2rem;
        }

        .recover-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .recover-buttons button {
            flex: 1;
            height: 50px;
            font-size: 1.1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-back {
            background: #f0f2f5;
            color: #1e4d92;
            border: none;
        }

        .btn-recover {
            background: linear-gradient(135deg, #1e4d92, #1fb5ac);
            color: white;
            border: none;
        }

        .btn-back:hover,
        .btn-recover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .footer {
            background: white;
            padding: 1rem 0;
            position: relative;
            z-index: 2;
            box-shadow: 0 -1px 10px rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 991px) {
            .split-screen {
                flex-direction: column;
            }

            .left {
                flex: 0 0 auto;
                padding: 3rem 1rem;
            }

            .right {
                flex: 1 0 auto;
            }

            .system-title {
                font-size: 2.5rem;
            }

            .login-wrapper {
                padding: 2rem 1rem;
            }

            .login-form-container {
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .system-title {
                font-size: 2rem;
            }

            .transport-icon {
                font-size: 4rem;
            }

            .login-wrapper {
                padding: 1.5rem 1rem;
            }

            .nav-pills .nav-link {
                padding: 0.5rem 1rem;
                font-size: 1rem;
            }

            .login-header {
                padding: 1.5rem;
            }

            .logo-img {
                max-width: 300px;
            }
        }
    </style>
</head>

<body>
    <div class="split-screen">
        <div class="left">
            <div id="particles-left"></div>
            <div class="transport-icon"></div>
            <h1 class="system-title">M KUMARASAMY COLLEGE OF ENGINEERING Info Corner</h1>
        </div>

        <div class="right">
            <div id="particles-right"></div>
            <div class="login-wrapper">
                <div class="login-container">
                    <div class="login-header">
                        <img src="image/mkcelogo.png" alt="MKCE Logo" class="logo-img">
                    </div>

                    <div class="login-form-container">
                        <div class="login-tabs-content">
                            <h2 class="text-center mb-4 fs-1 fw-bold"></h2>

                            <ul class="nav nav-pills mb-4" id="loginTabs" role="tablist">
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link active w-100 btn-student" data-bs-toggle="pill"
                                        data-bs-target="#student" type="button">Student</button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100 btn-faculty" data-bs-toggle="pill"
                                        data-bs-target="#faculty" type="button">Faculty</button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="student">
                                    <form action="#" method="post">
                                        <input type="hidden" id="custId" name="type" value="student">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" name="email" placeholder="Student ID">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" name="pass" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-student w-100">Login as Student</button>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="faculty">
                                    <form action="#" method="post">
                                        <input type="hidden" id="custId" name="type" value="faculty">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" name="email" placeholder="Faculty ID">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" name="pass" placeholder="Password">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-faculty w-100">Login as Faculty</button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" id="to-recover" class="btn btn-lostfaculty w-100">Lost
                                                    password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="recover-form">
                            <h3 class="recover-title">Password Recovery</h3>
                            <p class="recover-description">Enter your Faculty ID and email address below to recover your
                                password.</p>

                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" name="fid" id="fid" placeholder="Faculty ID">
                            </div>

                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Email Address">
                            </div>

                            <div class="recover-buttons">
                                <button type="button" class="btn-back" id="to-login">Back to Login</button>
                                <button type="button" class="btn-recover" id="sendEmailButton">Recover Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer text-center">
                <div class="container">
                    <p class="mb-0">Copyright © 2025 Designed by Technology Innovation Hub - MKCE. All rights reserved.
                    </p>
                </div>
            </footer>
        </div>
    </div>
   
    <!-- Scripts remain the same -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    <script>
        // Particles configurations remain the same
        particlesJS('particles-left', {
            particles: {
                number: {
                    value: 60,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: '#ffffff'
                },
                opacity: {
                    value: 0.5,
                    random: false
                },
                size: {
                    value: 3,
                    random: true
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#ffffff',
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: 'none',
                    random: false,
                    straight: false,
                    out_mode: 'out'
                }
            }
        });

        particlesJS('particles-right', {
            particles: {
                number: {
                    value: 40,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: '#1e4d92'
                },
                opacity: {
                    value: 0.3,
                    random: false
                },
                size: {
                    value: 2,
                    random: true
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#1e4d92',
                    opacity: 0.2,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 1,
                    direction: 'none',
                    random: false,
                    straight: false,
                    out_mode: 'out'
                }
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#to-recover").click(function() {
                $(".login-tabs-content").addClass("hide");
                $(".recover-form").addClass("active");
            });

            $("#to-login").click(function() {
                $(".login-tabs-content").removeClass("hide");
                $(".recover-form").removeClass("active");
            });

            // Previous AJAX code for password recovery remains the same
            $("#sendEmailButton").click(function() {
                var email = $("#email").val();
                var id = $("#fid").val();

                $.ajax({
                    type: "POST",
                    url: "mail.php",
                    data: {
                        email: email,
                        fid: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: "An error occurred. Please try again later.",
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>