<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZooParc - Admin Settings</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Include your CSS file here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            background-color: #f8f9fa;
        }
        .container {
            flex: 1;
            margin-left: 350px;
            padding: 20px;
        }
        .settings-table {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .settings-table h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #343a40;
        }
        .settings-table td {
            padding: 15px;
            vertical-align: middle;
        }
        .settings-table .status {
            font-weight: bold;
        }
        .settings-table .status.active {
            color: #28a745; /* Green for active */
        }
        .settings-table .status.coming-soon {
            color: #ffc107; /* Yellow for coming soon */
        }
        .settings-table .status.inactive {
            color: #dc3545; /* Red for inactive */
        }
        .settings-table .btn {
            margin: 0;
        }

        .btn-primary{
            background-color: #004d40;
            border-color: #004d40;
        }

        .btn-primary:hover{
            background-color: #004d40;
            border-color: #004d40;
        }
    </style>
</head>
<body>
    <?php include '../../components/adminSidebar.php'; ?>
    <div class="container">
        <div class="settings-table">
            <h2>Settings Overview</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Setting</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Content Upload</td>
                        <td class="status active">Active</td>
                        <td><a href="upload_content.php" class="btn btn-primary">Manage</a></td>
                    </tr>
                    <tr>
                        <td>Scheduled Events</td>
                        <td class="status active">Active</td>
                        <td><a href="schedule_event.php" class="btn btn-primary">Manage</a></td>
                    </tr>
                    <tr>
                        <td>Theme Settings</td>
                        <td class="status coming-soon">Coming Soon</td>
                        <td><button class="btn btn-secondary" disabled>Manage</button></td>
                    </tr>
                    <tr>
                        <td>Notifications</td>
                        <td class="status coming-soon">Coming Soon</td>
                        <td><button class="btn btn-secondary" disabled>Manage</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
