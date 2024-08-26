<?php
include '../../includes/functions.php';
session_start();

if (!isLoggedIn()) {
    header('Location: ../auth.php');
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: member.php');
    exit();
}

$content_id = intval($_GET['id']);

// Fetch the content to display
$contentQuery = "SELECT * FROM educational_content WHERE id = ?";
$stmt = $conn->prepare($contentQuery);
$stmt->bind_param("i", $content_id);
$stmt->execute();
$contentResult = $stmt->get_result();

if ($contentResult->num_rows === 0) {
    header('Location: member.php');
    exit();
}

$content = $contentResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Content</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background: url('../../images/chimp.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn {
            margin: 5px;
        }
        .btn-back {
            background: #007bff;
            color: #fff;
        }
        .btn-back:hover {
            background: #0056b3;
        }
        .btn-update {
            background: #007bff;
            color: #fff;
        }
        .btn-update:hover {
            background: #0056b3;
        }
        .btn-delete {
            background: #dc3545;
            color: #fff;
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
        .invalid-feedback {
            display: block;
            font-size: 0.875rem;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <?php include '../../components/userHeader.php'; ?>

    <div class="container">
        <div class="card">
            <h2><?php echo htmlspecialchars($content['title']); ?></h2>
            <?php if ($content['image_path']): ?>
                <img src="../../uploads/<?php echo htmlspecialchars($content['image_path']); ?>" alt="<?php echo htmlspecialchars($content['title']); ?>" style="width: 100%; height: auto; border-radius: 10px;">
            <?php endif; ?>
            <p><?php echo nl2br(htmlspecialchars($content['content'])); ?></p>
            <a href="member.php" class="btn btn-back">Back</a>
            <button class="btn btn-update" data-toggle="modal" data-target="#updateModal" data-id="<?php echo $content['id']; ?>" data-title="<?php echo htmlspecialchars($content['title']); ?>" data-content="<?php echo htmlspecialchars($content['content']); ?>" data-image="<?php echo htmlspecialchars($content['image_path']); ?>">Update</button>
            <button class="btn btn-delete" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $content['id']; ?>">Delete</button>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Content</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateForm" method="post" action="updateContent.php" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="updateContentId">
                        <div class="form-group">
                            <label for="updateTitle">Title</label>
                            <input type="text" class="form-control" id="updateTitle" name="title" required>
                        
                        </div>
                        <div class="form-group">
                            <label for="updateContent">Content</label>
                            <textarea class="form-control" id="updateContent" name="content" rows="5" required></textarea>
                       
                        </div>
                        <div class="form-group">
                            <label for="updateImage">Image (optional)</label>
                            <input type="file" class="form-control-file" id="updateImage" name="image">
                            
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Content</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this content?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="post" action="deleteContent.php">
                        <input type="hidden" name="id" id="deleteContentId">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $('#updateModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var title = button.data('title');
            var content = button.data('content');
            var image = button.data('image');

            var modal = $(this);
            modal.find('#updateContentId').val(id);
            modal.find('#updateTitle').val(title);
            modal.find('#updateContent').val(content);

            // Handle image in update form
            if (image) {
                modal.find('#updateImage').val('');
                modal.find('#updateImage').after('<small class="form-text text-muted">Current image: ' + image + '</small>');
            } else {
                modal.find('#updateImage').next('small').remove();
            }
        });

        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            var modal = $(this);
            modal.find('#deleteContentId').val(id);
        });

        // Form validation
        $('#updateForm').on('submit', function (event) {
            var form = $(this);
            var isValid = true;

            if ($('#updateTitle').val().trim() === '') {
                $('#updateTitle').addClass('is-invalid');
                isValid = false;
            } else {
                $('#updateTitle').removeClass('is-invalid');
            }

            if ($('#updateContent').val().trim() === '') {
                $('#updateContent').addClass('is-invalid');
                isValid = false;
            } else {
                $('#updateContent').removeClass('is-invalid');
            }

            if (!isValid) {
                event.preventDefault();
            }
        });

        $('#updateTitle, #updateContent').on('input', function () {
            $(this).removeClass('is-invalid');
        });
    </script>
</body>
</html>
