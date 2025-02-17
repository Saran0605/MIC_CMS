<html>
<head>
  <script src="jquery-3.3.1.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
 
</head>
</html>


<?php

require 'config.php';
include("session.php");


 $fid = mysqli_real_escape_string($db, $_POST['fid']);

	$query = "SELECT * FROM basic WHERE id='$fid'";
    $query_run = mysqli_query($db, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $student = mysqli_fetch_array($query_run);

		$photo=$student['photo'];

		$n=$student['fname'].' '.$student['lname'];
		$g=$student['gender'];
		$e=$student['email'];
		$d2=$student['dob'];
		$exp = explode('-', $d2);
		$newStr = trim($exp[2]) . ' - ' . trim($exp[1]). ' - ' . trim($exp[0]);
		$d= $newStr;
		$m=$student['mobile'];
		$a=$student['paddress'].','.$student['city'].'-'.$student['zip'];
	}

else{

$n=" ";
$g=" ";
$e=" ";
$d=" ";
$m=" ";
$a=" ";
}

	$query = "SELECT * FROM research WHERE id='$fid'";
    $query_run = mysqli_query($db, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $research = mysqli_fetch_array($query_run);
		$oid=$research['oid'];
		$sid=$research['sid'];
		$rid=$research['rid'];
		$gsid=$research['gsid'];
		$hid=$research['hid'];
		$iid=$research['iid'];
		$gi=$research['gi'];
		$cs=$research['cs'];
		$cgs=$research['cgs'];
	}

else{
		$oid="0000-0000";
		$sid="0000-0000";
		$rid="0000-0000";
		$gsid="0000-0000";
		$hid="0";
		$iid="0";
		$gi="0";
		$cs="0";
		$cgs="0";
}


	$query7 = "SELECT design,dept FROM faculty WHERE id='$fid'";
    $query_run7 = mysqli_query($db, $query7);
	if(mysqli_num_rows($query_run7) > 0){
	$row7 = mysqli_fetch_assoc($query_run7);
	$de=$row7['design'];
	$dep="Department of ".$row7['dept'];

	}


