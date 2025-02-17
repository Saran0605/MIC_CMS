<?php
include("config.php");
include("session.php");



header('Content-Type: application/json');
$response = array('success' => false, 'message' => '');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['id']) || !isset($_POST['action'])) {
            throw new Exception("Missing required parameters.");
        }
        $applicantId = mysqli_real_escape_string($conn, $_POST['id']);
        $action = mysqli_real_escape_string($conn, $_POST['action']);
        $page = isset($_POST['page']) ? mysqli_real_escape_string($conn, $_POST['page']) : '';
        $reason_to_reject = isset($_POST['reason']) ? mysqli_real_escape_string($conn, $_POST['reason']) : '';
        $extended_date = isset($_POST['date']) ? mysqli_real_escape_string($conn, $_POST['date']) : '';

        switch ($_POST['data']) {
            case 'journal':
                $stmt0 = $conn->prepare("SELECT status_no FROM journal_papers WHERE id = ?");
                if (!$stmt0) {
                    throw new Exception("Preparation failed: " . $conn->error);
                }
                $stmt0->bind_param("i", $applicantId);
                $stmt0->execute();
                $result0 = $stmt0->get_result();

                if ($result0->num_rows > 0) {
                    $row = $result0->fetch_assoc();
                    $status_no = $row['status_no'];
                } else {
                    echo "<option value=''>No events available</option>";
                    exit;
                }

                switch ($page) {
                    case 'hod':
                        if ($action === 'approve' && $status_no == 0) {
                            $sql = "UPDATE journal_papers SET status_no = 1 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 0) {
                            $sql = "UPDATE journal_papers SET status_no = 3, feedback = ? WHERE id = ?";
                        }
                        break;

                    case 'iqac':
                        if ($action === 'approve' && $status_no == 1) {
                            $sql = "UPDATE journal_papers SET status_no = 2 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 1) {
                            $sql = "UPDATE journal_papers SET status_no = 4, feedback = ? WHERE id = ?";
                        }
                        break;

                    default:
                        throw new Exception('Invalid page specified.');
                }
                break;

            case 'conference':
                $stmt0 = $conn->prepare("SELECT status_no FROM conference_papers WHERE id = ?");
                if (!$stmt0) {
                    throw new Exception("Preparation failed: " . $conn->error);
                }
                $stmt0->bind_param("i", $applicantId);
                $stmt0->execute();
                $result0 = $stmt0->get_result();

                if ($result0->num_rows > 0) {
                    $row = $result0->fetch_assoc();
                    $status_no = $row['status_no'];
                } else {
                    echo "<option value=''>No events available</option>";
                    exit;
                }

                switch ($page) {
                    case 'hod':
                        if ($action === 'approve' && $status_no == 0) {
                            $sql = "UPDATE conference_papers SET status_no = 1 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 0) {
                            $sql = "UPDATE conference_papers SET status_no = 3, feedback = ? WHERE id = ?";
                        }
                        break;

                    case 'iqac':
                        if ($action === 'approve' && $status_no == 1) {
                            $sql = "UPDATE conference_papers SET status_no = 2 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 1) {
                            $sql = "UPDATE conference_papers SET status_no = 4, feedback = ? WHERE id = ?";
                        }
                        break;

                    default:
                        throw new Exception('Invalid page specified.');
                }
                break;
                case 'book':
                    $stmt0 = $conn->prepare("SELECT status_no FROM book WHERE id = ?");
                    if (!$stmt0) {
                        throw new Exception("Preparation failed: " . $conn->error);
                    }
                    $stmt0->bind_param("i", $applicantId);
                    $stmt0->execute();
                    $result0 = $stmt0->get_result();
    
                    if ($result0->num_rows > 0) {
                        $row = $result0->fetch_assoc();
                        $status_no = $row['status_no'];
                    } else {
                        echo "<option value=''>No events available</option>";
                        exit;
                    }
    
                    switch ($page) {
                        case 'hod':
                            if ($action === 'approve' && $status_no == 0) {
                                $sql = "UPDATE book SET status_no = 1 WHERE id = ?";
                            } elseif ($action === 'reject' && $status_no == 0) {
                                $sql = "UPDATE book SET status_no = 3, feedback = ? WHERE id = ?";
                            }
                            break;
    
                        case 'iqac':
                            if ($action === 'approve' && $status_no == 1) {
                                $sql = "UPDATE book SET status_no = 2 WHERE id = ?";
                            } elseif ($action === 'reject' && $status_no == 1) {
                                $sql = "UPDATE  book SET status_no = 4, feedback = ? WHERE id = ?";
                            }
                            break;
    
                        default:
                            throw new Exception('Invalid page specified.');
                    }
                    break;
    
    
    


            case 'patent':
                $stmt0 = $conn->prepare("SELECT status_no FROM patents WHERE id = ?");
                if (!$stmt0) {
                    throw new Exception("Preparation failed: " . $conn->error);
                }
                $stmt0->bind_param("i", $applicantId);
                $stmt0->execute();
                $result0 = $stmt0->get_result();

                if ($result0->num_rows > 0) {
                    $row = $result0->fetch_assoc();
                    $status_no = $row['status_no'];
                } else {
                    echo "<option value=''>No events available</option>";
                    exit;
                }

                switch ($page) {
                    case 'hod':
                        if ($action === 'approve' && $status_no == 0) {
                            $sql = "UPDATE patents SET status_no = 1 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 0) {
                            $sql = "UPDATE patents SET status_no = 3, feedback = ? WHERE id = ?";
                        }
                        break;

                    case 'iqac':
                        if ($action === 'approve' && $status_no == 1) {
                            $sql = "UPDATE patents SET status_no = 2 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 1) {
                            $sql = "UPDATE patents SET status_no = 4, feedback = ? WHERE id = ?";
                        }
                        break;

                    default:
                        throw new Exception('Invalid page specified.');
                }
                break;

                
                case 'copyright':
                    $stmt0 = $conn->prepare("SELECT status_no FROM copyrights WHERE id = ?");
                    if (!$stmt0) {
                        throw new Exception("Preparation failed: " . $conn->error);
                    }
                    $stmt0->bind_param("i", $applicantId);
                    $stmt0->execute();
                    $result0 = $stmt0->get_result();
    
                    if ($result0->num_rows > 0) {
                        $row = $result0->fetch_assoc();
                        $status_no = $row['status_no'];
                    } else {
                        echo "<option value=''>No events available</option>";
                        exit;
                    }
    
                    switch ($page) {
                        case 'hod':
                            if ($action === 'approve' && $status_no == 0) {
                                $sql = "UPDATE copyrights SET status_no = 1 WHERE id = ?";
                            } elseif ($action === 'reject' && $status_no == 0) {
                                $sql = "UPDATE copyrights SET status_no = 3, feedback = ? WHERE id = ?";
                            }
                            break;
    
                        case 'iqac':
                            if ($action === 'approve' && $status_no == 1) {
                                $sql = "UPDATE copyrights SET status_no = 2 WHERE id = ?";
                            } elseif ($action === 'reject' && $status_no == 1) {
                                $sql = "UPDATE  copyrights SET status_no = 4, feedback = ? WHERE id = ?";
                            }
                            break;
    
                        default:
                            throw new Exception('Invalid page specified.');
                    }
                    break;

                    case 'project':
                        $stmt0 = $conn->prepare("SELECT status_no FROM projects WHERE id = ?");
                        if (!$stmt0) {
                            throw new Exception("Preparation failed: " . $conn->error);
                        }
                        $stmt0->bind_param("i", $applicantId);
                        $stmt0->execute();
                        $result0 = $stmt0->get_result();
        
                        if ($result0->num_rows > 0) {
                            $row = $result0->fetch_assoc();
                            $status_no = $row['status_no'];
                        } else {
                            echo "<option value=''>No events available</option>";
                            exit;
                        }
        
                        switch ($page) {
                            case 'hod':
                                if ($action === 'approve' && $status_no == 0) {
                                    $sql = "UPDATE projects SET status_no = 1 WHERE id = ?";
                                } elseif ($action === 'reject' && $status_no == 0) {
                                    $sql = "UPDATE projects SET status_no = 3, feedback = ? WHERE id = ?";
                                }
                                break;
        
                            case 'iqac':
                                if ($action === 'approve' && $status_no == 1) {
                                    $sql = "UPDATE projects SET status_no = 2 WHERE id = ?";
                                } elseif ($action === 'reject' && $status_no == 1) {
                                    $sql = "UPDATE  projects SET status_no = 4, feedback = ? WHERE id = ?";
                                }
                                break;
        
                            default:
                                throw new Exception('Invalid page specified.');
                        }
                        break;

                        case 'project_guidance':
                            $stmt0 = $conn->prepare("SELECT status_no FROM project_guidance WHERE id = ?");
                            if (!$stmt0) {
                                throw new Exception("Preparation failed: " . $conn->error);
                            }
                            $stmt0->bind_param("i", $applicantId);
                            $stmt0->execute();
                            $result0 = $stmt0->get_result();
            
                            if ($result0->num_rows > 0) {
                                $row = $result0->fetch_assoc();
                                $status_no = $row['status_no'];
                            } else {
                                echo "<option value=''>No events available</option>";
                                exit;
                            }
            
                            switch ($page) {
                                case 'hod':
                                    if ($action === 'approve' && $status_no == 0) {
                                        $sql = "UPDATE project_guidance SET status_no = 1 WHERE id = ?";
                                    } elseif ($action === 'reject' && $status_no == 0) {
                                        $sql = "UPDATE project_guidance SET status_no = 3, feedback = ? WHERE id = ?";
                                    }
                                    break;
            
                                case 'iqac':
                                    if ($action === 'approve' && $status_no == 1) {
                                        $sql = "UPDATE project_guidance SET status_no = 2 WHERE id = ?";
                                    } elseif ($action === 'reject' && $status_no == 1) {
                                        $sql = "UPDATE  project_guidance SET status_no = 4, feedback = ? WHERE id = ?";
                                    }
                                    break;
            
                                default:
                                    throw new Exception('Invalid page specified.');
                            }
                            break;

            case 'consultancy':
                $stmt0 = $conn->prepare("SELECT status1 FROM consultancy WHERE id = ?");
                if (!$stmt0) {
                    throw new Exception("Preparation failed: " . $conn->error);
                }
                $stmt0->bind_param("i", $applicantId);
                $stmt0->execute();
                $result0 = $stmt0->get_result();

                if ($result0->num_rows > 0) {
                    $row = $result0->fetch_assoc();
                    $status_no = $row['status1'];
                } else {
                    echo "<option value=''>No events available</option>";
                    exit;
                }

                switch ($page) {
                    case 'hod':
                        if ($action === 'approve' && $status_no == 0) {
                            $sql = "UPDATE consultancy SET status1 = 1 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 0) {
                            $sql = "UPDATE consultancy SET status1 = 3, feedback = ? WHERE id = ?";
                        }
                        break;

                    case 'iqac':
                        if ($action === 'approve' && $status_no == 1) {
                            $sql = "UPDATE consultancy SET status1 = 2 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 1) {
                            $sql = "UPDATE consultancy SET status1 = 4, feedback = ? WHERE id = ?";
                        }
                        break;

                    default:
                        throw new Exception('Invalid page specified.');
                }
                break;

            case 'iconsultancy':
                $stmt0 = $conn->prepare("SELECT istatus1 FROM industry_consultancy WHERE id = ?");
                if (!$stmt0) {
                    throw new Exception("Preparation failed: " . $conn->error);
                }
                $stmt0->bind_param("i", $applicantId);
                $stmt0->execute();
                $result0 = $stmt0->get_result();

                if ($result0->num_rows > 0) {
                    $row = $result0->fetch_assoc();
                    $status_no = $row['istatus1'];
                } else {
                    echo "<option value=''>No events available</option>";
                    exit;
                }

                switch ($page) {
                    case 'hod':
                        if ($action === 'approve' && $status_no == 0) {
                            $sql = "UPDATE industry_consultancy SET istatus1 = 1 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 0) {
                            $sql = "UPDATE industry_consultancy SET istatus1 = 3, ifeedback = ? WHERE id = ?";
                        }
                        break;

                    case 'iqac':
                        if ($action === 'approve' && $status_no == 1) {
                            $sql = "UPDATE industry_consultancy SET istatus1 = 2 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 1) {
                            $sql = "UPDATE industry_consultancy SET istatus1 = 4, ifeedback = ? WHERE id = ?";
                        }
                        break;

                    default:
                        throw new Exception('Invalid page specified.');
                }
                break;
            case 'researchguideship':
                $stmt0 = $conn->prepare("SELECT status_no FROM researchguideship WHERE id = ?");
                if (!$stmt0) {
                    throw new Exception("Preparation failed: " . $conn->error);
                }
                $stmt0->bind_param("i", $applicantId);
                $stmt0->execute();
                $result0 = $stmt0->get_result();

                if ($result0->num_rows > 0) {
                    $row = $result0->fetch_assoc();
                    $status_no = $row['status_no'];
                } else {
                    echo "<option value=''>No events available</option>";
                    exit;
                }

                switch ($page) {
                    case 'hod':
                        if ($action === 'approve' && $status_no == 0) {
                            $sql = "UPDATE researchguideship SET status_no = 1 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 0) {
                            $sql = "UPDATE researchguideship SET status_no = 3, feedback = ? WHERE id = ?";
                        }
                        break;

                    case 'iqac':
                        if ($action === 'approve' && $status_no == 1) {
                            $sql = "UPDATE researchguideship SET status_no = 2 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 1) {
                            $sql = "UPDATE researchguideship SET status_no = 4, feedback = ? WHERE id = ?";
                        }
                        break;

                    default:
                        throw new Exception('Invalid page specified.');
                }
                break;

            case 'activityr_guidance':
                $stmt0 = $conn->prepare("SELECT status_no FROM research_guidance WHERE guidance_id = ?");
                if (!$stmt0) {
                    throw new Exception("Preparation failed: " . $conn->error);
                }
                $stmt0->bind_param("i", $applicantId);
                $stmt0->execute();
                $result0 = $stmt0->get_result();

                if ($result0->num_rows > 0) {
                    $row = $result0->fetch_assoc();
                    $status_no = $row['status_no'];
                } else {
                    echo "<option value=''>No events available</option>";
                    exit;
                }

                switch ($page) {
                    case 'hod':
                        if ($action === 'approve' && $status_no == 0) {
                            $sql = "UPDATE research_guidance SET status_no = 1 WHERE guidance_id = ?";
                        } elseif ($action === 'reject' && $status_no == 0) {
                            $sql = "UPDATE research_guidance SET status_no = 3, feedback = ? WHERE guidance_id = ?";
                        }
                        break;

                    case 'iqac':
                        if ($action === 'approve' && $status_no == 1) {
                            $sql = "UPDATE research_guidance SET status_no = 2 WHERE guidance_id = ?";
                        } elseif ($action === 'reject' && $status_no == 1) {
                            $sql = "UPDATE research_guidance SET status_no = 4, feedback = ? WHERE guidance_id = ?";
                        }
                        break;

                    default:
                        throw new Exception('Invalid page specified.');
                }


                break;

            case 'certificate':
                $stmt0 = $conn->prepare("SELECT status FROM certifications WHERE id = ?");
                if (!$stmt0) {
                    throw new Exception("Preparation failed: " . $conn->error);
                }
                $stmt0->bind_param("i", $applicantId);
                $stmt0->execute();
                $result0 = $stmt0->get_result();

                if ($result0->num_rows > 0) {
                    $row = $result0->fetch_assoc();
                    $status_no = $row['status'];
                } else {
                    echo "<option value=''>No events available</option>";
                    exit;
                }

                switch ($page) {
                    case 'hod':
                        if ($action === 'approve' && $status_no == 0) {
                            $sql = "UPDATE certifications SET status = 1 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 0) {
                            $sql = "UPDATE certifications SET status = 3, feedback = ? WHERE id = ?";
                        }
                        break;

                    case 'iqac':
                        if ($action === 'approve' && $status_no == 1) {
                            $sql = "UPDATE certifications SET status = 2 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 1) {
                            $sql = "UPDATE certifications SET status = 4, feedback = ? WHERE id = ?";
                        }
                        break;

                    case 'principal':
                        if ($action === 'approve' && $status_no == 2) {
                            $sql = "UPDATE certifications SET status = 5 WHERE id = ?";
                        } elseif ($action === 'reject' && $status_no == 2) {
                            $sql = "UPDATE certifications SET status = 6, feedback = ? WHERE id = ?";
                        }
                        break;

                    default:
                        throw new Exception('Invalid page specified.');
                }


                break;







            default:
                throw new Exception("Invalid data type specified.");
        }

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Preparation failed: " . $conn->error);
        }

        // Bind parameters based on action
        if ($action === 'reject') {
            $stmt->bind_param("si", $reason_to_reject, $applicantId);
        } elseif ($action === 'reportfeedback') {
            $stmt->bind_param("si", $reason_to_reject, $applicantId);
        } elseif ($action === 'deadlineResume') {
            $stmt->bind_param("si", $extended_date, $applicantId);
        } else {
            $stmt->bind_param("i", $applicantId);
        }

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = ucfirst($action) . " Successful.";
        } else {
            throw new Exception(ucfirst($action) . " failed: " . $stmt->error);
        }
    }
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}
echo json_encode($response);
$conn->close();
