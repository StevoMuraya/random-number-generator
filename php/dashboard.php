<?php include "session.php";?>
<?php include "dbcon.php";?>
<?php include "header.php";?>

<?php
    $query = mysqli_query($link, "SELECT * FROM users WHERE user_id = $session_id") or die(mysqli_error($link));
    $row = mysqli_fetch_array($query);
?>
  <body>
    <div class="login-container">
      <div class="login-panel dash">
        <div class="panel-body dash">
            <div class="dashboard-content">
                <h5 class="username">Hello <?php echo $row['fullname'];?></h5>
                <p class="text-content">Welcome to random generator system. This system will allow you to get a random number based on a range of 0 to 30, and sort the numbers from lowest to highest based on each user.</p>
                <div class="dash-options">
                        
                <?php 
                    if ($row['random_num'] > 0) {
                ?>
                    <button class="btn generate disabled" disabled>Generate No.</button>
                <?php
                    }else{
                ?>
                    <form
                    action="execution.php"
                    method="post"
                    class="form-action"
                    id="fileForm"
                    role="form"
                    >
                        <input type="text" name="user_id" value="<?php echo $row['user_id'];?>" style="display: none;" >
                        <button name="generate" class="btn generate">Generate No.</button>
                    </form>
                <?php
                    }
                ?>
                </div>
                <div class="display-result">
                    Your Selected Number is:
                    
                    <?php
                            $num = $row['random_num'];
                            $new_num = str_pad($num, 2, '0', STR_PAD_LEFT);
                        ?>
                    <h1 class="result-num"><?php echo $new_num;?></h1>
                </div>
                <div class="users-list">
                    
                    <?php
                        $query = mysqli_query($link, "SELECT * FROM users WHERE random_num !=0 ORDER BY random_num ASC") or die(mysqli_error($link));
                        $count = 0;
                        while ($row2 = mysqli_fetch_array($query)) 
                        {
                            $count++;
                        }
                        if ($count == 0) {
                    ?>
                    <?php
                        }else{
                    ?>
                    <h3 style="text-align: center;">Users with generated numbers</h3>
                    <?php
                        }
                    ?>
                    
                    <?php
                        $query = mysqli_query($link, "SELECT * FROM users WHERE random_num !=0 ORDER BY random_num ASC") or die(mysqli_error($link));
                        $count = 1;
                        while ($row2 = mysqli_fetch_array($query)) 
                        {
                    ?>
                    <div class="user-card">
                        <h4 class="user-name"><?php echo $count?></h4>
                        <img src="./images/user-img.png" alt="">
                        <h4 class="user-name"><?php echo $row2['fullname'];?></h4>
                        <?php
                            $num = $row2['random_num'];
                            $new_num = str_pad($num, 2, '0', STR_PAD_LEFT);
                        ?>
                        <h4 class="num-display"><?php echo $new_num;?></h4>
                    </div>
                    <?php  
                        $count++;  
                        }
                    ?>
                </div>
                <div class="users-list">
                    
                    <?php
                        $query = mysqli_query($link, "SELECT * FROM users WHERE random_num =0 ORDER BY random_num ASC") or die(mysqli_error($link));
                        $count = 0;
                        while ($row2 = mysqli_fetch_array($query)) 
                        {
                            $count++;
                        }
                        if ($count == 0) {
                    ?>
                    <?php
                        }else{
                    ?>
                    <h3 style="text-align: center;">Users without generated numbers</h3>
                    <?php
                        }
                    ?>
                    
                    
                    <?php
                        $query = mysqli_query($link, "SELECT * FROM users WHERE random_num =0 ORDER BY random_num ASC") or die(mysqli_error($link));
                        $count = 1;
                        while ($row2 = mysqli_fetch_array($query)) 
                        {
                    ?>
                    <div class="user-card not-selected">
                        <img src="./images/user-img.png" alt="">
                        <h4 class="user-name"><?php echo $row2['fullname'];?></h4>
                        <?php
                            $num = $row2['random_num'];
                            $new_num = str_pad($num, 2, '0', STR_PAD_LEFT);
                        ?>
                    </div>
                    <?php  
                        $count++;  
                        }
                    ?>
                <div class="logout option">
                    <a href="logout.php" class="btn logout">Logout</a>
                </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
