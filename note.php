<style>
    /* Sidebar Styles */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: var(--sidebar-width);
        background: var(--dark-bg);
        transition: var(--transition);
        z-index: 1000;
        overflow-y: auto;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        background-image: url('image/pattern_h.png');
    }

    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }

    .sidebar.collapsed {
        width: var(--sidebar-collapsed-width);
    }

    .sidebar .logo {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
        color: white;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar .logo img {
        max-height: 90px;
        width: auto;
    }

    .sidebar .s_logo {
        display: none;
    }

    .sidebar.collapsed .logo img {
        display: none;
    }

    .sidebar.collapsed .logo .s_logo {
        display: flex;
        max-height: 50px;
        width: auto;
        align-items: center;
        justify-content: center;
    }

    .sidebar .menu {
        padding: 10px;
    }

    .menu-item {
        padding: 12px 15px;
        color: rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        cursor: pointer;
        border-radius: 5px;
        margin: 4px 0;
        transition: all 0.3s ease;
        position: relative;
        text-decoration: none;
    }

    .menu-item:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .menu-item i {
        min-width: 30px;
        font-size: 18px;
    }

    .menu-item span {
        margin-left: 10px;
        transition: all 0.3s ease;
        flex-grow: 1;
    }

    .has-submenu::after {
        content: '\f107';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        margin-left: 10px;
        transition: transform 0.3s ease;
    }

    .has-submenu.active::after {
        transform: rotate(180deg);
    }

    .sidebar.collapsed .menu-item span,
    .sidebar.collapsed .has-submenu::after {
        display: none;
    }

    .submenu {
        margin-left: 30px;
        display: none;
        transition: all 0.3s ease;
    }

    .submenu.active {
        display: block;
    }
</style>

<div class="mobile-overlay" id="mobileOverlay"></div>
<div class="sidebar" id="sidebar">
    <div class="logo">
        <img src="image/mkce.png" alt="College Logo">
        <img class='s_logo' src="image/mkce_s.png" alt="College Logo">
    </div>

    <div class="menu">
        <a href="smain.php" class="menu-item">
            <i class="fas fa-home text-primary"></i>
            <span>Dashboard</span>
        </a>
        <a href="sprofile.php" class="menu-item">
            <i class="fas fa-bus text-warning"></i>
            <span>Profile</span>
        </a>
        <div class="submenu">
            <a href="sBasic.php" class="menu-item">
                <i class="fas fa-user-plus text-warning"></i>
                <span>Basic Details</span>
            </a>
            <a href="sacademic.php" class="menu-item">
                <i class="fas fa-user-edit text-info"></i>
                <span>Academic Details</span>
            </a>
            <a href="sexam.php" class="menu-item">
                <i class="fas fa-user-edit text-info"></i>
                <span>Exams Details</span>
            </a>
        </div>

        <a href="bus_booking.php" class="menu-item">
            <i class="fas fa-cog text-secondary"></i>
            <span>Bus Booking</span>
        </a>
        <a href="sfeedback.php" class="menu-item">
            <i class="fas fa-cog text-secondary"></i>
            <span>Feedback Corner</span>
        </a>
        <a href="spwd.php" class="menu-item">
            <i class="fas fa-cog text-secondary"></i>
            <span>Change Password</span>
        </a>
    </div>
</div>


<form id="edit_account_form">
    <div class="modal-body">
        <input type="hidden" id="id1" name="id">
        <div class="row">
            <div class="form-group col-md-4">
                <label for="group_name" class="form-label">Group Name</label>
                <select class="select2 form-control custom-select" id="ed_group_name" name="group_name" style="width: 100%; height:36px;" required>
                    <option value="">Select</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="vendor_name" class="form-label">Vendor Name</label>
                <input type="text" class="form-control" id="edit_vendor_name" name="vendor_name" placeholder="Enter vendor name">
            </div>
            <div class="form-group col-md-4">
                <label for="edit_ref" class="form-label">Ref</label>
                <input type="text" class="form-control" id="edit_ref" name="ref1" placeholder="Enter reference">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="edit_account_name" class="form-label">Account Name</label>
                <input type="text" class="form-control" id="edit_account_name" name="account_name" placeholder="Enter account name">
            </div>
            <div class="form-group col-md-4">
                <label for="edit_opening_balance" class="form-label">Opening Balance</label>
                <input type="number" class="form-control" id="edit_opening_balance" name="obalance" placeholder="Enter opening balance">
            </div>
            <div class="form-group col-md-4">
                <label for="edit_account_group" class="form-label">A/C Group</label>
                <input type="text" class="form-control" id="edit_account_group" name="account_group" placeholder="Enter account group">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="edit_bank_account_no" class="form-label">Bank A/C No</label>
                <input type="text" class="form-control" id="edit_bank_account_no" name="bank_number" placeholder="Enter bank account number">
            </div>
            <div class="form-group col-md-4">
                <label for="edit_bank_account_name" class="form-label">Bank A/C Name</label>
                <input type="text" class="form-control" id="edit_bank_account_name" name="aname" placeholder="Enter bank account name">
            </div>

            <div class="form-group col-md-4">
                <label for="edit_bank_number" class="form-label">Bank Name</label>
                <input type="text" class="form-control" id="edit_bank_number" name="bank_name" placeholder="Enter bank name">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="edit_bank_branch" class="form-label">Bank Branch</label>
                <input type="text" class="form-control" id="edit_bank_branch" name="bank_branch" placeholder="Enter bank branch">
            </div>
            <div class="form-group col-md-6">
                <label for="edit_ifsc_code" class="form-label">IFSC Code</label>
                <input type="text" class="form-control" id="edit_ifsc_code" name="ifsc_code" placeholder="Enter IFSC code">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="edit_md_name" class="form-label">MD Name</label>
                <input type="text" class="form-control" id="edit_md_name" name="md_name" placeholder="Enter MD name">
            </div>
            <div class="form-group col-md-6">
                <label for="edit_contact_person" class="form-label">Contact Person</label>
                <input type="text" class="form-control" id="edit_contact_person" name="contact_person" placeholder="Enter contact person name">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="edit_street" class="form-label">Street</label>
                <input type="text" class="form-control" id="edit_street" name="street" placeholder="Enter street name">
            </div>
            <div class="form-group col-md-4">
                <label for="edit_place" class="form-label">Place</label>
                <input type="text" class="form-control" id="edit_place" name="place" placeholder="Enter place">
            </div>
            <div class="form-group col-md-4">
                <label for="edit_city" class="form-label">City</label>
                <input type="text" class="form-control" id="edit_city" name="city" placeholder="Enter city">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="edit_state" class="form-label">State</label>
                <input type="text" class="form-control" id="edit_state" name="state" placeholder="Enter state">
            </div>
            <div class="form-group col-md-4">
                <label for="edit_pin_code" class="form-label">PIN Code</label>
                <input type="text" class="form-control" id="edit_pin_code" name="pin_code" placeholder="Enter PIN code">
            </div>

        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="edit_landline_no" class="form-label">Land Line No</label>
                <input type="tel" class="form-control" id="edit_landline_no" name="land_line" placeholder="Enter landline number">
            </div>
            <div class="form-group col-md-4">
                <label for="edit_mobile_number" class="form-label">Mobile Number</label>
                <input type="tel" class="form-control" id="edit_mobile_number" name="mobile_number" placeholder="Enter mobile number">
            </div>
            <div class="form-group col-md-4">
                <label for="edit_sms_no" class="form-label">SMS No</label>
                <input type="tel" class="form-control" id="edit_sms_no" name="sms" placeholder="Enter SMS number">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="edit_email_number" class="form-label">Email</label>
                <input type="email" class="form-control" id="edit_email_number" name="email" placeholder="Enter email">
            </div>
            <div class="form-group col-md-4">
                <label for="edit_gst_no" class="form-label">GST No</label>
                <input type="text" class="form-control" id="edit_gst_no" name="gst" placeholder="Enter GST number">
            </div>
            <div class="form-group col-md-4">
                <label for="edit_pan_number" class="form-label">PAN Number</label>
                <input type="text" class="form-control" id="edit_pan_number" name="pan_no" placeholder="Enter PAN number">
            </div>
        </div>




    </div>
    <div class="modal-footer d-flex justify-content-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update Details</button>
    </div>
</form>

 <div class="col-md-4 mb-3">
    <label for="validationCustomProfilePhoto">Profile Photo *</label>
    <?php
    $existing_file = (mysqli_num_rows($query_run) == 1) ? $student['photo'] : "";
    ?>
    <div class="input-group">
        <input type="file" class="form-control custom-file-input" name="photo"
            id="validationCustomProfilePhoto"
            onchange="return fileValidation('validationCustomProfilePhoto')"
            <?php echo $existing_file ? '' : 'required'; ?>>

        <label class="custom-file-label" for="validationCustomProfilePhoto" id="fileLabel">
            <?php echo $existing_file ? basename($existing_file) : 'Choose file'; ?>
        </label>
        <div class="valid-feedback">Looks good!</div>
        <div class="invalid-feedback">Please choose a profile photo.</div>
    </div>
    
    <?php if ($existing_file): ?>
        <div class="mt-2">
            <span class="text-muted">Current file: <?php echo basename($existing_file); ?></span>
            <input type="hidden" name="existing_photo" value="<?php echo $existing_file; ?>">
        </div>
    <?php endif; ?>
</div>
<script>
    document.getElementById('validationCustomProfilePhoto').addEventListener('change', function(event) {
        let fileLabel = document.getElementById('fileLabel');
        if (this.files.length > 0) {
            fileLabel.textContent = this.files[0].name;
        }
    });


    $query = "SELECT photo, aadhar, pan FROM basic WHERE id='$s'";
    $query_run = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($query_run);
    
    $existing_photo = $row['photo'];
    $existing_aadhar = $row['aadhar'];
    $existing_pan = $row['pan'];

    // Handle Profile Photo Upload
    if (!empty($_FILES['photo']['name'])) {
        $file_name = $_FILES['photo']['name'];
        $file_tmp = $_FILES['photo']['tmp_name'];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_name = $s . "." . $ext;
        $filePath = "images/profile/" . $file_name;
        
        if (!empty($existing_photo) && file_exists($existing_photo)) {
            unlink($existing_photo);
        }
        
        move_uploaded_file($file_tmp, $filePath);
    } else {
        $filePath = $existing_photo; // Retain existing photo if no new file is uploaded
    }

    // Handle Aadhar Upload
    if (!empty($_FILES['aadhar']['name'])) {
        $file_name2 = $_FILES['aadhar']['name'];
        $file_tmp2 = $_FILES['aadhar']['tmp_name'];
        $ext2 = pathinfo($file_name2, PATHINFO_EXTENSION);
        $file_name2 = $s . "." . $ext2;
        $filePath2 = "images/Aadhar/" . $file_name2;

        if (!empty($existing_aadhar) && file_exists($existing_aadhar)) {
            unlink($existing_aadhar);
        }

        move_uploaded_file($file_tmp2, $filePath2);
    } else {
        $filePath2 = $existing_aadhar;
    }

    // Handle PAN Upload
    if (!empty($_FILES['pan']['name'])) {
        $file_name3 = $_FILES['pan']['name'];
        $file_tmp3 = $_FILES['pan']['tmp_name'];
        $ext3 = pathinfo($file_name3, PATHINFO_EXTENSION);
        $file_name3 = $s . "." . $ext3;
        $filePath3 = "images/PAN/" . $file_name3;

        if (!empty($existing_pan) && file_exists($existing_pan)) {
            unlink($existing_pan);
        }

        move_uploaded_file($file_tmp3, $filePath3);
    } else {
        $filePath3 = $existing_pan;
    }
    </script>