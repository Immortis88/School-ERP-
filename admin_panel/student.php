<?php include("../assest/config.php"); ?>

<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>

<?php
// Handle add student form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $class = $conn->real_escape_string($_POST['class']);
    $section = $conn->real_escape_string($_POST['section']);
    
    if ($name && $email && $class && $section) {
        $sql = "INSERT INTO students_list (name, email, class, section) VALUES ('$name', '$email', '$class', '$section')";
        if ($conn->query($sql) === TRUE) {
            $message = "Student added successfully.";
        } else {
            $message = "Error: " . $conn->error;
        }
    } else {
        $message = "Please fill all fields.";
    }
}

// Handle delete student request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM students_list WHERE id = $id");
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}

// Pagination setup
$limit = 5;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

$totalResult = $conn->query("SELECT COUNT(*) AS total FROM students_list");
$totalRow = $totalResult->fetch_assoc();
$totalStudents = $totalRow['total'];
$totalPages = ceil($totalStudents / $limit);

$result = $conn->query("SELECT * FROM students_list ORDER BY id ASC LIMIT $limit OFFSET $offset");
?>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5">
    <h2>Student Management</h2>
    <?php if (!empty($message)) : ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="studentTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link <?php if (!isset($_GET['page'])) echo 'active'; ?>" id="add-tab" data-bs-toggle="tab" data-bs-target="#add" type="button" role="tab" aria-controls="add" aria-selected="true">Add Student</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link <?php if (isset($_GET['page'])) echo 'active'; ?>" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab" aria-controls="list" aria-selected="false">Student List</button>
      </li>
    </ul>

    <div class="tab-content p-4 border border-top-0" id="studentTabsContent">
        <!-- Add Student Tab -->
        <div class="tab-pane fade <?php if (!isset($_GET['page'])) echo 'show active'; ?>" id="add" role="tabpanel" aria-labelledby="add-tab">
            <form method="POST" action="">
                <input type="hidden" name="add_student" value="1" />
                <div class="mb-3">
                    <label for="name" class="form-label">Student Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter student name" required />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Student Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter student email" required />
                </div>
                <div class="mb-3">
                    <label for="class" class="form-label">Class</label>
                    <input type="text" class="form-control" id="class" name="class" placeholder="Enter class" required />
                </div>
                <div class="mb-3">
                    <label for="section" class="form-label">Section</label>
                    <input type="text" class="form-control" id="section" name="section" placeholder="Enter section" required />
                </div>
                <button type="submit" class="btn btn-primary">Add Student</button>
            </form>
        </div>

        <!-- Student List Tab -->
        <div class="tab-pane fade <?php if (isset($_GET['page'])) echo 'show active'; ?>" id="list" role="tabpanel" aria-labelledby="list-tab">
            <?php if ($result->num_rows > 0) : ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['class']); ?></td>
                            <td><?php echo htmlspecialchars($row['section']); ?></td>
                            <td>
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <nav>
                  <ul class="pagination">
                    <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                      <a class="page-link" href="?page=<?php echo $page-1; ?>">Previous</a>
                    </li>

                    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                      <li class="page-item <?php if($p == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $p; ?>"><?php echo $p; ?></a>
                      </li>
                    <?php endfor; ?>

                    <li class="page-item <?php if($page >= $totalPages) echo 'disabled'; ?>">
                      <a class="page-link" href="?page=<?php echo $page+1; ?>">Next</a>
                    </li>
                  </ul>
                </nav>
                <?php endif; ?>

            <?php else: ?>
                <p>No students found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>



<?php include("includes/footer.php"); ?>