if($row7['dept']==$fdept)
{	

?>


<html dir="ltr" lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIC</title>
    <link rel="icon" type="image/png" sizes="32x32" href="image/icons/mkce_s.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-5/bootstrap-5.css" rel="stylesheet">
   

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>


<style>

.table thead tr {
            background: linear-gradient(135deg, #4CAF50, #2196F3);
        }

        .table thead th {
            color: white;
            font-weight: 600;
            border: none;
        }

        .export-buttons {
            margin: 20px 0;
            text-align: right;
            padding: 0 15px;
        }

        .btn-export {
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s;
            margin-left: 10px;
        }

        .btn-pdf {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .btn-pdf:hover {
            background-color: #c82333;
            transform: translateY(-1px);
        }

        .profile-section {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
      body {

        color: #1a202c;
        text-align: left;
        background-color: #e2e8f0;
      }

.main-body {
    padding: 15px;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}
.gradient-header {
            --bs-table-bg: transparent;
            --bs-table-color: white;
            background: linear-gradient(135deg, #4CAF50, #2196F3) !important;

            text-align: center;
            font-size: 0.9em;
        }

</style>


</head>

<body>

 
<div class="container-fluid">
<div class="export-buttons">
            <button class="btn btn-export btn-pdf" onclick="exportToPDF()">
                <i class="fas fa-file-pdf"></i> Download PDF
            </button>
        </div>
		<div class="main-body">
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                   <!-- <img src=".\assets\images\profile\1152018.jpg" alt="Admin" class="rounded-circle" width="150"> -->
					<img src="<?php echo $photo; ?>" alt="" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4><?php echo $n; ?></h4>
                      <p class="text-secondary mb-1"><?php echo $de;?></p>
                      <p class="text-muted font-size-sm"><?php echo $dep;?></p>
                     
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">ORCID</h6>
                    <span class="text-secondary"> <?php echo $oid; ?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Scopus ID</h6>
                    <span class="text-secondary"> <?php echo $sid; ?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Researcher ID</h6>
                    <span class="text-secondary"> <?php echo $rid; ?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Google Scholar ID</h6>
                    <span class="text-secondary"> <?php echo $gsid; ?></span>
                  </li>
				  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">H-Index</h6>
                    <span class="text-secondary"> <?php echo $hid; ?></span>
				<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">i10-Index</h6>
                    <span class="text-secondary"> <?php echo $iid; ?></span>
                  </li>
				                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">G-Index</h6>
                    <span class="text-secondary"> <?php echo $gi; ?></span>
                  </li>
				  				                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Citations Scopus</h6>
                    <span class="text-secondary"> <?php echo $cs; ?></span>
                  </li>
				  				                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Citations Google Scholar</h6>
                    <span class="text-secondary"> <?php echo $cgs; ?></span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $n; ?>
                    </div>
                  </div>
                  <hr>
				  
				    <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Gender</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $g; ?>
                    </div>
                  </div>
                  <hr>
				  
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $e; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">	Date of Birth</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $d; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Mobile</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $m; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      	<?php echo $a; ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row gutters-sm">
                <div class="col-sm-12 mb-3">
                  <div class="card h-100">
                    <div class="card">
                            <div class="card-body">
                                <h5 class="card-title m-b-0">Qualification</h5>
                            </div>
                            <table class="table">
                                 <thead class="gradient-header">
                                    <tr>
                                        <th scope="col"><b>Course</b></th>
                                        <th scope="col"><b>Institutions</b></th>
                                        <th scope="col"><b>Year</b></th>
                                    </tr>
                                </thead>
								<?php
								$records = mysqli_query($db,"select *from academic where id='$fid'");
								while($data = mysqli_fetch_array($records))
								{
									?>
                                <tbody>
                                    <tr>
                                        <td><?php echo $data['course']; ?></td>
                                        <td><?php echo $data['iname']; ?></td>
                                        <td><?php echo $data['yc']; ?></td>
                                    </tr>
                                </tbody>
								<?php } ?>
                            </table>
                        </div>
                  </div>
                </div>
              </div>



            </div>

					<!-- family Start -->
			
			<div class="col-sm-12 mb-3">
			<div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Family Details</h5>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                         <thead class="gradient-header">
                                            <tr>
                                                <th><b>S.No</b></th>
												<th><b>Name</b></th>
												<th><b>Relationship</b></th>
												<th><b>Mobile</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$query2 = "SELECT * FROM family where id='$fid'";
										$query_run2 = mysqli_query($db, $query2);

										if(mysqli_num_rows($query_run2) > 0)
										{
											$sn=1;
											foreach($query_run2 as $student2)
											{
                                    ?>

                                            <tr>
                                                <td><?php echo $sn;?></td>
												 <td><?= $student2['name'] ?></td> 
												 <td><?= $student2['relationship'] ?></td>
												  <td><?= $student2['mobile'] ?></td>

                                                
										
										</td>
                                                
                                            </tr>

                                     <?php
									 $sn=$sn+1;
											}
												
                            }
                            ?>
                                                

                                        
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
						</div>
						
						<!-- family end -->
			
						<!-- exp Start -->
			
			<div class="col-sm-12 mb-3">
			<div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Experience Details</h5>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                         <thead class="gradient-header">
                                            <tr>
                                                <th><b>S.No</b></th>
												<th><b>Institution/Corporate Name</b></th>
												<th><b>Designation</b></th>
												<th><b>From</b></th>
												<th><b>To</b></th>
												<th><b>Duration</b></th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$query = "SELECT * FROM exp where id='$fid'";
                            $query_run = mysqli_query($db, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                foreach($query_run as $student)
                                {
									
									if($student['tod']=="0000-00-00")
										{
											$ssss= "Current";
										}
										
										else
										{
										$ssss= $student['tod'];
										}
									
                                    ?>
                                    <tr>
                                        <td><?= $student['type'] ?></td>
                                        <td><?= $student['iname'] ?></td>
                                        <td><?= $student['design'] ?></td>
                                        <td><?= $student['fromd'] ?></td>
                                        <td><?php echo $ssss; ?></td>
										<td><?= $student['exp'] ?></td>
										
                                    </tr>
				
                                    <?php
                                }
                            }
                            ?>
                                                

                                        
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
						</div>
						
						<!-- exp end -->
			
			<!-- posting Start -->
			
			<div class="col-sm-12 mb-3">
			<div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Posting Details</h5>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                         <thead class="gradient-header">
                                            <tr>
                                                <th><b>S.No</b></th>
												<th><b>Level</b></th>
												<th><b>Posting Name</b></th>
												<th><b>From</b></th>
												<th><b>To</b></th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
                            

                            $query = "SELECT * FROM posting where id='$fid'";
                            $query_run = mysqli_query($db, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
								$sn=1;
                                foreach($query_run as $student)
                                {
									if($student['tod']=="0000-00-00")
										{
											$sss= "Current";
										}
										
										else
										{
										$sss= $student['tod'];
										}
									
                                    ?>
                                    <tr>
                                        <td><?= $sn ?></td>
                                        <td><?= $student['level'] ?></td>
										<td><?= $student['pname']?></td>
										<td><?= $student['fromd']?></td>
										<td><?php echo $sss; ?></td>
		
                                       
                                    </tr>
                                    <?php
									$sn=$sn+1;
                                }
								
                            }
                            ?>
                                                

                                        
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
						</div>
						
						<!-- posting end -->
						
						
		<!-- Training Start -->
			
			<div class="col-sm-12 mb-3">
			<div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Training Details</h5>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                         <thead class="gradient-header">
                                            <tr>
                                                <th><b>S.No</b></th>
												<th><b>Type of Training</b></th>
												<th><b>Name of the organization</b></th>
												<th><b>Title</b></th>
												<th><b>From</b></th>
												<th><b>To</b></th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
		
                            $query = "SELECT * FROM training where id='$fid'";
                            $query_run = mysqli_query($db, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
								$s=1;
                                foreach($query_run as $student)
                                {
									
                                    ?>
                                    <tr>
                                        <td><?= $s ?></td>
                                        <td><?= $student['type'] ?></td>
                                        <td><?= $student['no'] ?></td>
                                        <td><?= $student['name'] ?></td>
										 <td><?= $student['fromd'] ?></td>
										 <td><?= $student['tod'] ?></td>
										
                                    </tr>
                                    <?php
									$s=$s+1;
                                }
                            }
                            ?>
                                                

                                        
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
						</div>
						
						<!-- training end -->
		
		
		
		
		
		
		
		
		
		
		
		
		
		
			
          </div>

        </div>
		</div>
	           
    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
        $('#zero_config').DataTable();
        function exportToPDF() {
    if (typeof html2canvas === 'undefined' || typeof jspdf === 'undefined') {
        Swal.fire({
            icon: 'error',
            title: 'Library Missing',
            text: 'PDF generation libraries are not loaded. Please refresh the page and try again.',
        });
        return;
    }

    Swal.fire({
        title: 'Generating PDF...',
        text: 'Please wait while we prepare your document',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const contentElement = document.querySelector('.main-body');
    
    const options = {
        scale: 2,
        useCORS: true,
        logging: false,
        allowTaint: true,
        backgroundColor: '#ffffff'
    };
    
    html2canvas(contentElement, options).then(canvas => {
        try {
            const { jsPDF } = jspdf;
            
            const pdf = new jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4'
            });

            // Define margins (in mm)
            const margin = {
                top: 20,
                bottom: 20,
                left: 20,
                right: 20
            };

            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();
            
            // Calculate dimensions while maintaining aspect ratio
            const imgWidth = pageWidth - margin.left - margin.right;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            
            let heightLeft = imgHeight;
            let position = margin.top;

            // Add first page content
            pdf.addImage(
                canvas.toDataURL('image/jpeg', 1.0),
                'JPEG',
                margin.left,
                margin.top,
                imgWidth,
                imgHeight
            );

            // Add subsequent pages if needed
            while (heightLeft >= pageHeight) {
                position = -(pageHeight - margin.top);
                heightLeft -= pageHeight;

                pdf.addPage();
                pdf.addImage(
                    canvas.toDataURL('image/jpeg', 1.0),
                    'JPEG',
                    margin.left,
                    position,
                    imgWidth,
                    imgHeight
                );
            }

            // Generate filename
            const facultyName = document.querySelector('.card-body h4')?.textContent || 'faculty';
            const cleanName = facultyName.trim().replace(/\s+/g, '-').toLowerCase();
            const filename = `${cleanName}-profile-${new Date().toISOString().split('T')[0]}.pdf`;
            
            pdf.save(filename);
            Swal.close();
            
            Swal.fire({
                icon: 'success',
                title: 'PDF Generated',
                text: 'Your document has been created successfully.',
                timer: 2000
            });
            
        } catch (error) {
            console.error('PDF generation error:', error);
            Swal.fire({
                icon: 'error',
                title: 'PDF Generation Failed',
                text: 'There was an error creating your PDF. Please try again later.',
            });
        }
    }).catch(error => {
        console.error('Canvas generation error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to capture the page content. Please try again.',
        });
    });
}
    </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


</body>

</html>
<?php
}

else
	
	{
		?>
		<script>
							
							swal.fire({
									icon: 'error',
									title: 'Faculty Not Found',
									text: 'Note : You can view your department faculty only'
					});
							</script>
		
<?php		
	}
?>