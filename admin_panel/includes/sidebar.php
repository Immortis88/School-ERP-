<div class = "sidebar">
        <a href="#" class="brand d-flex align-items-center">
            <img src="../images/logo.jpg" alt="ERP Logo img">
            <span class="text">ERP</span>
        </a>
        <ul class="side-menu list-unstyled mt-3">
            <li class="active"><a href="ad_dashboard.php" ><i class="bx bxs-dashboard"></i>Dashboard</a></li>
            <li><a href="teacher.php" ><i class="bx bxs-user-rectangle"></i>Teacher</a></li>
            <li><a href="student.php" ><i class="bx bxs-user-detail"></i>Student</a></li>
            <li><a href="attendence.php" ><i class="bx bx-list-check"></i>Attendance</a></li>
            <li><a href="timetable.php" "><i class="bx bx-table"></i>Time Table</a></li>
            <li><a href="noticeboard.php" ><i class="bx bx-bookmark"></i>Notice Board</a></li>
            <li><a href="marks.php" ><i class="bx bx-paste"></i>Marks</a></li>
            <li><a href="subjects.php" ><i class="bx bx-book-bookmark"></i>Subjects</a></li>
            <li><a href="syllabus.php" ><i class="bx bx-file-blank"></i>Syllabus</a></li>
            <li><a href="notes.php" ><i class="bx bx-note"></i>Notes</a></li>
            <li><a href="buses.php" ><i class="bx bxs-bus"></i>Bus Service</a></li>
            <li><a href="settings.php" ><i class="bx bx-cog"></i>Settings</a></li>
        </ul>
        <ul class="side-menu list-unstyled mt-3">
            <li>
                <a class="logout" data-bs-toggle="modal" data-bs-target="#logout-modal" href="logout.php">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <form method="POST" action="admin_panel/logout.php">
                    <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                    Do you really want to logout?
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Logout</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
</div>