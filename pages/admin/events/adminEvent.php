<?php
include '../../../includes/functions.php';
session_start();

if (!isLoggedIn()) {
    header('Location: ../../auth.php');
    exit();
}

if (!isAdmin()) {
    header('Location: http://localhost/zooparc/pages/auth.php');
    exit();
}

$member_id = $_SESSION['user_id'];

$eventsQuery = "SELECT * FROM events ORDER BY event_date DESC";
$stmt = $conn->prepare($eventsQuery);
$stmt->execute();
$eventsResult = $stmt->get_result();

$usersQuery = "SELECT id, username FROM users";
$userStmt = $conn->prepare($usersQuery);
$userStmt->execute();
$usersResult = $userStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Events</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }
        @media (max-width: 768px) {
            .content {
                margin-left: 200px;
            }
        }
        @media (max-width: 480px) {
            .content {
                margin-left: 0;
            }
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #005f00;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
            margin-left: 180px;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 300px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-content {
            padding: 15px;
        }
        .card-title {
            font-weight: bolder;
            font-size: 1.25rem;
            margin-bottom: 10px;
            color: #005f00;
        }
        .card-text-tag {
            font-size: 1rem;
            color: #333;
            margin-top: 15px;
            font-weight: bold;
            font-size: 15px;
        }
        .card-text {
            font-size: 1rem;
            color: #333;
            margin-top: 12.5px;
            margin-bottom: 12.5px;
        }
        .btn-update, .btn-delete {
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            padding: 5px 10px;
            transition: background 0.3s ease;
            margin-top: 20px;
        }
        .btn-update {
            background: #13a9cb;
            color: #fff;
            margin-right: 10px;
        }
        .btn-update:hover {
            background: #0056b3;
        }
        .btn-delete:hover {
            background: #c82333;
        }
        .modal-content {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .modal-header, .modal-footer {
            border-bottom: none;
        }
        .modal-title {
            color: #333;
        }
        .modal-body {
            font-size: 1.1rem;
            color: #333;
        }
        .btn-secondary {
            background: #6c757d;
            color: #fff;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .btn-danger {
            background: #dc3545;
            color: #fff;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .upload-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #00b359;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .upload-btn:hover {
            background: #00994d;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<?php include '../../../components/adminSidebar.php'; ?>

<div class="content">
<a class="upload-btn" href="http://localhost/zooparc/pages/admin/events/scheduleEvent.php">Schedule Event</a>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="card-container">
        <?php if ($eventsResult->num_rows > 0): ?>
            <?php while ($event = $eventsResult->fetch_assoc()): ?>
                <div class="card">
                    <?php if ($event['image_path']): ?>
                        <img src="../../../uploads/<?php echo htmlspecialchars($event['image_path']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
                    <?php else: ?>
                        <img src="../../images/placeholder.jpg" alt="No image available">
                    <?php endif; ?>
                    <div class="card-content">
                        <div class="card-title"><?php echo htmlspecialchars($event['title']); ?></div>
                        <div class="card-text-tag"><?php echo htmlspecialchars($event['tags']); ?></div>
                        <div class="card-text"><?php echo nl2br(htmlspecialchars($event['description'])); ?></div>
                        <div class="card-text"><strong>Category:</strong> <?php echo htmlspecialchars($event['category']); ?></div>
                        <div class="card-text"><strong>Assigned Member:</strong> <?php echo htmlspecialchars($event['member_name']); ?></div>
                        <div class="card-text"><strong>Date:</strong> <?php echo htmlspecialchars($event['event_date']); ?></div>
                      
                        <button class="btn-update" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $event['id']; ?>" data-title="<?php echo htmlspecialchars($event['title']); ?>" data-description="<?php echo htmlspecialchars($event['description']); ?>" data-category="<?php echo htmlspecialchars($event['category']); ?>" data-tags="<?php echo htmlspecialchars($event['tags']); ?>" data-date="<?php echo htmlspecialchars($event['event_date']); ?>" data-image="<?php echo htmlspecialchars($event['image_path']); ?>" data-member="<?php echo htmlspecialchars($event['member_name']); ?>">Update</button>
                        <button class="btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?php echo $event['id']; ?>">Delete</button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No events found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" action="http://localhost/zooparc/pages/admin/events/update_event.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="eventId" id="updateEventId">
                    <div class="mb-3">
                        <label for="updateTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="updateTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="updateDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="updateCategory" class="form-label">Category</label>
                        <input type="text" class="form-control" id="updateCategory" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateTags" class="form-label">Tags</label>
                        <input type="text" class="form-control" id="updateTags" name="tags">
                    </div>
                    <div class="mb-3">
                        <label for="updateEventDate" class="form-label">Event Date</label>
                        <input type="date" class="form-control" id="updateEventDate" name="event_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateImage" class="form-label">Image</label>
                        <input type="file" class="form-control" id="updateImage" name="image">
                        <input type="hidden" id="updateImagePath" name="image_path">
                    </div>
                    <div class="mb-3">
                        <label for="updateMember" class="form-label">Assign Member</label>
                        <select class="form-select" id="updateMember" name="member_name">
                            <?php while ($user = $usersResult->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($user['username']); ?>"><?php echo htmlspecialchars($user['username']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this event?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" action="http://localhost/zooparc/pages/admin/events/delete_event.php" method="post">
                    <input type="hidden" name="eventId" id="deleteEventId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var updateModal = document.getElementById('updateModal');
        updateModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var eventId = button.getAttribute('data-id');
            var title = button.getAttribute('data-title');
            var description = button.getAttribute('data-description');
            var category = button.getAttribute('data-category');
            var tags = button.getAttribute('data-tags');
            var date = button.getAttribute('data-date');
            var image = button.getAttribute('data-image');
            var member = button.getAttribute('data-member');

            var modal = updateModal.querySelector('form');
            modal.querySelector('#updateEventId').value = eventId;
            modal.querySelector('#updateTitle').value = title;
            modal.querySelector('#updateDescription').value = description;
            modal.querySelector('#updateCategory').value = category;
            modal.querySelector('#updateTags').value = tags;
            modal.querySelector('#updateEventDate').value = date;
            modal.querySelector('#updateImagePath').value = image;
            modal.querySelector('#updateMember').value = member;
        });

        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var eventId = button.getAttribute('data-id');

            var modal = deleteModal.querySelector('form');
            modal.querySelector('#deleteEventId').value = eventId;
        });
    });
</script>
</body>
</html>
