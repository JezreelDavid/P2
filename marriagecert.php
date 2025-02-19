<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="assets/CSS/styless.css">
    <link rel="icon" href="assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Request</title>
    <link rel="stylesheet" href="assets/CSS/bootstrap.min.css">
    <link href="assets/CSS/bootstrap-datepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/CSS/jquery.datetimepicker.css">
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">



</head>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    .form-section {
        display: none;
    }

    .form-section.active {
        display: block;
    }

    .row button {
        width: 100px;
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
        margin-left: 8px;
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
        width: 390px;
        height: 4px;
        background-color: #007bff;
        /* Choose your desired color */
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
        background-color: #ddd;
        color: black;

    }

    .round {
        border-radius: 50%;
    }

    .submit-button {
        position: absolute;
        bottom: 0;
        right: 0;
        margin-bottom: 10px;
        display: inline-block;
        padding: 15px 50px;
        background-color: #1D4092;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }
</style>

<body>
            <div class="main-content">
                <div class="top-bar">
                    <div class="profile">
                        <span>DOCUMENT REQUEST</span>
                    </div>
                </div>

                <div class="container py-5" id="page-container">

                                        
                        <div class="container py-5" id="page-container">
                            <div class="col-sm-12">
                                <div class="form-box" style="position: relative;">
                                    <div class="form-title">MARRIAGE REQUEST CERTIFICATES <img src="assets/img/logo.png" alt="Company Logo" width="100" height="150" style="float: right;"></div> <br>
                                    <a href="card2certificate.html" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Back</a>
                                    <form method="post" action="php/insert_request.php" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="searchkey">Document Owner:<span style='color:red'> *</span></label>
                                                <input type="text" name="document_owner" class="form-control" placeholder="(Fullname of the Child)" id="searchkey" oninput="capitalizeFirstLetter(this)" required />
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="requested_by">Full Name:<span style='color:red'> *</span></label>
                                                <input type="text" name="requested_by" class="form-control" placeholder="Name of Requestor (ex. Max A. Collins)" oninput="capitalizeFirstLetter(this)" required />
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="relation_to_owner">Relationship: <span style='color:red'></span></label>
                                                <input type="text" name="relation_to_owner" class="form-control" placeholder="Relationship to the owner" oninput="capitalizeFirstLetter(this)" required />
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="mobileNumber">Phone Number:<span style='color:red'> *</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">+63</span>
                                                    <input type="tel" id="mobileNumber" name="contact_no" required maxlength="10" placeholder="XXXXXXXXXX" pattern="^\d{10}$" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="email_add">Email Address:<span style='color:red'> *</span></label>
                                                <input type="email" name="email_add" class="form-control" placeholder="Email address" required />
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="supporting_docs">Verification:<span style='color:red'> *</span></label>
                                                <input type="file" name="supporting_docs" required class="form-control" />
                                                <div style="color: black; margin-top: 5px;">
                                                    <span>
                                                        <i style="color: red;" class="fas fa-exclamation-circle"></i>
                                                        <span style="color: red;">Note:</span> Please provide your birth certificate if you are the owner. If not, please attached an authorization letter with your ID.
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="purpose">Purpose:</label>
                                                <textarea class="form-control" name="purpose"></textarea>
                                            </div>
                                        </div>
                                        <hr style="border-top: 1px solid black;">
                                        <br><br>
                                        <div class="row justify-content-end">
                                            <button type="submit" class="submit-button" style="position: absolute; bottom: 10px; right: 10px;"><b>Submit</b></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <br>


                                    </div>
                </form>


            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
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
    document.getElementById('number').addEventListener('input', function() {
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10); // Limit input to 11 characters
        }
    });
</script>
<script src="assets/js/notification.js"></script>
<script src="assets/js/my_script.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="assets/js/jquery.datetimepicker.full.js"></script>





</html>