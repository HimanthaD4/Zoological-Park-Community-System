<?php
include '../../includes/functions.php';
include '../../includes/db.php';
session_start();

// Check if the user is logged in and is an admin
if (!isLoggedIn() || !isAdmin()) {
    header('Location: ../index.php');
    exit();
}

// Fetch all educational content
$contentsQuery = "SELECT * FROM educational_content ORDER BY uploaded_at DESC";
$stmt = $conn->prepare($contentsQuery);
$stmt->execute();
$contentsResult = $stmt->get_result();
$contentsCount = $contentsResult->num_rows;

// Fetch all events
$eventsQuery = "SELECT * FROM events ORDER BY event_date DESC";
$stmt = $conn->prepare($eventsQuery);
$stmt->execute();
$eventsResult = $stmt->get_result();
$eventsCount = $eventsResult->num_rows;

// Fetch all users
$usersQuery = "SELECT * FROM users";
$stmt = $conn->prepare($usersQuery);
$stmt->execute();
$usersResult = $stmt->get_result();
$usersCount = $usersResult->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .content {
                margin-left: 200px;
            }
        }
        @media (max-width: 480px) {
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
<?php include '../../components/adminSidebar.php'; ?>

    <div class="content">
        <h1>Dashboard</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Educational Content</h5>
                    </div>
                    <div class="card-body">
                        <p>Total Content: <?php echo $contentsCount; ?></p>
                        <div class="chart-container">
                            <canvas id="contentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Events</h5>
                    </div>
                    <div class="card-body">
                        <p>Total Events: <?php echo $eventsCount; ?></p>
                        <div class="chart-container">
                            <canvas id="eventsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Users</h5>
                    </div>
                    <div class="card-body">
                        <p>Total Users: <?php echo $usersCount; ?></p>
                        <div class="chart-container">
                            <canvas id="usersChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

 
    </div>

    <script>
        // Sample data for charts
        var ctx1 = document.getElementById('contentChart').getContext('2d');
        var contentChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Content 1', 'Content 2', 'Content 3'],
                datasets: [{
                    label: 'Educational Content',
                    data: [10, 20, 30], // Replace with real data
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx2 = document.getElementById('eventsChart').getContext('2d');
        var eventsChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Event 1', 'Event 2', 'Event 3'],
                datasets: [{
                    label: 'Events',
                    data: [5, 15, 25], // Replace with real data
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx3 = document.getElementById('usersChart').getContext('2d');
        var usersChart = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['Admins', 'Members'],
                datasets: [{
                    label: 'User Roles',
                    data: [5, 10], // Replace with real data
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)'],
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>
