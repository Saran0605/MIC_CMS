<?php

require 'config.php';
require 'session.php';




if (isset($_POST['update_basic'])) {
    $errors = array();
    
    // Basic Information
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $fname = mysqli_real_escape_string($db, $_POST['fname']);
    $lname = mysqli_real_escape_string($db, $_POST['lname']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $dob = mysqli_real_escape_string($db, $_POST['dob']);
    $age = mysqli_real_escape_string($db, $_POST['age']);
    $religion = mysqli_real_escape_string($db, $_POST['religion']);
    $social = mysqli_real_escape_string($db, $_POST['social']);
    $caste = mysqli_real_escape_string($db, $_POST['caste']);
    $ms = mysqli_real_escape_string($db, $_POST['ms']);
    $pim1 = mysqli_real_escape_string($db, $_POST['pim1']);
    $qualification = mysqli_real_escape_string($db, $_POST['highest_qualification']);

    // Address Information
    $paddress = mysqli_real_escape_string($db, $_POST['paddress']);
    $taddress = mysqli_real_escape_string($db, $_POST['taddress']);
    $state = mysqli_real_escape_string($db, $_POST['state']);
    $city = mysqli_real_escape_string($db, $_POST['city']);
    $zip = mysqli_real_escape_string($db, $_POST['zip']);
    $country = mysqli_real_escape_string($db, $_POST['country']);

    // Additional Fields
    $status = isset($_POST['status']) ? mysqli_real_escape_string($db, $_POST['status']) : '';
    $transport_mode = isset($_POST['transport_mode']) ? mysqli_real_escape_string($db, $_POST['transport_mode']) : '';
    $boarding_point = isset($_POST['boarding_point']) ? mysqli_real_escape_string($db, $_POST['boarding_point']) : '';
    $bus_no = isset($_POST['busNo']) ? mysqli_real_escape_string($db, $_POST['busNo']) : '';
    $hostel_name = isset($_POST['hostel_name']) ? mysqli_real_escape_string($db, $_POST['hostel_name']) : '';
    $room_no = isset($_POST['room_no']) ? mysqli_real_escape_string($db, $_POST['room_no']) : '';

    // ID Fields
    $aicte_id = isset($_POST['aicte_id']) ? mysqli_real_escape_string($db, $_POST['aicte_id']) : '';
    $vidwan_id = isset($_POST['vidwan_id']) ? mysqli_real_escape_string($db, $_POST['vidwan_id']) : '';
    $anna_univ_id = isset($_POST['anna_univ_id']) ? mysqli_real_escape_string($db, $_POST['anna_univ_id']) : '';

    // Contact Information
    $official_contact = isset($_POST['official_contact']) ? mysqli_real_escape_string($db, $_POST['official_contact']) : '';
    $mobile = mysqli_real_escape_string($db, $_POST['mobile']);
    $pmobile = mysqli_real_escape_string($db, $_POST['pmobile']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $pemail = mysqli_real_escape_string($db, $_POST['pemail']);

    // Additional Information
    $blood = mysqli_real_escape_string($db, $_POST['blood']);
    $aadhar_num = isset($_POST['aadhar_num']) ? mysqli_real_escape_string($db, $_POST['aadhar_num']) : '';
    $pan_num = isset($_POST['pan_num']) ? mysqli_real_escape_string($db, $_POST['pan_num']) : '';
    $net = mysqli_real_escape_string($db, $_POST['net']);
    $set = mysqli_real_escape_string($db, $_POST['setexam']);

    // Retrieve Existing File Paths
    $query = "SELECT photo, aadhar, pan,netcer,setcer FROM basic WHERE id='$s'";
    $query_run = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($query_run);
    
    $existing_photo = $row['photo'];
    $existing_aadhar = $row['aadhar'];
    $existing_pan = $row['pan'];
    $existing_netcer = $row['netcer'];
    $existing_setcer = $row['setcer'];

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

  

    if (!empty($_FILES['netcer']['name'])) {
        $file_name4 = $_FILES['netcer']['name'];
        $file_tmp4 = $_FILES['netcer']['tmp_name'];
        $ext4 = pathinfo($file_name4, PATHINFO_EXTENSION);
        $file_name4 = $s . "." . $ext4;
        $filePath4 = "images/net/" . $file_name4;

        if (!empty($existing_netcer) && file_exists($existing_netcer)) {
            unlink($existing_netcer);
        }

        move_uploaded_file($file_tmp4, $filePath4);
    } else {
        $filePath4 = $existing_netcer;
    }

    if (!empty($_FILES['setcer']['name'])) {
        $file_name5 = $_FILES['setcer']['name'];
        $file_tmp5 = $_FILES['setcer']['tmp_name'];
        $ext5 = pathinfo($file_name5, PATHINFO_EXTENSION);
        $file_name5 = $s . "." . $ext5;
        $filePath5 = "images/set/" . $file_name5;

        if (!empty($existing_setcer) && file_exists($existing_setcer)) {
            unlink($existing_setcer);
        }

        move_uploaded_file($file_tmp5, $filePath5);
    } else {
        $filePath5 = $existing_setcer;
    }
    // Update Query
    $query = "UPDATE basic SET
        qualification = '$qualification',
        title='$title',
        fname='$fname',
        lname='$lname',
        photo='$filePath',
        gender='$gender',
        dob='$dob',
        age='$age',
        religion='$religion',
        social='$social',
        caste='$caste',
        ms='$ms',
        pim1='$pim1',
        paddress='$paddress',
        taddress='$taddress',
        state='$state',
        city='$city',
        zip='$zip',
        country='$country',
        status='$status',
        transport_mode='$transport_mode',
        boarding_point='$boarding_point',
        bus_no='$bus_no',
        hostel_name='$hostel_name',
        room_no='$room_no',
        aicte_id='$aicte_id',
        vidwan_id='$vidwan_id',
        anna_univ_id='$anna_univ_id',
        official_contact='$official_contact',
        mobile='$mobile',
        pmobile='$pmobile',
        email='$email',
        pemail='$pemail',
        blood='$blood',
        aadhar_num='$aadhar_num',
        aadhar='$filePath2',
        pan_num='$pan_num',
        pan='$filePath3',
        net='$net',
        netcer='$filePath4',
        setexam='$set',
        setcer='$filePath5'
        WHERE id='$s'";

    // Execute Query
    $query_run = mysqli_query($db, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'Details Updated Successfully'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Details Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}



if(isset($_POST['update_medical']))
{

	$sur = mysqli_real_escape_string($db, $_POST['sur']);
    $ins = mysqli_real_escape_string($db, $_POST['ins']);

    if($sur == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }
	

    $query = "UPDATE basic SET surgery='$sur',insurance='$ins' WHERE id='$s'";
    $query_run = mysqli_query($db, $query);


       if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Details Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Details Not Updated'
        ];
        echo json_encode($res);
        return;
    }
	
}

if(isset($_POST['update_pass']))
{

	$pass = mysqli_real_escape_string($db, $_POST['password']);

    if($pass == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }
	

    $query = "UPDATE faculty SET pass='$pass' WHERE id='$s'";
    $query_run = mysqli_query($db, $query);


       if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Password Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Details Not Updated'
        ];
        echo json_encode($res);
        return;
    }
	
}











