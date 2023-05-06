<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
    require_once('./user_management/user_db.php');
    $error = '';

    $user = '';
    $pass = '';

    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($pass)) {
            $error = 'Please enter your password';
        }
        else if (strlen($pass) < 6) {
            $error = 'Password must have at least 6 characters';
        }
        else {
            $data=validate_login($user,$pass);
            if($data['code']===3 || $data['code']===1 || $data['code']===2){
                $error=$data['message'];
            }
            else if($data){
                $_SESSION['user']=$data['username'];
                $_SESSION['email']=$data['email'];
                $_SESSION['fullname']=$data['firstname']." ".$data['lastname'];
                $_SESSION['role']=$data['role'];
                header('Location: index.php');
                exit();
            }
            else{
                $error='Invalid password or username';
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
		body {
			background-image: url('images/backgroundlogin.jpg');
			background-size: cover;
		}
	</style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5" style="color: #222222">
            <h3 class="text-center mt-5 mb-3" style="color: white">User Login</h3>
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input value="<?= $user ?>" name="user" id="user" type="text" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input name="pass" value="<?= $pass ?>" id="password" type="password" class="form-control" placeholder="Password">
                </div>
                
                <div class="form-group">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button class="btn btn-success px-5">Login</button>
                </div>
                <div class="form-group">
                    <p>Don't have an account yet? <a href="./register.php">Register now</a>.</p>
                    <p>Back  <a href="./index.php">Home Page</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
