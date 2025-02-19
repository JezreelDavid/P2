<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="assets/CSS/styless.css">
    <link rel="icon" href="assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marriage</title>
    <link rel="stylesheet" href="assets/CSS/bootstrap.min.css">
    <link href="assets/CSS/bootstrap-datepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/CSS/jquery.datetimepicker.css">
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">



</head>
<style>
    .custom-button {
        background-color: #8BECEC;
        color: black;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        font-weight: 800;
    }

    .form-section {
        display: none;
    }

    .form-section.active {
        display: block;
    }

    .row button {
        width: 100px;
        /* Set the width to the desired value */
        padding: 10px 15px;
        font-size: 14px;
        margin-right: 10px;
        font-family: 'Montserrat', sans-serif;

    }

    .row {
        display: flex;
        justify-content: center;
    }

    .form-box {
        border: 2px solid #ccc;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-left: 20px;
        /* Adjust the margin as needed */
    }

    .form-title {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: left;
        color: #333;
        position: relative;
        padding-bottom: 10px;

    }

    .form-title::before {
        content: '';
        position: absolute;
        width: 260px;
        height: 4px;
        background-color: #007bff;
        bottom: 0;
        left: 0;
    }

    .form-title {
        font-size: 32px;
        font-family: 'Arial', sans-serif;
        /* Change the font-family here */
        font-weight: bold;
        margin-bottom: 20px;
        text-align: left;
        color: #333;
        position: relative;
        padding-bottom: 10px;
    }

    .btn-info.text-light:hover,
    .btn-info.text-light:focus {
        background: #000;
    }

    .short-btn {
        width: 30px;
        /* Adjust the width as needed */
        white-space: nowrap;
        /* Prevent text wrapping */
        overflow: hidden;
        /* Hide overflowed content */
        text-overflow: ellipsis;
        /* Display an ellipsis (...) when text overflows */
    }



    .main-content {
        overflow-y: auto;
        height: 100vh;
    }

    a {
        text-decoration: none;
        display: inline-block;
        padding: 8px 16px;
    }

    a:hover {
        background-color: #AFEB38;
        color: black;
    }

    .previous {
        background-color: #931E04;
        color: white;
    }

    .next {
        background-color: #106497;
        color: white;
    }

    .round {
        border-radius: 50%;
    }

    body {
        font-family: Arial, sans-serif;
    }


    .requirement {
        margin-bottom: 15px;
    }

    .requirement label {
        display: block;
        margin-bottom: 5px;
    }

    .requirement input[type="file"] {
        padding: 5px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    /* Style for the required asterisk */
    .requirement span {
        color: red;
    }
</style>

<body>
    <div class="main-container">
            <div class="main-content">
                <div class="top-bar">
                    <div class="profile">
                        <span>MARRIAGE</span>
                        <div>
                                                            <img src="assets/img/picture_data/" alt="Profile Image" id="profile">
                                                    </div>
                    </div>
                </div>

                <div class="container py-5" id="page-container">

                                        
                        <div class="container py-5" id="page-container">
                            <div class="col-sm-12">
                                <div class="form-box">
                                    <div class="form-title">DIOCESAN MARRIAGE FORM <img src="assets/img/logo.png" alt="Company Logo" width="100" height="150" style="float: right;"></div>
                                    <a href="client_dashboard.php" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Back</a>
                                    <form action="marriageformconnect.php" method="POST" enctype="multipart/form-data">
										<div class="form-group">
										<div class="form-group">
                                        <!-- Section 1: Update Section 1 content as needed -->
                                        <div class="form-section active" id="section-1">
                                            <h4>Section 1: Personal Details</h4>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h6><b>Groom Information:</b></h6>
                                                    <hr style="height: 1px; border: none; background-color: #333;">
                                                </div>
                                                <div class="col-sm-6">
                                                    <h6><b>Bride Information:</b></h6>
                                                    <hr style="height: 1px; border: none; background-color: #333;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Full Name:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mhname" id="mhname" required placeholder="(ex. Juan D. Cruz)" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Full Name:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mwname" id="mwname" required placeholder="(ex. Anne C. Torres)" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Date of Birth:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mhbirth" required placeholder="Date of Birth" id="mhbirth" class="form-control pinaganak" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Date of Birth:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mwbirth" required placeholder="Date of Birth" id="mwbirth" class="form-control pinaganak" />
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Place of Birth:<span style='color:red'> *</span></label>
                                                    <input type="text" class="form-control" name="mhpbirth" id="mhpbirth" required placeholder="Place of Birth" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Place of Birth:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mwpbirth" id="mwpbirth" required placeholder="Place of Birth" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Citizenship:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mhciti" id="mhciti" required placeholder="(ex. Filipino)" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Citizenship:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mwciti" id="mwciti" required placeholder="(ex. Filipino)" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Gender:<span style='color:red'> *</span></label>
                                                    <select name="mhsex" id="mhsex" required class="form-control">
                                                        <option value="" disabled selected>Select Gender</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Gender:<span style='color:red'> *</span></label>
                                                    <select class="form-control" name="mwsex" id="mwsex" required>
                                                        <option value="" disabled selected>Select Gender</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Male">Male</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Residence:<span style='color:red'> *</span></label>
                                                    <input type="text" class="form-control" name="mhresidence" id="mhresidence" required placeholder="Residence" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Residence:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mwresidence" id="mwresidence" required placeholder="Residence" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Religion:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mhreligion" id="mhreligion" required placeholder="(ex. Roman Catholic)" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Religion:<span style='color:red'> *</span></label>
                                                    <input type="text" class="form-control" name="mwreligion" id="mwreligion" required placeholder="(ex. Catholic)" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Civil Status:<span style='color:red'> *</span></label>
                                                    <select name="mhstatus" id="mhstatus" required class="form-control" onchange="selectSameCivilStatus(this)">
                                                        <option value="">Select Civil Status</option>
                                                        <option value="Single">Single</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Divorced">Divorced</option>
                                                        <option value="Widowed">Widowed</option>
                                                        <option value="Separated">Separated</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Civil Status:<span style='color:red'> *</span></label>
                                                    <select name="mwstatus" id="mwstatus" required class="form-control">
                                                        <option value="">Select Civil Status</option>
                                                        <option value="Single">Single</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Divorced">Divorced</option>
                                                        <option value="Widowed">Widowed</option>
                                                        <option value="Separated">Separated</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
										<br>
                                            <h4>Section 2: Parents Details</h4>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h6>Groom Parent Information:</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h6>Bride Parent Information:</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Father's Full Name:<span style='color:red'> *</span></label>
                                                    <input type="text" class="form-control" name="mhnamefather" id="mhnamefather" required placeholder="(ex. Jose A. Cruz)" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Father's Full Name:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mwnamefather" id="mwnamefather" required placeholder="(ex. Lito A. Aguinaldo)" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Citizenship:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mhcitizenshipfather" id="mhcitizenshipfather" required placeholder="(ex.Filipino)" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Citizenship:<span style='color:red'> *</span></label>
                                                    <input type="text" class="form-control" name="mwcitizenshipfather" id="mwcitizenshipfather" required placeholder="(ex. Filipino)" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Mother's Full Name:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mhnamemother" id="mhnamemother" required placeholder="(ex. Lita S. Cruz)" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Mother's Full Name:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mwnamemother" id="mwnamemother" required placeholder="(ex. Susan B. Aguinaldo)" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Citizenship:<span style='color:red'> *</span></label>
                                                    <input type="text" class="form-control" name="mhcitizenshipmother" id="mhcitizenshipmother" required placeholder="(ex. Filipino)" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Citizenship:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mwcitizenshipmother" id="mwcitizenshipmother" required placeholder="(ex. Filipino)" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Witness (Male):<span style='color:red'> *</span></label>
                                                    <input type="text" name="mwitness" id="mwitness" required placeholder="Person who gave consent" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Witness (Female):<span style='color:red'> *</span></label>
                                                    <input type="text" class="form-control" name="fwitness" id="fwitness" required placeholder="Person who gave consent" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Relationship:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mhwrelation" id="mhwrelation" required placeholder="Relationship" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Relationship:<span style='color:red'> *</span></label>
                                                    <input type="text" class="form-control" name="fhwrelation" id="fhwrelation" required placeholder="Relationship" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Residence:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mresidence" id="mresidence" required placeholder="Residence" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Residence:<span style='color:red'> *</span></label>
                                                    <input type="text" class="form-control" name="fresidence" id="fresidence" required placeholder="Residence" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                            </div>
											<br>
                                            <h4>Section 3: Requirements Needed</h4> <Br>
                                            <div class="row">
                                                <div class="requirement col-sm-6">
                                                    <h5><b>Groom Requirements:</b></h5>
                                                </div>
                                                <div class="requirement col-sm-6">
                                                    <h5><b>Bride Requirements:</b></h5>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="requirement col-sm-6">
                                                    <label for="baptismalCertificate">Baptismal Certificate<span style='color:red'> *</span></label>
                                                    <input type="file" id="gbaptismal" name="gbaptismal" class="form-control-file" 
                                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required />
                                                </div>
                                                <div class="requirement col-sm-6">
                                                    <label for="baptismalCertificate">Baptismal Certificate<span style='color:red'> *</span></label>
                                                    <input type="file" id="bbaptismal" name="bbaptismal" class="form-control-file" required />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="requirement col-sm-6">
                                                    <label for="confirmationCertificate">Confirmation Certificate<span style='color:red'>*</span></label>
                                                    <input type="file" id="ChCertificate" name="ChCertificate" class="form-control-file" required />
                                                </div>
                                                <div class="requirement col-sm-6">
                                                    <label for="confirmationCertificate">Confirmation Certificate<span style='color:red'>*</span></label>
                                                    <input type="file" id="CwCertificate" name="CwCertificate" class="form-control-file" required />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="requirement col-sm-6">
                                                    <label for="birthCertificate">Birth Certificate<span style='color:red'> *</span></label>
                                                    <input type="file" id="hbirthcert" name="hbirthcert" class="form-control-file" required />
                                                </div>
                                                <div class="requirement col-sm-6">
                                                    <label for="birthCertificate">Birth Certificate<span style='color:red'> *</span></label>
                                                    <input type="file" id="wbirthcert" name="wbirthcert" class="form-control-file" required />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="requirement col-sm-6">
                                                    <label for="cenomar">Certificate of No Marriage (CENOMAR)<span style='color:red'> *</span></label>
                                                    <input type="file" id="hcenomar" name="hcenomar" class="form-control-file" required />
                                                </div>
                                                <div class="requirement col-sm-6">
                                                    <label for="cenomar">Certificate of No Marriage (CENOMAR)<span style='color:red'> *</span></label>
                                                    <input type="file" id="wcenomar" name="wcenomar" class="form-control-file" required />
                                                </div>
                                            </div>
											<br>
                                            <h4>Section 4: Schedule Information</h4>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="birthCertificate">Reserve By: <span style='color:red'> *</span></label>
                                                    <input type="text" name="reserveby" id="reserveby" required placeholder="Reserve by (ex. Juan Cruz)" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="birthCertificate">Email Address <span style='color:red'>*</span></label>
                                                    <input type="text" name="email" id="email" required placeholder="(ex. juan@gmail.com" class="form-control" />
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <label for="mnumber">Phone Number: <span style='color:red'> *</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">+63</span>
                                                        <input type="tel" id="mnumber" name="mnumber" required maxlength="10" placeholder="XXXXXXXXXX" pattern="^\d{10}$" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="mnoguest">Number of Guest: <span style='color:red'> *</span></label>
                                                    <input type="number" name="mnoguest" id="mnoguest" required placeholder="Number of guests expected" class="form-control" required />
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label for="parish">Parish:<span style='color:red'> *</span></label>
                                                        <select name="parish" id="parish" required class="form-control">
                                                            <optgroup label="Choose your preferred Parish:">
                                                                <option value="St. Ignatius of Loyola Parish">St. Ignatius of Loyola Parish</option>
                                                                <option value="Sta. Rosa de Lima Parish">Sta. Rosa de Lima Parish</option>
                                                                <option value="Sto. Rosario de Pasig Parish">Sto. Rosario de Pasig Parish</option>
                                                                <option value="St. Michael the Archangel Parish, BGC">St. Michael the Archangel Parish, BGC</option>
															</optgroup>
														</select>
														<br>
													</div>
												</div>
                                                <div class="col-sm-3">
                                                <label for="priest">Name of Priest: (if you preferred any priest)</label>
                                                <input type="text" name="priest" id="priest" class="form-control" />
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>Date & Time:<span style='color:red'> *</span></label>
                                                    <input type="text" name="mdatetime" id="mdatetime" required placeholder="Date & Time of Ceremony" class="form-control" disabled />
                                                    <input type="hidden" name="mdatetime" id="mdatetime" required placeholder="Date And Time of Ceremony" class="form-control" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Select Event Type:<span style='color:red'> *</span></label>
                                                    <select name="marriagetype" id="marriagetype" class="form-control">
                                                        <option>Regular</option>
                                                        <option>Special (Kasalang Bayan)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <hr style="border-top: 1px solid black;">

                                            <div class="d-flex justify-content-end mt-4">
                                                <button type="submit" name="submit_marriage" id="submit_marraige" class="btn btn-lg custom-button">SUBMIT</button>
                                            </div>

                                        </div>
                                        <br>

                                                                    </div>
                                </form>


                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header  bg-success">
                                        <h4 class="modal-title">Modal title</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body-1"></div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
</body>
<script>
    function capitalizeFirstLetter(input) {
        let value = input.value;
        input.value = value.charAt(0).toUpperCase() + value.slice(1);
    }
</script>
<script>
    function selectSameCivilStatus(selectElement) {
        var selectedValue = selectElement.value;
        var otherSelect = document.getElementsByName("wedding_wife_civistatus")[0];

        // Find the option with the same value in the other select element
        var optionToSelect = Array.from(otherSelect.options).find(option => option.value === selectedValue);

        if (optionToSelect) {
            otherSelect.value = optionToSelect.value;
        }
    }
</script>
<script>
    $(document).ready(function() {
        var currentYear = new Date().getFullYear();
        var yearRange = currentYear - 1990;

        $("#pinaganako").datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-18y', // Adjust the start date to cover a wider range
            endDate: '-18y',
            autoclose: true
        });

        $("#pinaganakosay").datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-18y', // Adjust the start date to cover a wider range
            endDate: '-18y',
            autoclose: true
        });

        $("#pinaganako").datepicker('setStartDate', '-' + yearRange + 'y');
        $("#pinaganakosay").datepicker('setStartDate', '-' + yearRange + 'y');
        var oneWeekBefore = new Date();
        oneWeekBefore.setDate(oneWeekBefore.getDate() + 7);
        jQuery('#dateAndTime_hus, #dateAndTime_wife').datetimepicker({
            format: 'Y-m-d g:i A',
            step: 30,
            timepicker: true,
            minDate: oneWeekBefore
        });

        function toggleSubmitButton(enable) {
            if (enable) {
                $("#submitButton").prop("disabled", false);
            } else {
                $("#submitButton").prop("disabled", true);
            }
        }

        $("#dateAndTime, #event_type").on("change", function() {
            var selectedDateTime = $("#dateAndTime").val();
            var eventType = $("#event_type").val();

            $.ajax({
                url: "php/fetch_available_schedules_wedding.php",
                method: "POST",
                data: {
                    selectedDateTime: selectedDateTime,
                    eventType: eventType
                },
                success: function(data) {
                    $("#availableSchedules").html("Available Schedules: " + data);
                    var availableCount = parseInt(data);
                    toggleSubmitButton(availableCount > 0);
                },
                error: function() {
                    $("#availableSchedules").html("Error fetching available schedules.");
                    toggleSubmitButton(false);
                }
            });
        });

        const sections = document.querySelectorAll('.form-section');
        let currentSection = 0;
        const nextButton = document.getElementById('nextSection');

        function showSection(sectionIndex) {
            sections.forEach((section, index) => {
                if (index === sectionIndex) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });

            if (sectionIndex === sections.length - 1) {
                nextButton.disabled = true;
            } else {
                nextButton.disabled = false;
            }
        }

        document.getElementById('nextSection').addEventListener('click', () => {
            if (currentSection < sections.length - 1) {
                currentSection++;
                showSection(currentSection);
            }
        });

        document.getElementById('prevSection').addEventListener('click', () => {
            if (currentSection > 0) {
                currentSection--;
                showSection(currentSection);
            }
        });

        showSection(currentSection);
    });
</script>
<script>
    document.getElementById('number').addEventListener('input', function() {
        if (this.value.length > 11) {
            this.value = this.value.slice(0, 10); // Limit input to 11 characters
        }
    });
</script>

<script src="./js/notification.js"></script>
<script src="./js/my_script.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="js/jquery.datetimepicker.full.js"></script>