if(isset($_POST['update_nominee']))
{

	$name = mysqli_real_escape_string($db, $_POST['name']);
	$type = mysqli_real_escape_string($db, $_POST['type']);
    $share = mysqli_real_escape_string($db, $_POST['share']);

    if($name == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }
	
$query2 = "SELECT * FROM nominee WHERE id='$s'";
    $query_run2 = mysqli_query($db, $query2);

    if(mysqli_num_rows($query_run2)== 0)
    {
        $query = "INSERT INTO nominee(id) VALUES('$s')";
		$query_run = mysqli_query($db, $query);
	}



    $query = "UPDATE nominee SET id='$s',name='$name',type='$type',share='$share' WHERE id='$s'";
    $query_run = mysqli_query($db, $query);


       if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Nominee Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Details Not Updated'
        ];
        echo json_encode($res);
        return;
    }
	
}




if(isset($_POST['save_student']))
{
	$errors= array();
	$course = mysqli_real_escape_string($db, $_POST['course']);
    $Degree = mysqli_real_escape_string($db, $_POST['degree']);
	$branch = mysqli_real_escape_string($db, $_POST['branch']);
    $iname = mysqli_real_escape_string($db, $_POST['name']);
    $board = mysqli_real_escape_string($db, $_POST['univ']);
	$state = mysqli_real_escape_string($db, $_POST['state']);
    $mos = mysqli_real_escape_string($db, $_POST['ms']);
    $mes = mysqli_real_escape_string($db, $_POST['mes']);
    $yc = mysqli_real_escape_string($db, $_POST['yc']);
	$cs = mysqli_real_escape_string($db, $_POST['cs']);
    $score = mysqli_real_escape_string($db, $_POST['score']);
    $cnum = mysqli_real_escape_string($db, $_POST['cnum']);
	$file_name = $_FILES['cert']['name'];
	$file_tmp =$_FILES['cert']['tmp_name'];
	$ext = pathinfo($file_name, PATHINFO_EXTENSION);
	//$file_ext=strtolower(end(explode('.',$_FILES['cert']['name'])));
	$file_name = $s.$course.".".$ext;
	$filePath="images/cert/".$file_name;
	//$cert= mysqli_real_escape_string($db, $_POST['cert']);
	
	if(empty($errors)==true){
         move_uploaded_file($file_tmp,"images/cert/".$file_name);
	
    if($Degree == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "INSERT INTO academic (id,course,Degree,branch,Iname,univ,state,mos,mes,yc,cs,score,cnum,cert) VALUES('$s','$course','$Degree','$branch','$iname','$board','$state','$mos','$mes','$yc','$cs','$score','$cnum','$filePath')";
    $query_run = mysqli_query($db, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Details added Successfully'
        ];
        echo json_encode($res);
        return;
    }}
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Details Not Created'
        ];
        echo json_encode($res);
        return;
    }
	
}


