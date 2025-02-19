<?php
include ('authentication.php');
include ('config/dbcon.php');
include ('includes/header.php');

// Update the query to get user counts by role
$query = "SELECT 
    COUNT(*) as total_users,
    SUM(CASE WHEN role = '5' THEN 1 ELSE 0 END) as vgm_count,
    SUM(CASE WHEN role = '4' THEN 1 ELSE 0 END) as chancery_count,
    SUM(CASE WHEN role = '3' THEN 1 ELSE 0 END) as oeconomous_count,
    SUM(CASE WHEN role = '2' THEN 1 ELSE 0 END) as parish_count,
    SUM(CASE WHEN role = '1' THEN 1 ELSE 0 END) as admin_count,
    SUM(CASE WHEN role = '0' THEN 1 ELSE 0 END) as user_count,
    SUM(CASE WHEN sex = 'Male' THEN 1 ELSE 0 END) as male_count,
    SUM(CASE WHEN sex = 'Female' THEN 1 ELSE 0 END) as female_count
    FROM users";
$query_run = mysqli_query($con, $query);
$user_data = mysqli_fetch_assoc($query_run);
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Admin Panel Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
     </ol>
        <div class="row">
        <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                Total Users
                <h2 class="mb-0"><?php echo $user_data['total_users']; ?></h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View All Users</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
        </div>
        <div class="col-xl-3 col-md-6">
        <div class="card bg-purple text-white mb-4">
            <div class="card-body">
                VGM Users
                <h2 class="mb-0"><?php echo $user_data['vgm_count']; ?></h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View VGM Users</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
        </div>
        <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                Chancery Users
                <h2 class="mb-0"><?php echo $user_data['chancery_count']; ?></h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Chancery Users</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
        </div>
        <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">
                Oeconomous Users
                <h2 class="mb-0"><?php echo $user_data['oeconomous_count']; ?></h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Oeconomous Users</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    Parish Users
                    <h2 class="mb-0"><?php echo $user_data['parish_count']; ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Parish Users</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    Admin Users
                    <h2 class="mb-0"><?php echo $user_data['admin_count']; ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Admins</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    Regular Users
                    <h2 class="mb-0"><?php echo $user_data['user_count']; ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Users</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this new row for the pie chart -->
    <div class="row mt-4">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    User Registration Overview
                </div>
                <div class="card-body">
                    <canvas id="userPieChart" width="100%" height="50"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Gender Distribution
                </div>
                <div class="card-body">
                    <canvas id="genderPieChart" width="100%" height="50"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this after the closing div.container-fluid but before the chart scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Then your existing chart scripts -->
<script>
    // User Role Pie Chart
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('userPieChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [
                        'VGM (' + <?php echo $user_data['vgm_count']; ?> + ')',
                        'Chancery (' + <?php echo $user_data['chancery_count']; ?> + ')',
                        'Oeconomous (' + <?php echo $user_data['oeconomous_count']; ?> + ')',
                        'Parish (' + <?php echo $user_data['parish_count']; ?> + ')',
                        'Admin (' + <?php echo $user_data['admin_count']; ?> + ')',
                        'Regular Users (' + <?php echo $user_data['user_count']; ?> + ')'
                    ],
                    datasets: [{
                        data: [
                            <?php echo $user_data['vgm_count']; ?>,
                            <?php echo $user_data['chancery_count']; ?>,
                            <?php echo $user_data['oeconomous_count']; ?>,
                            <?php echo $user_data['parish_count']; ?>,
                            <?php echo $user_data['admin_count']; ?>,
                            <?php echo $user_data['user_count']; ?>
                        ],
                        backgroundColor: [
                            'rgba(153, 102, 255, 0.8)',
                            'rgba(255, 159, 64, 0.8)',
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(255, 205, 86, 0.8)',
                            'rgba(40, 167, 69, 0.8)',
                            'rgba(23, 162, 184, 0.8)'
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Gender Pie Chart
        var genderCtx = document.getElementById('genderPieChart');
        if (genderCtx) {
            new Chart(genderCtx, {
                type: 'pie',
                data: {
                    labels: [
                        'Male (' + <?php echo $user_data['male_count']; ?> + ')',
                        'Female (' + <?php echo $user_data['female_count']; ?> + ')'
                    ],
                    datasets: [{
                        data: [
                            <?php echo $user_data['male_count']; ?>,
                            <?php echo $user_data['female_count']; ?>
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 99, 132, 0.8)'
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    });
</script>

<?php
include ('includes/footer.php');
?>
