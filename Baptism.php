<!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" type="text/css" href="assets/CSS/styless.css">
        <link rel="icon" href="assets/img/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Baptismal</title>
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
            width: 290px;
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

        html,
        body {
            height: 100%;
            width: 100%;
            overflow: hidden;
            /* Hide scrollbars */
        }

        .dashboard-container {
            display: flex;
            flex-direction: row;
        }

        .sidebar {
            width: 290px;
        }

        .flashited {
            color: #f2f;
            -webkit-animation: flash linear 1s infinite;
            animation: flash linear 1s infinite;
        }

        @-webkit-keyframes flash {
            0% {
                opacity: 1;
            }

            50% {
                opacity: .1;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes flash {
            0% {
                opacity: 1;
            }

            50% {
                opacity: .1;
            }

            100% {
                opacity: 1;
            }
        }

        .short-btn {
            width: 20px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .form-container {
            max-height: 80vh;
            /* Adjust the height as needed */
            overflow: auto;
        }

        .main-content {
            overflow-y: auto;
            height: 100vh;
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

        .custom-button:hover {
            background-color: #45a049;
            /* Darker green background color on hover */
        }
    </style>

    <body>
                <div class="main-content">
                    <div class="top-bar">
                        <div class="profile">
                            <span>BAPTISMAL</span>
                            <div>
                                                                    <img src="assets/img/picture_data/" alt="Profile Image" id="profile">
                                                            </div>
                        </div>
                    </div>

                    <div class="container py-5" id="page-container">

                                                
                            <div class="container py-5" id="page-container">
                                <div class="col-sm-12">
                                    <div class="form-box">
                                        <div class="form-title">DIOCESAN BAPTISMAL FORM <img src="assets/img/logo.png" alt="Diocese Logo" width=100" height="150" style="float: right;"> </div>
                                        <a href="services.php" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Back</a>
                                        <form action="baptismalformconnect.php" method="POST" enctype="multipart/form-data">
										<div class="form-group">
										<div class="form-group">
                                            <div>
                                                <div class="row">
                                                    <h4><b>Child Information:</b></h4>
                                                    <div class="col-sm-4">
                                                        <label for="bapfname">First Name:<span style="color:red"> *</span></label>
                                                        <input type="text" id="bapfname" name="bapfname" class="form-control" required placeholder="First Name of Child" />
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="bapmname">Middle Name:<span style="color:red"> </span></label>
                                                        <input type="text" id="bapmname" name="bapmname" class="form-control" placeholder="Middle Name of Child" />
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="baplname">Last Name:<span style="color:red"> *</span></label>
                                                        <input type="text" id="baplname" name="baplname" class="form-control" required placeholder="Last Name of Child" />
                                                    </div>
                                                </div> <br>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label for="bapdbirth">Date of Birth:<span style="color:red"> *</span></label>
                                                        <input type="text" name="bapdbirth" id="bapdbirth" class="form-control" placeholder="Date of Birth">
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="bappbirth">Place of Birth:<span style="color:red"> *</span></label>
                                                        <input type="text" name="bappbirth" id="bappbirth" placeholder="Place of Birth" class="form-control" />
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="bapnationality">Nationality:<span style="color:red"> *</span></label>
                                                        <input type="text" name="bapnationality" id="bapnationality" required placeholder="Nationality" class="form-control" />
                                                    </div>
                                                </div> <br>
                                                <hr style="border-top: 2px solid black;">
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4><b>Parents Information:</b></h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label for="ffname">First Name:<span style="color:red"> *</span></label>
                                                    <input type="text" id="ffname" name="ffname" placeholder="Father's First Name" class="form-control" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="fmname">Middle Name:<span style="color:red"> *</span></label>
                                                    <input type="text" id="fmname" name="fmname" placeholder="Father's Middle Name" class="form-control" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="flname">Last Name:<span style="color:red"> *</span></label>
                                                    <input type="text" id="flname" name="flname" placeholder="Father's Last Name" class="form-control" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="bapfpbirth">Place of Birth:<span style="color:red"> </span></label>
                                                    <input type="text" id="bapfpbirth" name="bapfpbirth" placeholder="Father's Place of Birth" class="form-control" />
                                                </div>
                                            </div> <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="fresidence">Residence:<span style='color:red'> *</span></label>
                                                    <input type="text" id="fresidence" name="fresidence" placeholder="Parent's Recidence" class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="bapfstatus">Civil Status:<span style="color:red"> *</span></label>
                                                    <select name="bapfstatus" id="bapfstatus" class="form-control">
                                                        <option value="" disabled selected>Select Status</option>
                                                        <option value="single">Single</option>
                                                        <option value="married">Married</option>
                                                        <option value="divorced">Divorced</option>
                                                        <option value="widowed">Widowed</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label for="mfname">First Name:<span style="color:red"> *</span></label>
                                                    <input type="text" id="mfname" name="mfname" placeholder="Mother's First Name" class="form-control" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="mmname">Middle Name:<span style="color:red"> </span></label>
                                                    <input type="text" id="mmname" name="mmname" placeholder="Mother's Middle Name" class="form-control" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="mlname">Last Name:<span style="color:red"> *</span></label>
                                                    <input type="text" id="mlname" name="mlname" placeholder="Mother's Last Name" class="form-control" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="bapmpbirth">Place of Birth:<span style="color:red"> </span></label>
                                                    <input type="text" id="bapmpbirth" name="bapmpbirth" required placeholder="Mother's Place of Birth" class="form-control" />
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="mresidence">Residence:<span style='color:red'> *</span></label>
                                                    <input type="text" id="mresidence" name="mresidence" required placeholder="Parent's Recidence" class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="bapmstatus">Civil Status:<span style="color:red"> *</span></label>
                                                    <select name="bapmstatus" id="bapmstatus" required class="form-control">
                                                        <option value="" disabled selected>Select Status</option>
                                                        <option value="single">Single</option>
                                                        <option value="married">Married</option>
                                                        <option value="divorced">Divorced</option>
                                                        <option value="widowed">Widowed</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="mpsponsors">Principal Sponsors (Male):<span style='color:red'> *</span></label>
                                                    <input class="form-control" name="mpsponsors" id="mpsponsors" placeholder="Sponsors (e.g., Godfather: Juan Dela Cruz)" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="fpsponsors">Principal Sponsors (Female):<span style='color:red'> *</span></label>
                                                    <input class="form-control" name="fpsponsors" id="fpsponsors" placeholder="Sponsors (e.g., Godfather: Juan Dela Cruz)" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="sponsors3">Sponsors:<span style='color:red'> </span></label>
                                                    <input class="form-control" name="sponsors3" id="sponsors3" placeholder="Optional" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="sponsors4">Sponsors:<span style='color:red'> </span></label>
                                                    <input class="form-control" name="sponsors4" id="sponsors4" placeholder="Optional" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="sponsors5">Sponsors:<span style='color:red'> </span></label>
                                                    <input class="form-control" name="sponsors5" id="sponsors5" placeholder="Optional" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="sponsors6">Sponsors:<span style='color:red'> </span></label>
                                                    <input class="form-control" name="sponsors6" id="sponsors6" placeholder="Optional" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="sponsors7">Sponsors:<span style='color:red'> </span></label>
                                                    <input class="form-control" name="sponsors7" id="sponsors7" placeholder="Optional" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="sponsors8">Sponsors:<span style='color:red'> </span></label>
                                                    <input class="form-control" name="sponsors8" id="sponsors8" placeholder="Optional" />
                                                </div>
                                            </div>
                                            <br>
                                            <hr style="border-top: 2px solid black;">
                                            <div class="row">
                                                <h4><b>Schedule Information:</b></h4>
                                                <div class="col-sm-3">
                                                    <label for="bapdatetime">Date & Time:<span style="color:red"> *</span></label>
                                                    <input type="text" name="bapdatetime" id="bapdatetime" required placeholder="Date & Time" class="form-control" disabled>
                                                    <input type="hidden" name="bapdatetime" id="bapdatetime" required placeholder="Date & Time"  class="form-control">
                                                </div><br><br>
												<br>
                                                <div class="row">
												<div class="col-sm-12">
                                                    <label for="baploc">Place of Baptism:<span style="color:red"> * </span></label><br>
                                                    <select id="baploc" name="baploc" class="form-control"/>
															<optgroup label="Choose your preferred Parish:">
                                                                <option value="St. Ignatius of Loyola Parish">St. Ignatius of Loyola Parish</option>
                                                                <option value="Sta. Rosa de Lima Parish">Sta. Rosa de Lima Parish</option>
                                                                <option value="Sto. Rosario de Pasig Parish">Sto. Rosario de Pasig Parish</option>
                                                                <option value="St. Michael the Archangel Parish, BGC">St. Michael the Archangel Parish, BGC</option>
															</optgroup>
													</select>
												</div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-4 mb-3">
												<label for="bapriest" class="form-label">Name Of Priest: (if you preferred any priest, if not leave it blank) </label>
												<input type="text" id="bapriest" name="bapriest" class="form-control"/>
												</div>
                                                <div class="col-sm-4 mb-3">
                                                    <label for="bapemail" class="form-label">Email Address:<span style="color:red"> *</span></label>
                                                    <input type="email" id="bapemail" name="bapemail" required placeholder="Enter your email address" class="form-control">
                                                </div>

                                                <div class="col-sm-4 mb-3">
                                                    <label for="bapcontact" class="form-label">Contact Number:<span style="color:red"> *</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">+63</span>
                                                        <input type="tel" id="bapcontact" name="bapcontact" required maxlength="10" placeholder="XXXXXXXXXX" pattern="^\d{10}$" class="form-control" required>
                                                    </div>
                                                </div>

                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="baptype">Select Schedule Type:<span style="color:red"> *</span></label>
                                                    <select name="baptype" id="baptype" class="form-control">
                                                        <option selected disabled hidden>Select Schedule Type</option>
                                                        <option>Special</option>
                                                        <option>Fixed (Binyagang Bayan)</option>
                                                    </select>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label for="reserveby">Reserve by:<span style="color:red"> *</span></label>
                                                    <input type="text" name="reserveby" id="reserveby" class="form-control" requried />
                                                </div>
                                            </div>

                                            <hr style="border-top: 2px solid black;">

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label for="bcert">Attach Live Birth/PSA Birth Certificate:<span style="color:red">*</span></label>
                                                    <input type="file" id="bcert" class="form-control-file" placeholder="Upload Certificate" name="bcert" accept=".jpg, .jpeg, .png" required />
                                                    <div id="previewImageContainer"></div>
                                                </div>
                                             <br>
                                                <div class="col-sm-5">
                                                    <div class="d-flex justify-content-end mt-4">
                                                        <button type="submit" class="btn btn-lg custom-button">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                </div>
                </form>
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


            <script>
                $(document).ready(function() {
                    $("#date_filter").datepicker({
                        format: 'yyyy-mm-dd',
                        startDate: '-18y',
                        endDate: '1d',
                        autoclose: true
                    })


                    jQuery('#dateAndTime').datetimepicker({
                        format: 'Y-m-d g:i A',
                        step: 30,
                        timepicker: true,
                        minDate: new Date()
                    });

                    $("#dateAndTime, #event_type").on("change", function() {
                        var selectedDateTime = $("#dateAndTime").val();
                        var eventType = $("#event_type").val(); // Get the selected event type

                        $.ajax({
                            url: "php/fetch_available_schedules.php",
                            method: "POST",
                            data: {
                                selectedDateTime: selectedDateTime,
                                eventType: eventType
                            }, // Pass eventType as a parameter
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
                })
            </script>

            <script src="assets/js/notification.js"></script>
            <script src="assets/js/my_script.js"></script>
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/bootstrap-datepicker.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
            <script src="assets/js/jquery.datetimepicker.full.js"></script>

            <script>
                document.getElementById('number').addEventListener('input', function() {
                    if (this.value.length > 11) {
                        this.value = this.value.slice(0, 10); // Limit input to 11 characters
                    }
                });
            </script>

    </html>
    </div>
    </div>

    </html>