<?php include("../assest/config.php"); ?>

<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>

<?php
// Handle add teacher form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_teacher'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    
    // Simple validation
    if ($name && $email && $subject) {
        $sql = "INSERT INTO teachers (name, email, subject) VALUES ('$name', '$email', '$subject')";
        if ($conn->query($sql) === TRUE) {
            $message = "Teacher added successfully.";
        } else {
            $message = "Error: " . $conn->error;
        }
    } else {
        $message = "Please fill all fields.";
    }
}

// Handle delete teacher request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM teachers WHERE id = $id");
    // Redirect to avoid resubmission and to reset GET params (pagination might be reset)
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}

// --- Pagination Setup ---

$limit = 5; // teachers per page
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1; // current page number from GET, default 1
$offset = ($page - 1) * $limit;

// Get total number of teachers for pagination calculation
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM teachers");
$totalRow = $totalResult->fetch_assoc();
$totalTeachers = $totalRow['total'];
$totalPages = ceil($totalTeachers / $limit);

// Fetch teachers for current page with LIMIT and OFFSET
$result = $conn->query("SELECT * FROM teachers ORDER BY id ASC LIMIT $limit OFFSET $offset");

?>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5">
    <h2>Teacher Management</h2>
    <?php if (!empty($message)) : ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="teacherTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link <?php if (!isset($_GET['page'])) echo 'active'; ?>" id="add-tab" data-bs-toggle="tab" data-bs-target="#add" type="button" role="tab" aria-controls="add" aria-selected="true">Add Teacher</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link <?php if (isset($_GET['page'])) echo 'active'; ?>" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab" aria-controls="list" aria-selected="false">Teacher List</button>
      </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content p-4 border border-top-0" id="teacherTabsContent">
        <!-- Add Teacher Tab -->
        <div class="tab-pane fade <?php if (!isset($_GET['page'])) echo 'show active'; ?>" id="add" role="tabpanel" aria-labelledby="add-tab">
            <form method="POST" action="">
                <input type="hidden" name="add_teacher" value="1" />
                <div class="mb-3">
                    <label for="name" class="form-label">Teacher Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter teacher name" required />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Teacher Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter teacher email" required />
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter subject" required />
                </div>
                <button type="submit" class="btn btn-primary">Add Teacher</button>
            </form>
        </div>

        <!-- Teacher List Tab -->
        <div class="tab-pane fade <?php if (isset($_GET['page'])) echo 'show active'; ?>" id="list" role="tabpanel" aria-labelledby="list-tab">
            <?php if ($result->num_rows > 0) : ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                            <td>
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this teacher?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Pagination controls -->
                <?php if ($totalPages > 1): ?>
                <nav>
                  <ul class="pagination">
                    <!-- Previous page link -->
                    <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                      <a class="page-link" href="?page=<?php echo $page-1; ?>">Previous</a>
                    </li>

                    <!-- Page numbers -->
                    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                      <li class="page-item <?php if($p == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $p; ?>"><?php echo $p; ?></a>
                      </li>
                    <?php endfor; ?>

                    <!-- Next page link -->
                    <li class="page-item <?php if($page >= $totalPages) echo 'disabled'; ?>">
                      <a class="page-link" href="?page=<?php echo $page+1; ?>">Next</a>
                    </li>
                  </ul>
                </nav>
                <?php endif; ?>

            <?php else: ?>
                <p>No teachers found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>



<?php include("includes/footer.php"); ?>