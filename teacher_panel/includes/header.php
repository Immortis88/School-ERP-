<?php include("../assest/nosessionredirect.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css">
    <title>ERP Dashboard</title>
</head>
<body>
    <div class='toast-container position-fixed text-success bottom-0 end-0 p-3' style="z-index: 9000;">
        <div id='liveToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' style="color:black;">
            <div class='d-flex'>
                <div class='toast-body' id="toast-alert-message">
                
                </div>
            <button type='button' class='btn-close me-2 m-auto text-danger' data-bs-dismiss='toast' aria-label='Close'></button>
            </div>
            </div>
        </div>
    
    
 