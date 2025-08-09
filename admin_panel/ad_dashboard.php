
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>

<div class="modal fade" id="reminder-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Reminder</h1>
                <button type="button" class="close mr-2" data-bs-dismiss="modal" aria-label="Close"><i
                        class='bx bx-x'></i></button>
            </div>
            <div class="modal-body">

                <div class="container mr-3 ml-3">
                    <div class="alert alert-warning reminder-error" role="alert" style="min-height: 50px;display: none;">
                    Message can't be empty!
                    </div>
                    <div class="mb-3">
                        <!-- <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label> -->
                        <textarea class="form-control" id="reminder-msg" rows="3"></textarea>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary text-center _flex-container" onclick="addReminder()"> <i
                        class='bx bx-plus'></i>&nbsp;<strong>ADD</strong></button>
            </div>
        </div>
    </div>
</div>

<?php include("includes/navbar.php");?> 

<div class="content">
<main>
    <div class="header">
        <h1>Dashboard</h1> 
    </div>

<?php include("includes/footer.php");?>
