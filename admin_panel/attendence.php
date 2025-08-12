<?php include("../assest/config.php"); ?>

<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>

<?php

// ==== SAVE ATTENDANCE ====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_attendance'])) {
    $class = $_POST['class'];
    $section = $_POST['section'];
    $subject = $_POST['subject'] ?? '';  // get subject or null
    $attendance = $_POST['attendance'];
    $date = date("Y-m-d");

    if ($subject === null) {
        // Show toast error if subject not selected
        echo '
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
            <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        Subject is required. Please select a subject.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            var toastEl = document.getElementById("errorToast");
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl, { delay: 4000 });
                toast.show();
            }
        });
        </script>
        ';
    } else {
        foreach ($attendance as $student_id => $status) {
            // Check if attendance record exists
            $check = $conn->prepare("
                SELECT id FROM attendance 
                WHERE student_id = ? AND date = ? AND class = ? AND section = ? AND subject = ?
            ");
            $check->bind_param("issss", $student_id, $date, $class, $section, $subject);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                // Update existing record
                $stmt = $conn->prepare("
                    UPDATE attendance SET status = ? 
                    WHERE student_id = ? AND date = ? AND class = ? AND section = ? AND subject = ?
                ");
                $stmt->bind_param("sissss", $status, $student_id, $date, $class, $section, $subject);
                $stmt->execute();
            } else {
                // Insert new record
                $stmt = $conn->prepare("
                    INSERT INTO attendance (student_id, class, section, date, status, subject) 
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                $stmt->bind_param("isssss", $student_id, $class, $section, $date, $status, $subject);
                $stmt->execute();
            }
        }

        echo '
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
            <div id="attendanceToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        Attendance recorded successfully for ' . htmlspecialchars($class) . ' - Section ' . htmlspecialchars($section) . ' on ' . $date . ' (Subject: ' . htmlspecialchars($subject) . ').
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            var toastEl = document.getElementById("attendanceToast");
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                toast.show();
            }
        });
        </script>
        ';
    }
}

// ==== FETCH STUDENTS IF CLASS & SECTION SELECTED ====
$students = [];
$subject = $_POST['subject'] ?? '';
if (isset($_POST['show_students'])) {
    $class = $_POST['class'];
    $section = $_POST['section'];
    $stmt = $conn->prepare("SELECT id, roll_no, name FROM students WHERE class=? AND section=? ORDER BY roll_no ASC");
    $stmt->bind_param("ss", $class, $section);
    $stmt->execute();
    $students = $stmt->get_result();
}

?>

<?php include("includes/navbar.php"); ?>

<div class="container">
    <h2 class="mb-4 text-center">Student Attendance</h2>

    <div class="card shadow p-4">
        <!-- Step 1: Select Class, Section & Subject -->
        <form method="POST">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Select Class</label>
                    <select name="class" class="form-select" required>
                        <option value="">-- Select Class --</option>
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?= $i ?>" <?= (isset($class) && $class == $i) ? 'selected' : '' ?>>
                                <?= $i ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Select Section</label>
                    <select name="section" class="form-select" required>
                        <?php $sections = ['A', 'B', 'C']; ?>
                        <option value="">-- Select Section --</option>
                        <?php foreach ($sections as $sec): ?>
                            <option value="<?= $sec ?>" <?= (isset($section) && $section == $sec) ? 'selected' : '' ?>>
                                <?= $sec ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Select Subject</label>
                    <select name="subject" class="form-select" required>
                        <option value="">-- Select Subject --</option>
                        <?php
                        // Fetch subjects from DB or hardcode here
                        // Example hardcoded subjects:
                        $subjects = ['Math', 'Science', 'English', 'History'];
                        foreach ($subjects as $subj): ?>
                            <option value="<?= htmlspecialchars($subj) ?>" <?= (isset($subject) && $subject == $subj) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($subj) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button type="submit" name="show_students" class="btn btn-primary">Show Students</button>
        </form>

        <!-- Step 2: Show Student List if Selected -->
        <?php if (!empty($students) && $students->num_rows > 0): ?>
            <form method="POST" class="mt-4">
                <input type="hidden" name="class" value="<?= htmlspecialchars($class) ?>">
                <input type="hidden" name="section" value="<?= htmlspecialchars($section) ?>">
                <input type="hidden" name="subject" value="<?= htmlspecialchars($subject) ?>">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Roll No</th>
                                <th>Student Name</th>
                                <th>Present</th>
                                <th>Absent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $students->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['roll_no'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><input type="radio" name="attendance[<?= $row['id'] ?>]" value="Present" required></td>
                                    <td><input type="radio" name="attendance[<?= $row['id'] ?>]" value="Absent"></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <button type="submit" name="save_attendance" class="btn btn-success mt-3">Save Attendance</button>
            </form>
        <?php elseif (isset($_POST['show_students'])): ?>
            <div class="alert alert-warning mt-4">No students found for the selected class and section.</div>
        <?php endif; ?>
    </div>
</div>

<?php include("includes/footer.php"); ?>
