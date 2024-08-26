<?php
include '../../includes/functions.php';
session_start();

if (!isLoggedIn()) {
    header('Location: ../auth.php');
    exit();
}

$member_id = $_SESSION['user_id'];

$contentsQuery = "SELECT * FROM educational_content WHERE member_id = ? ORDER BY uploaded_at DESC";
$stmt = $conn->prepare($contentsQuery);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$contentsResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
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

        .bb {
            padding-bottom: 10px;
            padding-top: 10px;
            background: rgba(0, 0, 0, 0.5);
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 20px;
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
            width: 350px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .upload-btn:hover {
            background: #00994d;
            transform: scale(1.05);
            text-decoration: none;
            color: #fff;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }
        .card {
            background: rgba(255, 255, 255, 0.2);
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
            color: #ffffff;
            font-weight: bolder;
            padding-bottom: 10px;
        }
        .card-text {
            font-size: 1rem;
            color: #ffffff;
        }
        .show-more {
            display: block;
            margin-top: 10px;
            padding: 5px;
            background: #00b359;
            color: #fff;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        .show-more:hover {
            background: #00994d;
            text-decoration: none;
            color: white;
        }
        .btn-delete, .btn-update {
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
            background: #007bff;
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
        .invalid-feedback {
            display: block;
            font-size: 0.875rem;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <?php include '../../components/userHeader.php'; ?>
    <div class="bb">
        <div class="container">
            <a class="upload-btn" href="upload_education.php">Upload Educational Content</a>
            
            <h2>My Contents</h2>
            <div class="card-container">
                <?php if ($contentsResult->num_rows > 0): ?>
                    <?php while ($content = $contentsResult->fetch_assoc()): ?>
                        <div class="card">
                            <?php if ($content['image_path']): ?>
                                <img src="../../uploads/<?php echo htmlspecialchars($content['image_path']); ?>" alt="<?php echo htmlspecialchars($content['title']); ?>">
                            <?php else: ?>
                                <img src="../images/placeholder.jpg" alt="No image available">
                            <?php endif; ?>
                            <div class="card-content">
                                <div class="card-title"><?php echo htmlspecialchars($content['title']); ?></div>
                                <div class="card-text">
                                    <?php 
                                    $fullContent = htmlspecialchars($content['content']);
                                    $shortContent = (strlen($fullContent) > 300) ? substr($fullContent, 0, 300) . '...' : $fullContent;
                                    echo nl2br($shortContent);
                                    ?>
                                </div>
                                <?php if (strlen($fullContent) > 300): ?>
                                    <a href="viewContentMember.php?id=<?php echo $content['id']; ?>" class="show-more">Show More</a>
                                <?php endif; ?>
                                <button class="btn-update" data-toggle="modal" data-target="#updateModal" data-id="<?php echo $content['id']; ?>" data-title="<?php echo htmlspecialchars($content['title']); ?>" data-content="<?php echo htmlspecialchars($content['content']); ?>" data-image="<?php echo htmlspecialchars($content['image_path']); ?>">Update</button>
                                <button class="btn-delete" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $content['id']; ?>">Delete</button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No educational content found.</p>
                <?php endif; ?>
            </div>
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
            // Optionally handle the image if needed, e.g., displaying a preview
        });

        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            var modal = $(this);
            modal.find('#deleteContentId').val(id);
        });

        // Form validation
        document.getElementById('updateForm').addEventListener('submit', function(event) {
            var form = event.target;
            var isValid = true;

            // Validate title
            var title = form.querySelector('#updateTitle');
            if (!title.value.trim()) {
                title.classList.add('is-invalid');
                isValid = false;
            } else {
                title.classList.remove('is-invalid');
            }

            // Validate content
            var content = form.querySelector('#updateContent');
            if (!content.value.trim()) {
                content.classList.add('is-invalid');
                isValid = false;
            } else {
                content.classList.remove('is-invalid');
            }

            // Validate image
            var image = form.querySelector('#updateImage');
            if (image.files.length > 0) {
                var file = image.files[0];
                var validFormats = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validFormats.includes(file.type) || file.size > 5 * 1024 * 1024) {
                    image.classList.add('is-invalid');
                    isValid = false;
                } else {
                    image.classList.remove('is-invalid');
                }
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
