<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #004d40;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            transition: width 0.3s ease, padding 0.3s ease;
            z-index: 999;
        }
        .sidebar .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .sidebar .menu-header {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0 10px;
            color: #b2dfdb;
        }
        .sidebar a, .sidebar .dropdown a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 10px;
            transition: background-color 0.3s ease, color 0.3s ease;
            position: relative;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar a:hover, .sidebar .dropdown a:hover {
            background-color: #00796b;
            color: #e0f2f1;
        }
        .sidebar .dropdown {
            position: relative;
            display: block;
        }
        .sidebar .dropdown-content {
            display: none;
            overflow: hidden;
            max-height: 0;
            position: relative;
            background-color: #004d40;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: max-height 0.3s ease;
            width: 100%;
        }
        .sidebar .dropdown-content a {
            padding: 10px;
            font-size: 14px;
        }
        .sidebar .dropdown.show .dropdown-content {
            display: block;
            max-height: 200px; /* Adjust as needed */
        }
        .sidebar .active {
            background-color: #00796b;
            color: #e0f2f1;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
        }
        @media (max-width: 480px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
                box-shadow: none;
            }
            .sidebar a {
                display: inline-block;
                padding: 10px;
                margin-bottom: 0;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="http://localhost/zooparc/pages/index.php">Zooparc Admin</div>
        <div class="menu-header">Admin</div>
        <a href="http://localhost/zooparc/pages/admin/adminDashboard.php" id="dashboard-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <div class="dropdown" id="content-dropdown">
            <a href="#" id="content-link"><i class="fas fa-file-alt"></i>Educational Contents</a>
            <div class="dropdown-content">
                <a href="http://localhost/zooparc/pages/admin/contents/uploadContent.php">Add Contents</a>
                <a href="http://localhost/zooparc/pages/admin/contents/adminContent.php">My Contents</a>
            </div>
        </div>
        <div class="dropdown" id="events-dropdown">
            <a href="#" id="events-link"><i class="fas fa-calendar-alt"></i> Events</a>
            <div class="dropdown-content">
                <a href="http://localhost/zooparc/pages/admin/events/sheduleEvent.php">Add Events</a>
                <a href="http://localhost/zooparc/pages/admin/events/adminEvent.php">Scheduled Events</a>
            </div>
        </div>
        <a href="http://localhost/zooparc/pages/admin/adminUsers.php" id="users-link"><i class="fas fa-users"></i> Manage Users</a>
        <a href="http://localhost/zooparc/pages/admin/settings.php" id="settings-link"><i class="fas fa-cogs"></i> Settings</a>
        <a href="http://localhost/zooparc/pages/logout.php" id="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get current URL path
            var path = window.location.pathname.split("/").pop();

            // Get all sidebar links
            var links = document.querySelectorAll('.sidebar a');

            links.forEach(function (link) {
                var href = link.getAttribute('href').split("/").pop();
                if (href === path) {
                    link.classList.add('active');
                    if (link.parentElement.classList.contains('dropdown')) {
                        link.parentElement.classList.add('show');
                    }
                } else {
                    link.classList.remove('active');
                }
            });

            // Toggle dropdowns on click
            document.querySelectorAll('.sidebar .dropdown > a').forEach(function (dropdownToggle) {
                dropdownToggle.addEventListener('click', function () {
                    var parentDropdown = this.parentElement;
                    parentDropdown.classList.toggle('show');
                    // Close other dropdowns
                    document.querySelectorAll('.sidebar .dropdown').forEach(function (dropdown) {
                        if (dropdown !== parentDropdown) {
                            dropdown.classList.remove('show');
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
