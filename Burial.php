<!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" type="text/css" href="assets/CSS/styless.css">
        <link rel="icon" href="assets/img/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Burial</title>
        <link rel="stylesheet" href="assets/CSS/bootstrap.min.css">
        <link href="assets/CSS/bootstrap-datepicker.min.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/CSS/jquery.datetimepicker.css">
        <script src="assets/js/jquery-3.6.0.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>


    </head>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            width: 285px;
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

        table,
        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: powderblue !important;
            border-style: solid;
            border-width: 1px !important;
        }

        :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }

        .short-btn {
            width: 15px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

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

        .main-content {
            overflow-y: auto;
            height: 100vh;
        }

        .custom-button:hover {
            background-color: #45a049;
            /* Darker green background color on hover */
        }
    </style>

    <body>
        <div class="main-container">
            <div class="dashboard-container">
                <div class="main-content">
                    <div class="top-bar">
                        <div class="profile">
                            <span>FUNERAL</span>
                        </div>
                    </div>

                    <div class="container py-5" id="page-container">

                                                
                            <div class="container py-5" id="page-container">
                                <div class="col-sm-12">
                                    <div class="form-box">
                                        <div class="form-title">DIOCESAN BURIAL FORM <img src="assets/img/logo.png" alt="Diocesan Logo" width="100" height="150" style="float: right;"> </div>
                                        <a href="card.html" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Back</a>
                                        <form action="burialformconnect.php" method="POST" enctype="multipart/form-data">
										<div class="form-group">
										<div class="form-group">
                                            <div>
                                                <!-- Deceased Information -->
                                                <div class="row">
                                                    <h4><b>Deceased Information:</b></h4>
                                                    <div class="col-sm-6">
                                                        <label for="bname">Full Name:<span style="color:red"> *</span></label>
                                                        <input type="text" id="bname" name="bname" class="form-control" required placeholder="Full Name" oninput="capitalizeFirstLetter(this)" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="bage">Age:<span style="color:red"> *</span></label>
                                                        <input type="text" id="bage" name="bage" class="form-control" required placeholder="Age" maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);" />
                                                    </div>


                                                </div> <br>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label for="bdatedeath">Date of Death:<span style="color:red"> *</span></label>
                                                        <input type="date" 
                                                               id="bdatedeath" 
                                                               name="bdatedeath" 
                                                               class="form-control" 
                                                               required 
                                                               max="<?php echo date('Y-m-d'); ?>" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="fdate">Funeral Date:<span style="color:red"> *</span></label>
                                                        <input type="text" id="bdate" name="bdate" required placeholder="Funeral Date & Time" value="2024-10-10 6:00 AM" class="form-control" disabled />
                                                        <input type="hidden" id="btime" name="btime" required placeholder="Funeral Date & Time" value="2024-10-10 6:00 AM" class="form-control" />
                                                    </div>

                                                </div> <br>
												<div class="row">
                                                    <div class="col-sm-12">
                                                        <label for="bparish">Parish:<span style='color:red'> *</span></label>
                                                        <select name="bparish" id="bparish" required class="form-control">
                                                            <optgroup label="Choose your preferred Parish:">
                                                                <option value="St. Ignatius of Loyola Parish">St. Ignatius of Loyola Parish</option>
                                                                <option value="Sta. Rosa de Lima Parish">Sta. Rosa de Lima Parish</option>
                                                                <option value="Sto. Rosario de Pasig Parish">Sto. Rosario de Pasig Parish</option>
                                                                <option value="St. Michael the Archangel Parish, BGC">St. Michael the Archangel Parish, BGC</option>
															</optgroup>
														</select>
													</div>
												</div>
												<br>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label for="blfuneral">Location of Funeral:<span style='color:red'> *</span></label>
                                                        <select name="blfuneral" id="blfuneral" required class="form-control">
                                                            <option value="" selected disabled>Select Location</option>
                                                            <optgroup label="Pasig City">
                                                                <option value="Pasig Catholic Cemetery">Pasig Catholic Cemetery</option>
                                                                <option value="Pasig City Public Cemetery">Pasig City Public Cemetery</option>
                                                                <option value="San Juan Municipal Cemetery">San Juan Municipal Cemetery</option>
                                                                <option value="Santo Tomas de Villanueva Parish">Santo Tomas de Villanueva Parish</option>
                                                                <option value="Santa Clara de Montefalco Parish Ossuary">Santa Clara de Montefalco Parish Ossuary</option>
                                                            </optgroup>
                                                            <optgroup label="Pateros">
                                                                <option value="Garden of Memories Memorial Park">Garden of Memories Memorial Park</option>
                                                                <option value="San Roque Catholic Cemetery">San Roque Catholic Cemetery</option>
                                                                <option value="Sta. Marta Catholic Cemetery">Sta. Marta Catholic Cemetery</option>
																<option value="Municipality of Pateros Public Cemetery">Municipality of Pateros Public Cemetery</option>
                                                            </optgroup>
                                                            <optgroup label="Taguig City">
                                                                <option value="Lambac">Taguig Catholic Cemetery</option>
                                                                <option value="Magsaysay">Hagonoy Catholic Cemetery</option>
                                                                <option value="Maquiapo">Libingan ng mga Bayani</option>
                                                                <option value="Natividad">Heritage Memorial Park</option>
                                                                <option value="Pulungmasle">Tipas Catholic Cemetery</option>
                                                                <option value="Rizal">Taguig City Public Cemetery</option>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                                <hr style="border-top: 2px solid black;">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <!-- Reserver Requirements -->
                                                        <h4><b>Reserver Requirements:</b></h4>
                                                        <div class="col-sm-6">
                                                            <label for="breserve">Full Name:<span style="color:red"> *</span></label>
                                                            <input type="text" id="breserve" name="breserve" required placeholder="Full name of the Reserver" class="form-control" oninput="capitalizeFirstLetter(this)" />
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="bemail">Email Address:<span style="color:red"> *</span></label>
                                                            <input type="text" id="bemail" name="bemail" required placeholder="Email address of the Reserver" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>

                                                <!-- Other input fields for reserver requirements -->
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label for="bcontact" class="form-label">Contact Number:<span style="color:red"> *</span></label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">+63</span>
                                                                <input type="tel" id="bcontact" name="bcontact" required maxlength="10" placeholder="XXXXXXXXX" pattern="^\d{10}$" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label for="bdeathcert" class="form-label" style="color: black;">Attached Death Certificate:<span style="color:red"> (Required)<span style="color:red"> *</span></label><br>
                                                            <input type="file" accept=".pdf,.png, .jpg,.jpeg" class="form-control-file" name="bdeathcert" id="bdeathcert" required />
                                                        </div>
                                                         
                                                    </div>
                                                    <br>
                                                    <hr style="border-top: 1px solid black;">
                                                    <div class="d-flex justify-content-end mt-4">
                                                        <button type="submit" class="btn btn-lg custom-button">Submit</button>
                                                    </div>


                                        </form>
                                    </div>
                                </div>
                            </div>

                    </div>
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


        $(document).ready(function() {
            $("#date_filter").datepicker({
                format: 'yyyy-mm-dd',
                startDate: '-3m',
                endDate: '-0d',
                autoclose: true
            })


            jQuery('#dateAndTime').datetimepicker({
                format: 'Y-m-d g:i A', // Set the format to 'yyyy-mm-dd HH:ii' for date and time
                step: 30, // Set the time step to 30 minutes (optional)
                timepicker: true, // Enable the time picker
                minDate: new Date()
            });

            $("#bdatedeath").datetimepicker({
                timepicker: false,
                format: 'Y-m-d',
                maxDate: '0', // Restricts selection to past dates only
                yearStart: 2000,
                yearEnd: new Date().getFullYear(),
                scrollMonth: false,
                scrollInput: false
            });
        })

        document.getElementById('number').addEventListener('input', function() {
            if (this.value.length > 11) {
                this.value = this.value.slice(0, 10); // Limit input to 11 characters
            }
        });

        // Function to save form data into session storage
        function saveFormData() {
            var formData = {};
            // Get all input elements in the form
            var inputs = document.querySelectorAll('input[name], select[name]');
            inputs.forEach(function(input) {
                formData[input.name] = input.value;
            });
            // Save form data into session storage
            sessionStorage.setItem('funeral_form_data', JSON.stringify(formData));
        }

        // Function to retrieve saved form data and fill the form
        window.onload = function() {
            var savedData = sessionStorage.getItem('funeral_form_data');
            if (savedData) {
                var formData = JSON.parse(savedData);
                // Fill the form with saved data
                var inputs = document.querySelectorAll('input[name], select[name]');
                inputs.forEach(function(input) {
                    if (formData.hasOwnProperty(input.name)) {
                        input.value = formData[input.name];
                    }
                });
            }
        };
    </script>
    <script src="assets/js/my_script.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="assets/js/jquery.datetimepicker.full.js"></script>





    </html>
