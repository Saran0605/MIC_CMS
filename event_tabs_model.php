<div class="modal fade" id="viewPdfModal" tabindex="-1" role="document" aria-labelledby="viewPdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPdfModalLabel">View PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body" id="viewPdfModalBody">

                </div>
            </div>
        </div>
    </div>
   

     <!--Org preevent -->
    <div class="modal fade" id="preEventOrg_Model" tabindex="-1" aria-labelledby="preEventOrg_ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="preEventOrg_ModalLabel">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="preEventOrg_Form">
                    <div class="modal-body">
                        <div id="errorMessage" class="alert alert-warning d-none"></div>
                        <div class="mb-3">
                            <label for="event">Organizer *</label>
                            <input type="text" name="organizer" class="form-control" placeholder="OrganizerName" required>
                        </div>
                        <div class="mb-3">
                            <label for="event">Designation *</label>
                            <input type="text" name="designation" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="event">Event Type *</label>
                            <select id="eventSelect" class="select2 form-control custom-select" name="event_type" style="width: 100%; height:36px;" required>
                                <option value="">Select</option>
                                <option value="Alumni">Alumni</option>
                                <option value="Club Activity">Club Activity</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Conference">Conference</option>
                                <option value="Professional Development">Professional Development</option>
                                <option value="Research & Development">Research & Development</option>
                                <option value="Sports Event">Sports Event</option>
                                <option value="Symposium">Symposium</option>
                                <option value="Hackathon">Hackathon</option>
                                <option value="Seminar">Seminar</option>
                                <option value="STTP">STTP</option>
                                <option value="ProjectExpo">ProjectExpo</option>
                                <option value="Makeathon">Makeathon</option>
                                <option value="Codeathon">Codeathon</option>
                                <option value="Webinar">Webinar</option>
                                <option value="Quiz">Quiz</option>
                                <option value="online course">Online Course</option>
                                <option value="Guest Lecture ">Guest Lecture </option>
                                <option value="FDP ">FDP </option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3" id="otherEventInput" style="display:none;">
                            <label for="otherEvent">Please specify:</label>
                            <input type="text" class="form-control" id="otherEvent" name="other_event" placeholder="Enter event name">
                        </div>
                        <div class="mb-3">
                            <label for="event">Event Name *</label>
                            <input type="text" name="eventname" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="dept">Department *</label>
                            <select class="select2 form-control custom-select" name="dept" style="width: 100%; height:36px;" required>
                                <option value="">Select</option>
                                <option value="Artificial Intelligence and Data Science">Artificial Intelligence and Data Science</option>
                                <option value="Artificial Intelligence and Machine Learning">Artificial Intelligence and Machine Learning</option>
                                <option value="Civil Engineering">Civil Engineering</option>
                                <option value="Computer Science and Business Systems">Computer Science and Business Systems</option>
                                <option value="Computer Science and Engineering">Computer Science and Engineering</option>
                                <option value="Electrical and Electronics Engineering">Electrical and Electronics Engineering</option>
                                <option value="Freshmen Engineering">Freshmen Engineering</option>
                                <option value="Electronics and Communication Engineering">Electronics and Communication Engineering</option>
                                <option value="Information Technology">Information Technology</option>
                                <option value="Mechanical Engineering">Mechanical Engineering</option>
                                <option value="Master of Business Administration">Master of Business Administration</option>
                                <option value="Master of Computer Applications">Master of Computer Applications</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="academia">Academic Year *</label>
                            <select class="select2 form-control custom-select" id="AcademiaYear" name="academia" required>
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="venue">Venue *</label>
                            <input type="text" name="venue" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="from">Start of Event *</label>
                            <input type="date" id="fromDate" name="starting_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="to">End of Event *</label>
                            <input type="date" id="toDate" name="ending_date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="total">Total Days</label>
                            <input type="text" id="count" name="total" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="chief_guest">Chief Guest *</label>
                            <input type="text" name="chief_guest" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="uploadChiefGuest">About Chief Guest*</label>
                            <label for="">(upload PDF less than 2 MB)</label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdf1" id="uploadChiefGuest" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">
                                <label class="custom-file-label" for="uploadChiefGuest" id="chiefGuestLabel">Choose file</label>
                            </div>
                            <p id="chiefGuestError"></p>
                        </div>
                        <div class="mb-3">
                            <label for="uploadChiefGuest">Event Brochure*</label>
                            <label for="">(upload PDF less than 2 MB)</label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdf3" id="uploadChiefGuest" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">
                                <label class="custom-file-label" for="uploadChiefGuest" id="chiefGuestLabel">Choose file</label>
                            </div>
                            <p id="chiefGuestError"></p>
                        </div>
                        <div class="mb-3">
                            <label>Fund</label>
                            <label class="toggle-switch">
                                <input type="checkbox" id="fundSwitch">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="mb-3 fund-amount-group">
                            <label for="uploadChiefGuest">Fund Details*</label>
                            <label for="">(upload PDF less than 2 MB)</label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdf2" id="uploadChiefGuest" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">
                                <label class="custom-file-label" for="uploadChiefGuest" id="chiefGuestLabel">Choose file</label>
                            </div>
                            <p id="chiefGuestError"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Org postevent -->
    <div class="modal fade" id="postEventOrg_Modal" tabindex="-1" aria-labelledby="postEventOrg_Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postEventOrg_Label">Post Event Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="postEventOrg_Form">
                    <div class="modal-body">
                        <div id="postEventOrgErrorMessage" class="alert alert-warning d-none"></div>
                        <div class="mb-3">
                            <input type="hidden" name="id" id="id" class="form-control" placeholder="" value="">
                        </div>
                        <div class="mb-3">
                            <label for="uploadDescription">Approval Letter *</label>
                            <label for="">(upload PDF less than 2 MB)</label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdf[]" id="uploadDescription" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">
                                <label class="custom-file-label" for="uploadDescription" id="descriptionLabel">Choose file</label>
                            </div>
                            <p id="descriptionError"></p>
                        </div>
                        <div class="mb-3">
                            <label for="uploadDescription">Sanctioned Letter </label>
                            <label for="">(upload PDF less than 2 MB)</label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdf[]" id="uploadDescription" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">
                                <label class="custom-file-label" for="uploadDescription" id="descriptionLabel">Choose file</label>
                            </div>
                            <p id="descriptionError"></p>
                        </div>
                        <div class="mb-3">
                            <label for="uploadDescription">Participants Attendance*</label>
                            <label for="">(upload PDF less than 2 MB)</label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdf[]" id="uploadDescription" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">
                                <label class="custom-file-label" for="uploadDescription" id="descriptionLabel">Choose file</label>
                            </div>
                            <p id="descriptionError"></p>
                        </div>
                        <div class="mb-3">
                            <label for="uploadDescription">Geo-Tagged photo*</label>
                            <label for="">(upload PDF less than 2 MB)</label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdf[]" id="uploadDescription" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">
                                <label class="custom-file-label" for="uploadDescription" id="descriptionLabel">Choose file</label>
                            </div>
                            <p id="descriptionError"></p>
                        </div>
                        <div class="mb-3">
                            <label for="uploadDescription">Student Feedback*</label>
                            <label for="">(upload PDF less than 2 MB)</label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdf[]" id="uploadDescription" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">
                                <label class="custom-file-label" for="uploadDescription" id="descriptionLabel">Choose file</label>
                            </div>
                            <p id="descriptionError"></p>
                        </div>
                        <div class="mb-3">
                            <label for="uploadDescription">Fund Details*</label>
                            <label for="">(upload PDF less than 2 MB)</label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdf[]" id="uploadDescription" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">
                                <label class="custom-file-label" for="uploadDescription" id="descriptionLabel">Choose file</label>
                            </div>
                            <p id="descriptionError"></p>
                        </div>
                        <div class="mb-3">
                            <label for="uploadDescription">Report Summary*</label>
                            <label for="">(upload PDF less than 2 MB)</label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdf[]" id="uploadDescription" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">
                                <label class="custom-file-label" for="uploadDescription" id="descriptionLabel">Choose file</label>
                            </div>
                            <p id="descriptionError"></p>
                        </div>
                        <div class="mb-3">
                            <label for="uploadDescription">Analysis report *</label>
                            <label for="">(upload PDF less than 2 MB)</label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdf[]" id="uploadDescription" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">
                                <label class="custom-file-label" for="uploadDescription" id="descriptionLabel">Choose file</label>
                            </div>
                            <p id="descriptionError"></p>
                        </div>
                        <!-- Table for Weaknesses, Challenges, and Opportunities -->
                        <label>Feedback report *</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="custom-width">Weakness Identified</th>
                                    <th class="custom-width">Recommendations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <textarea class="form-control" id="weaknessIdentified" rows="3" placeholder="Enter weaknesses identified" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="weaknessRecommendations" rows="3" placeholder="Enter recommendations" required></textarea>
                                    </td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th class="custom-width">Challenges Identified</th>
                                    <th class="custom-width">Recommendations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <textarea class="form-control" id="challengesIdentified" rows="3" placeholder="Enter challenges identified" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="challengeRecommendations" rows="3" placeholder="Enter recommendations" required></textarea>
                                    </td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th class="custom-width">Opportunities Identified</th>
                                    <th class="custom-width">Recommendations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <textarea class="form-control" id="opportunitiesIdentified" rows="3" placeholder="Enter opportunities identified" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="opportunityRecommendations" rows="3" placeholder="Enter recommendations" required></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

      <!--Parti preevent -->

    <div class="modal fade" id="add_preEvent_parti" tabindex="-1" role="dialog" aria-labelledby="add_preEvent_parti_Label" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_preEvent_parti_Label">Add Event Details</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="add_preEvent_parti_form">
                    <div class="modal-body">
                        <div id="errorMessage" class="alert alert-warning d-none"></div>
                        <div class="mb-3">
                            <label for="name">Staff Name *</label>
                            <input type="text" name="staff_name" class="form-control" placeholder="staff name" required="">
                        </div>
                        <div class="mb-3">
                            <label for="designation">Designation *</label>
                            <input type="text" name="designation" class="form-control" placeholder="designation" required="">
                        </div>
                        <div class="mb-3">
                            <label for="Department">Department *</label>
                            <select class="select2 form-control custom-select" name="department" style="width: 100%; height:36px;" required>
                                <option value="">Select</option>
                                <option value="Artificial Intelligence and Data Science">Artificial Intelligence and Data Science</option>
                                <option value="Artificial Intelligence and Machine Learning">Artificial Intelligence and Machine Learning</option>
                                <option value="Civil Engineering">Civil Engineering</option>
                                <option value="Computer Science and Business Systems">Computer Science and Business Systems</option>
                                <option value="Computer Science and Engineering">Computer Science and Engineering</option>
                                <option value="Electrical and Electronics Engineering">Electrical and Electronics Engineering</option>
                                <option value="Freshmen Engineering">Freshmen Engineering</option>
                                <option value="Electronics and Communication Engineering">Electronics and Communication Engineering</option>
                                <option value="Information Technology">Information Technology</option>
                                <option value="Mechanical Engineering">Mechanical Engineering</option>
                                <option value="Master of Business Administration">Master of Business Administration</option>
                                <option value="Master of Computer Applications">Master of Computer Applications</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="event_type">Event Type *</label>
                            <select class="form-control select-arrow" id="event_type1" name="event_type" required>
                                <option value="">Select</option>
                                <option value="Conference">Conference</option>
                                <option value="FDP">FDP</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Others">Others</option>


                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="event_name">Event Name *</label>
                            <input type="text" name="event_name" class="form-control" placeholder="event name" required="">
                        </div>
                        <div class="mb-3">
                            <label for="organizer_name">Event Organizer *</label>
                            <input type="text" name="organizer_name" class="form-control" placeholder="organizer name" required="">
                        </div>
                        <div class="mb-3">
                            <label for="Academia Year">Academic Year *</label>
                            <select class="form-control" name="academic_year" id="academic_year" required="">
                                <option value="">Select Year</option>

                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="venue">Venue *</label>
                            <input type="text" name="venue" class="form-control" required="">
                        </div>
                        <div class="mb-3">
                            <label for="start_date">From *</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="end_date">To *</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="no_of_days">Number of Days </label>
                            <input type="text" name="no_of_days" id="no_of_days" class="form-control" readonly>
                        </div>

                        <div class="mb-3 ">
                            <label for="event_broucher">Event Broucher *</label>
                            <label for="">(upload PDF less than 2 MB)</label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="event_broucher" id="event_broucher" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend" required="">
                                <label class="custom-file-label" for="event_broucher" id="event_broucherLabel">Choose file</label>
                            </div>
                            <p id="event_broucher_err"></p>
                        </div>


                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="add_postEvent_parti" tabindex="-1" role="dialog" aria-labelledby="add_postEvent_parti_Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_postEvent_parti_Label">Add Event Details</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="add_postEvent_parti_form">
                    <div class="modal-body">
                        <div id="errorMessage" class="alert alert-warning d-none"></div>
                        <div class="mb-3">
                            <input type="hidden" name="id" id="id" class="form-control" placeholder="" value="">
                        </div>


                        <div class="mb-3 ">
                            <label for="approved_copy">Approved Copy*</label>
                            <label for="">(upload PDF less than 2 MB)</label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdfs[]" id="approved_copy" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">
                                <label class="custom-file-label" for="approved_copy" id="approved_copyLabel">Choose PDF</label>
                            </div>
                            <p id="approved_copy_err"></p>
                        </div>
                        <div class="mb-3 ">
                            <label for="event_documentation">Event Documentation*</label>
                            <label for=""></label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdfs[]" id="event_documentation" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">
                                <label class="custom-file-label" for="event_documentation" style=" color: #737171;" id="event_documentationLabel">Choose PDF(Broucher, Geo-tagged photo)</label>
                            </div>
                            <p id="event_documentation_err"></p>
                        </div>
                        <div class="mb-3 ">
                            <label for="participation_certificate">Participation Certificate*</label>
                            <label for=""></label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdfs[]" id="participation_certificate" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">
                                <label class="custom-file-label" for="participation_certificate" style=" color: #737171;" id="participation_certificateLabel">Choose PDF (Participation, Attendance Certificate)</label>
                            </div>
                            <p id="participation_certificate_err"></p>
                        </div>

                        <div class="mb-3">
                            <label>Claim Status</label>
                            <label class="toggle-switch">
                                <input type="checkbox" id="claim_form_status">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="mb-3 claim_form_field">
                            <label for="claim_form">Claim Form*</label>
                            <label for=""></label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdfs[]" id="claim_form" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">
                                <label class="custom-file-label" for="claim_form" style=" color: #737171;" id="claim_formLabel">Choose PDF</label>
                            </div>
                            <p id="claimform_err"></p>
                        </div>
                        <div class="mb-3 ">
                            <label for="report_summary">Report Summary*</label>
                            <label for=""></label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdfs[]" id="report_summary" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">
                                <label class="custom-file-label" for="report_summary" style=" color: #737171;" id="report_summaryLabel">Choose PDF</label>
                            </div>
                            <p id="report_summary_err"></p>
                        </div>
                        <div class="mb-3 ">
                            <label for="kss_report_summary">KSS Report Summary*</label>
                            <label for=""></label> <br>
                            <div class="input-group">
                                <input type="file" class="form-control custom-file-input" name="pdfs[]" id="_kss_report_summary" accept=".pdf" onchange="fileValidation(this)" aria-describedby="inputGroupPrepend">
                                <label class="custom-file-label" for="kss_report_summary" style=" color: #737171;" id="kss_report_summaryLabel">Choose PDF (Geo-tagged Photo, KSS, Attendance Report)</label>
                            </div>
                            <p id="kss_report_summary_err"></p>
                        </div>
                        <div class="mb-3 ">
                            <br>
                            <label for="kss_report_summary"><b>* </b> Upload PDF less than 2 MB</label><br>
                            <label for=""><b>* </b> Merge and Upload Required Files as One PDF </label> <br>

                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>


            </div>
        </div>
    </div>


    <div class="modal fade" id="expense_claim_form" tabindex="-1" role="dialog" aria-labelledby="expenseClaimFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="expenseClaimFormLabel">Expense Claim Form</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>

                <!-- Form Starts -->
                <form id="claim_form_new">
                    <div class="modal-body">
                        <!-- Category and Hidden Input -->
                        <input type="hidden" name="id1" id="id1" class="form-control">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="category1" class="form-label">Select Category</label>
                                <select class="form-control select-arrow" id="category" name="category1" required>
                                    <option value="">Select</option>
                                    <option value="Mkce">Mkce</option>
                                    <option value="Mess">Mess</option>
                                    <option value="Hostel">Hostel</option>
                                    <option value="Trust">Trust</option>
                                </select>
                            </div>
                        </div>

                        <!-- Event Details -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="event_date" class="form-label">Event Date</label>
                                <input type="text" name="event_date" class="form-control" id="claim_event_date" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="event_name" class="form-label">Event Name</label>
                                <input type="text" name="event_name" class="form-control" id="claim_event_name" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="event_amount" class="form-label">Amount</label>
                                <input type="number" name="event_amount" class="form-control">
                            </div>
                        </div>

                        <!-- Expense Type and Add Button -->
                        <div class="row mt-4 align-items-end">
                            <div class="col-md-6">
                                <label for="expenseType" class="form-label">Expense Type</label>
                                <select id="expenseType" name="expense_type" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Travel">Travel</option>
                                    <option value="Food">Food</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="addRow" class="btn btn-success w-100">+ Add Row</button>
                            </div>
                        </div>

                        <!-- Expense Table -->
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered" id="expenseTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Bill No</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic rows will be added here -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Grand Total -->
                        <h6 class="mt-4">Grand Total</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Advance Amount Received</th>
                                        <th>Amount Spent</th>
                                        <th>Balance Amount to be Received/Refunded</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="number" name="advance_amount" id="advance_amount" class="form-control"></td>
                                        <td><input type="number" name="amount_spent" id="amount_spent" class="form-control" readonly></td>
                                        <td><input type="number" name="balance_amount" id="balance_amount" class="form-control" readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- File Upload -->
                        <!-- <div class="form-group mt-4">
                        <label for="claim_proof_certificate" class="form-label">Upload Participation Certificate*</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="participation_certificate" id="claim_proof1_certificates" accept=".pdf" onchange="fileValidation(this)">
                            <label class="custom-file-label" for="claim_proof">Choose PDF File</label>
                        </div>
                        <small class="form-text text-muted">Only PDF files allowed.</small>
                        <p id="claim_proof_err" class="text-danger"></p>
                    </div>-->
                    </div>

                    <!-- Footer Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <!-- Form Ends -->
            </div>
        </div>
    </div>
  