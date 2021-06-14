<?php
 session_start();
 include_once "dbcon.php";
 global $link;
if (isset($_POST["user_reg"])) {
	$fullname = filter_var($_POST['fullname'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
	$email = filter_var($_POST['email'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
	$phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
	$password = filter_var($_POST['password'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
    $pass = md5($password);

    $sql_email_phone = mysqli_query($link,"SELECT * FROM users WHERE email = '$email' OR phone = '$phone'");
    $data_match = mysqli_num_rows($sql_email_phone);

    if ($data_match > 0) {
        echo "<script>

        if (confirm('User with that Email or Phone Number already exists. Please register using another email or phone number')) {
            window.location = 'sign-up.html';
        }
        </script>";
    }else{
        $sql_reg = mysqli_query($link, "INSERT INTO users(fullname,email,phone,password) 
        VALUES('".$fullname."', '".$email."','".$phone."','".$pass."')") or die (mysqli_error($link));
        
        $sql = mysqli_query($link,"SELECT * FROM users WHERE email='$email' and password ='$pass'")
        or die (mysqli_error($link));
        # make sure the person exists

        $count = mysqli_num_rows($sql);
        $row = mysqli_fetch_array($sql);
            if ($count > 0) {
                $_SESSION['user_id'] = $row['user_id'];			
                $id = $row['user_id'];
                $fullname= $row['fullname'];

                header("location:dashboard.php");
                
            }else{
                echo "
                <script>

                    if (confirm('Incorrect Email or Password used, Please try again...')) {
                        window.location = './';
                    }
                </script>";
            }
    }
 }else if (isset($_POST["login"])) {
	$email = filter_var($_POST['email'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
	$password = filter_var($_POST['password'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
 	$pass = md5($password);

 	$sql = mysqli_query($link,"SELECT * FROM users WHERE email='$email' and password ='$pass'")
     or die (mysqli_error($link));
 	# make sure the person exists

 	$count = mysqli_num_rows($sql);
 	$row = mysqli_fetch_array($sql);
		if ($count > 0) {
			$_SESSION['user_id'] = $row['user_id'];			
            $id = $row['user_id'];
			$fullname= $row['fullname'];

			header("location:dashboard.php");
			
		}else{
			echo "
			<script>

				if (confirm('Incorrect Email or Password used, Please try again...')) {
					window.location = './';
				}
			</script>";
		}
 }else if (isset($_POST["generate"])) {
	$user_id = filter_var($_POST['user_id'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
    $random_num = mt_rand(1,50);
    

    function update_db($random_new,$user_id){
        global $link;
        include "dbcon.php";

        mysqli_query($link, "UPDATE users set random_num = '$random_new' WHERE user_id = '$user_id'") or die (mysqli_error($link));
        
			echo "
			<script>
					window.location = './dashboard.php';
			</script>";
    }

    function check($random_new,$user_id){
        global $link;
        include "dbcon.php";
        $random = mysqli_query($link,"SELECT * FROM users WHERE random_num = '$random_new'");
        $data_match = mysqli_num_rows($random);

        if ($data_match > 0) {
            random_num($user_id);
        }else{
            update_db($random_new,$user_id);
            // echo "Good to go: ".$random_new;
        }
    }

    check($random_num,$user_id);

    function random_num($user_id){
        $random_new = mt_rand(1,50);
        check($random_new,$user_id);
    }

    

 }

?>