if(isset($_POST['update_student']))
{
	$errors= array();
    $student_id = mysqli_real_escape_string($db, $_POST['student_id']);

    $course = mysqli_real_escape_string($db, $_POST['course']);
    $Degree = mysqli_real_escape_string($db, $_POST['degree']);
	$branch = mysqli_real_escape_string($db, $_POST['branch']);
    $iname = mysqli_real_escape_string($db, $_POST['name']);
    $board = mysqli_real_escape_string($db, $_POST['univ']);
	$state = mysqli_real_escape_string($db, $_POST['state']);
    $mos = mysqli_real_escape_string($db, $_POST['ms']);
    $mes = mysqli_real_escape_string($db, $_POST['mes']);
    $yc = mysqli_real_escape_string($db, $_POST['yc']);
	$cs = mysqli_real_escape_string($db, $_POST['cs']);
    $score = mysqli_real_escape_string($db, $_POST['score']);
    $cnum = mysqli_real_escape_string($db, $_POST['cnum']);
	$file_name = $_FILES['cert']['name'];
	//$cert= mysqli_real_escape_string($db, $_POST['cert']);
    if($Degree == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }
	$query = "SELECT cert FROM academic WHERE uid='$student_id'";
    $query_run = mysqli_query($db, $query);
	$row = mysqli_fetch_assoc($query_run);
	$f=$row['cert'];

		if (file_exists($f)) 
					   {
						 unlink($f);
					   }

	$file_tmp =$_FILES['cert']['tmp_name'];
	$ext = pathinfo($file_name, PATHINFO_EXTENSION);
	$file_name = $s.$course.".".$ext;
	$filePath="images/cert/".$file_name;
	
	if(empty($errors)==true){
         move_uploaded_file($file_tmp,"images/cert/".$file_name);

    $query = "UPDATE academic  SET course='$course', Degree='$Degree',branch='$branch', iname='$iname', univ='$board',state='$state',mos='$mos',mes='$mes',yc='$yc',cs='$cs',score='$score',cnum='$cnum',cert='$filePath' WHERE uid='$student_id'";
    $query_run = mysqli_query($db, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Details Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }}
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Details Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['update_family']))
{

    $student_id = mysqli_real_escape_string($db, $_POST['student_id2']);

   	$name = mysqli_real_escape_string($db, $_POST['name']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $relationship = mysqli_real_escape_string($db, $_POST['relationship']);
    $mobile = mysqli_real_escape_string($db, $_POST['mobile']);
    if($name== NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }
	

    $query = "UPDATE family  SET name='$name', gender='$gender',relationship='$relationship', mobile='$mobile' WHERE uid='$student_id'";
    $query_run = mysqli_query($db, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Details Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Details Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}



if(isset($_GET['student_id']))
{
    $student_id = mysqli_real_escape_string($db, $_GET['student_id']);

    $query = "SELECT * FROM academic WHERE uid='$student_id'";
    $query_run = mysqli_query($db, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $student = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'details Fetch Successfully by id',
            'data' => $student
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'details Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}



if(isset($_GET['student_id2']))
{
    $student_id = mysqli_real_escape_string($db, $_GET['student_id2']);

    $query = "SELECT * FROM family WHERE uid='$student_id'";
    $query_run = mysqli_query($db, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $student = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'details Fetch Successfully by id',
            'data' => $student
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'details Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['delete_student']))
{
    $student_id = mysqli_real_escape_string($db, $_POST['student_id']);
	$query = "SELECT cert FROM academic WHERE uid='$student_id'";
    $query_run = mysqli_query($db, $query);
	$row = mysqli_fetch_assoc($query_run);
	$f=$row['cert'];
	//$filePath="images/cert/".$f;
		if (file_exists($f)) 
					   {
						 unlink($f);
					   }
    $query = "DELETE FROM academic  WHERE uid='$student_id'";
    $query_run = mysqli_query($db, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Details Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Details Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['save_family']))
{
	$name = mysqli_real_escape_string($db, $_POST['name']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $relationship = mysqli_real_escape_string($db, $_POST['relationship']);
    $mobile = mysqli_real_escape_string($db, $_POST['mobile']);
	
    if($name == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }
	
    $query = "INSERT INTO family (id,name,gender,relationship,mobile) VALUES('$s','$name','$gender','$relationship','$mobile')";
    $query_run = mysqli_query($db, $query);

       if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Details Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Details Not Updated'
        ];
        echo json_encode($res);
        return;
    }
	
}

if(isset($_POST['delete_family']))
{
    $student_id = mysqli_real_escape_string($db, $_POST['student_id3']);

    $query = "DELETE FROM family  WHERE uid='$student_id'";
    $query_run = mysqli_query($db, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Details Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Details Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}



?>