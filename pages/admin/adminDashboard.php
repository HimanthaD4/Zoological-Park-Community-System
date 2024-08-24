<?php
include '../../includes/functions.php';
session_start();

if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit();
}
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
<?php include '../../components\adminSidebar.php'; ?>

    <div class="content">
        <h1>Dashboard</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Visitor Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="visitorChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Content Uploads</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="contentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Recent Activities</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">Activity 1 - Description</li>
                    <li class="list-group-item">Activity 2 - Description</li>
                    <li class="list-group-item">Activity 3 - Description</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Sample data for charts
        var ctx1 = document.getElementById('visitorChart').getContext('2d');
        var visitorChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May'],
                datasets: [{
                    label: 'Visitors',
                    data: [50, 60, 70, 80, 90],
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

        var ctx2 = document.getElementById('contentChart').getContext('2d');
        var contentChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Education', 'Entertainment', 'Science'],
                datasets: [{
                    label: 'Content Type',
                    data: [30, 50, 20],
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)', 'rgba(255, 206, 86, 1)'],
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>
