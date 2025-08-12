<?php include("../assest/config.php"); ?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>

<?php
// Classes 1 to 12 as strings
$classes = range(1, 12);
$sections = ['A', 'B', 'C'];

$message = '';

// Handle POST update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $class = $conn->real_escape_string($_POST['class']);
    $section = $conn->real_escape_string($_POST['section']);

    foreach ($_POST['id'] as $index => $id) {
        $subject = $conn->real_escape_string($_POST['subject'][$index]);
        $teacher = $conn->real_escape_string($_POST['teacher'][$index]);
        $start_time = $conn->real_escape_string($_POST['start_time'][$index]);
        $end_time = $conn->real_escape_string($_POST['end_time'][$index]);

        $checkLunch = $_POST['subject'][$index];

        if (stripos($checkLunch, 'Lunch') === false) {
            $sql = "UPDATE timetable 
                    SET subject='$subject', teacher='$teacher', start_time='$start_time', end_time='$end_time' 
                    WHERE id=$id AND class='$class' AND section='$section'";
            $conn->query($sql);
        } else {
            // Update times even for lunch break
            $sql = "UPDATE timetable 
                    SET start_time='$start_time', end_time='$end_time'
                    WHERE id=$id AND class='$class' AND section='$section'";
            $conn->query($sql);
        }
    }
    $message = "Timetable updated successfully!";
}

// Get selected class and section from GET or POST
$selected_class = $_GET['class'] ?? $_POST['class'] ?? null;
$selected_section = $_GET['section'] ?? $_POST['section'] ?? null;

// Fetch timetable only if class and section selected
$timetable = [];
if ($selected_class && $selected_section) {
    $class_esc = $conn->real_escape_string($selected_class);
    $section_esc = $conn->real_escape_string($selected_section);
    $result = $conn->query("SELECT * FROM timetable WHERE class='$class_esc' AND section='$section_esc' ORDER BY id ASC");
    while ($row = $result->fetch_assoc()) {
        $timetable[] = $row;
    }
}

$conn->close();
?>

<?php include("includes/navbar.php"); ?>

<div class="container my-4">
    <h2 class="mb-4">School Timetable</h2>

    <!-- Select Class & Section Form -->
    <form method="GET" class="row g-3 mb-4">
        <div class="col-auto">
            <select name="class" class="form-select" required>
                <option value="">Select Class</option>
                <?php foreach ($classes as $class): ?>
                <option value="<?= htmlspecialchars($class) ?>" <?= ($selected_class == $class) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($class) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <select name="section" class="form-select" required>
                <option value="">Select Section</option>
                <?php foreach ($sections as $section): ?>
                <option value="<?= htmlspecialchars($section) ?>" <?= ($selected_section == $section) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($section) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-secondary">Load Timetable</button>
        </div>
    </form>

    <?php if (!empty($message)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if ($selected_class && $selected_section): ?>

    <form method="POST">
        <!-- Pass selected class & section to POST -->
        <input type="hidden" name="class" value="<?= htmlspecialchars($selected_class) ?>">
        <input type="hidden" name="section" value="<?= htmlspecialchars($selected_section) ?>">

        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Subject</th>
                    <th>Teacher</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($timetable) === 0): ?>
                <tr><td colspan="4">No timetable found for <?= htmlspecialchars($selected_class) ?> - <?= htmlspecialchars($selected_section) ?></td></tr>
                <?php endif; ?>
                <?php foreach ($timetable as $i => $slot): ?>
                <tr>
                    <td>
                        <input
                            type="time"
                            name="start_time[]"
                            class="form-control"
                            value="<?= htmlspecialchars(substr($slot['start_time'],0,5)) ?>"
                            required
                        />
                    </td>
                    <td>
                        <input
                            type="time"
                            name="end_time[]"
                            class="form-control"
                            value="<?= htmlspecialchars(substr($slot['end_time'],0,5)) ?>"
                            required
                        />
                    </td>
                    <?php if (stripos($slot['subject'], 'Lunch') !== false): ?>
                        <td colspan="2" class="table-warning fw-bold"><?= htmlspecialchars($slot['subject']) ?></td>
                    <?php else: ?>
                        <td>
                            <input
                                type="hidden"
                                name="id[]"
                                value="<?= $slot['id'] ?>"
                            />
                            <input
                                type="text"
                                name="subject[]"
                                class="form-control"
                                value="<?= htmlspecialchars($slot['subject']) ?>"
                                required
                            />
                        </td>
                        <td>
                            <input
                                type="text"
                                name="teacher[]"
                                class="form-control"
                                value="<?= htmlspecialchars($slot['teacher']) ?>"
                                required
                            />
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
    </form>

    <?php endif; ?>
</div>

<?php include("includes/footer.php"); ?>
