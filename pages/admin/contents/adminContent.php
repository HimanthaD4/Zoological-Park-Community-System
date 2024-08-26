<?php
include '../../../includes/functions.php';
session_start();

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: ../../auth.php');
    exit();
}

// Check if user is an admin
if (!isAdmin()) {
    header('Location: http://localhost/zooparc/pages/auth.php');
    exit();
}

// Fetch all educational content
$contentsQuery = "SELECT * FROM educational_content ORDER BY uploaded_at DESC";
$stmt = $conn->prepare($contentsQuery);
$stmt->execute();
$contentsResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Educational Content</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }
        .content {
            margin-left: 250px; /* Adjust based on sidebar width */
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
            font-size: 1.25rem;
            margin-bottom: 10px;
            color: #005f00;
        }
        .card-text {
            font-size: 1rem;
            color: #333;
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
    </style>
</head>
<body>
<?php include '../../../components/adminSidebar.php'; ?> 

<div class="content">
    <a class="upload-btn" href="http://localhost/zooparc/pages/admin/contents/uploadContent.php">Upload Educational Content</a>
    
    <!-- Display Success or Error Messages -->
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
        <?php if ($contentsResult->num_rows > 0): ?>
            <?php while ($content = $contentsResult->fetch_assoc()): ?>
                <div class="card">
                    <?php if ($content['image_path']): ?>
                        <img src="../../../uploads/<?php echo htmlspecialchars($content['image_path']); ?>" alt="<?php echo htmlspecialchars($content['title']); ?>">
                    <?php else: ?>
                        <img src="../../images/placeholder.jpg" alt="No image available">
                    <?php endif; ?>
                    <div class="card-content">
                        <div class="card-title"><?php echo htmlspecialchars($content['title']); ?></div>
                        <div class="card-text"><?php echo nl2br(htmlspecialchars($content['content'])); ?></div>
                        <button class="btn-update" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $content['id']; ?>" data-title="<?php echo htmlspecialchars($content['title']); ?>" data-content="<?php echo htmlspecialchars($content['content']); ?>" data-image="<?php echo htmlspecialchars($content['image_path']); ?>">Update</button>
                        <button class="btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?php echo $content['id']; ?>">Delete</button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No educational content found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Content</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" action="http://localhost/zooparc/pages/admin/contents/update_content.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="contentId" id="updateContentId">
                    <div class="mb-3">
                        <label for="updateTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="updateTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateContent" class="form-label">Content</label>
                        <textarea class="form-control" id="updateContent" name="content" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="updateImage" class="form-label">Image</label>
                        <input type="file" class="form-control" id="updateImage" name="image">
                        <small class="form-text text-muted">Leave this blank if you don't want to update the image.</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
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
                <h5 class="modal-title" id="deleteModalLabel">Delete Content</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this content?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" action="http://localhost/zooparc/pages/admin/contents/delete_content.php" method="post">
                    <input type="hidden" name="contentId" id="deleteContentId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Update Modal
    var updateModal = document.getElementById('updateModal');
    updateModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var contentId = button.getAttribute('data-id');
        var title = button.getAttribute('data-title');
        var content = button.getAttribute('data-content');
        var image = button.getAttribute('data-image');

        var modalTitle = updateModal.querySelector('.modal-title');
        var modalContent = updateModal.querySelector('#updateForm');
        
        modalTitle.textContent = 'Update Content';
        modalContent.querySelector('#updateContentId').value = contentId;
        modalContent.querySelector('#updateTitle').value = title;
        modalContent.querySelector('#updateContent').value = content;
        modalContent.querySelector('#updateImage').value = ''; // Reset file input
    });

    // Delete Modal
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var contentId = button.getAttribute('data-id');
        
        var modalContent = deleteModal.querySelector('#deleteForm');
        modalContent.querySelector('#deleteContentId').value = contentId;
    });
</script>
</body>
</html>

