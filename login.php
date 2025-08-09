


<!DOCTYPE html>
<html>
<head>
	<title>Login Form</title>
	<link rel="stylesheet" type="text/css" href="login_page.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<img class="wave" src="images/wave.png">
	<div class="container">
		<div class="img">
			<img src="images/Avatar.png" >
		</div>
		<div class="login-content">
			<form action="login_backend.php" method="post">
				<img src="images/avatar.svg">
				<h2 class="title">Welcome</h2>
           		<div class="input-div one">
    				<div class="i">
        			<i class="fas fa-user"></i>
    			</div>
    		<div class="div">
        		<input type="email" class="input" name = "username" placeholder="Username" required>
    		</div>
			</div>
			<div class="input-div pass">
    			<div class="i">
        		<i class="fas fa-lock"></i> </div>
    			<div class="div">
        		<input type="password" class="input" name = "password" placeholder="Password" required>
    		</div>
			
			</div>
				<!-- Forgot passoword feature comming soon-->
            	<a href="#">Forgot Password?</a> 
            	<input type="submit" class="btn " value="Login">
            </form>
        </div>
    </div>
	<div class='toast-container position-fixed text-success border-0 bottom-0 end-0 p-3 ' style="z-index: 9000;">
        <div id='liveToast' class='toast bg-success' role='alert' aria-live='assertive' aria-atomic='true' style="color:black;">
            <div class='d-flex'>
                <div class='toast-body' id="toast-alert-message"></div>
                <button type='button' class='btn-close me-2 m-auto text-danger' data-bs-dismiss='toast' aria-label='Close'></button>
            </div>
        </div>
    </div> 

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="js/toast-script.js"></script>
</body>
</html>