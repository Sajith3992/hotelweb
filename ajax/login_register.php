<?php

    require ('../Admin/inc/db_config.php');
    require ('../Admin/inc/essentials.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    date_default_timezone_set("Asia/Colombo");


    session_start();


    function send_mail($uemail,$token,$type)
    {
        require ('../PhpMailer/Exception.php');
        require ('../PhpMailer/PHPMailer.php');
        require ('../PhpMailer/SMTP.php');

        if($type == "email_confirmation")
        {
            $page ='email_confirm.php';
            $subject = "Account Varification Link";
            $content = "Confitm Your email";
        }else{
            $page ='index.php';
            $subject = "Account Reset Link";
            $content = "Reset Your Account";
        }

        $mail = new PHPMailer(true);

        try {
            //Server settings
            
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = SENDMAIL_USER_NAME;                     //SMTP username
            $mail->Password   = SENDMAIL_USER_PASS;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom(SENDMAIL_USER_NAME, SENDMAIL_WEBSITE);
            $mail->addAddress($uemail);    
           
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML   <a href='email_confirm.php?email=$uemail&token=$token'>Verify</a>
            $mail->Subject = 'Verification Code -->>';
            $mail->Body    = "Thanks for registration!
            Click the link below to $content :<br>
            
            <a href='".SITE_URL."$page?$type&email=$uemail&token=$token"."'>Verify </a>"
            ;
           
        
            $mail->send();
            echo 'Message has been sent';
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }

    }

    


    if(isset($_POST['register'])){

        $data = filtration($_POST);

        //match password and confirm passwrd filed
    
        if($data['pass'] !=$data['cpass'])
        {
        echo 'pass_mismatch';
        exit;
        }
    
        //check user exits or not
    
        $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phonenum`=? LIMIT 1",
        [$data['email'],$data['phonenum']],"ss");
    
        if(mysqli_num_rows($u_exist)!=0)
        {
        $u_exist_fetch = mysqli_fetch_assoc($u_exist);
        echo($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
        exit;
        }


            //upload user image
        $img = uploadUserImage($_FILES['profile']);

        if($img == 'inv_img'){
            echo 'inv_img';
            exit;
        }
        else if($img == 'upload_faild')
        {
            echo 'upload_failed';
            exit;
        }

        $token = bin2hex(random_bytes(16));

        if(!send_mail($data['email'],$token,"email_confirmation"))
        {
            echo 'mail_failed !';
            exit;
        }

        $enc_pass = password_hash($data['pass'],PASSWORD_BCRYPT);

        $query = "INSERT INTO `user_cred`(`name`, `email`, `address`, `phonenum`, 
        `pincode`, `dob`,`profile`, `password`, `token`) 
         VALUES (?,?,?,?,?,?,?,?,?)";
    
        $values = [$data['name'],$data['email'],$data['address'],$data['phonenum'],
        $data['pincode'],$data['dob'],$img,$enc_pass,$token];

        if(insert($query,$values,'sssssssss'))
        
        {
            echo "<script>
                alert('Registration Successful');
                window.location.href='index.php';
            </script>
            ";
            
        }else
        {
            echo 
            "<script>
                alert('Check back again !!');
                window.location.href='index.php';
            </script>
            ";
        }


    }  
    
    
    if(isset($_POST['login'])){
        
        $data = filtration($_POST);

        $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR  `phonenum`=? LIMIT 1",
        [$data['email_mob'],$data['email_mob']],"ss");
    
        if(mysqli_num_rows($u_exist)==0)
        {
            echo 'inv_email_mob';
           
        }
        else{
            $u_fetch = mysqli_fetch_assoc($u_exist);

            if($u_fetch['is_verified']==0)
            {
                echo 'not_verified';
            }
            else if($u_fetch['status']==0)
            {
                echo 'inactive';
            }else{
                if(!password_verify($data['pass'],$u_fetch['password'])){
                    echo 'invalid_pass';
                }
                else{
                    session_start();
                    $_SESSION['login']= true;
                    $_SESSION['uId'] = $u_fetch['id'];
                    $_SESSION['uName'] = $u_fetch['name'];
                    $_SESSION['uPic'] = $u_fetch['profile'];
                    $_SESSION['uPhone'] = $u_fetch['phonenum'];
                    echo 1;

                }
            }
        }
       
        
    }


    if(isset($_POST['forgot_pass'])){
        $data = filtration($_POST);

        $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? LIMIT 1",
        [$data['email']],"s");
    
        if(mysqli_num_rows($u_exist)==0)
        {
            echo 'inv_email';
           
        }else
        {
            $u_fetch = mysqli_fetch_assoc($u_exist);

            if($u_fetch['is_verified']==0)
            {
                echo 'not_verified';
            }
            else if($u_fetch['status']==0)
            {
                echo 'inactive';
            }
            else
            {
                //send reset link email
                $token = bin2hex(random_bytes(16));

                if(!send_mail($data['email'],$token,'account_recovery')){
                    echo 'mail_failed';
                }
                else
                {
                    
                    $date = date("Y-m-d");

                    $query = mysqli_query($con,"UPDATE `user_cred` SET `token`='$token',`t-expire`='$date' 
                    WHERE `id`='$u_fetch[id]'");

                    if($query){
                        echo 1;
                    }
                    else
                    {
                        echo ' upd_failed';
                    }
                }
            }
        }
    }


    if(isset($_POST['recovery_user'])){
        $data = filtration($_POST);

       $enc_pass = password_hash($data['pass'],PASSWORD_BCRYPT);

       $query = "UPDATE `user_cred` SET `password`=?,`token`=? ,`t-expire`= ? 
                WHERE `email`=? AND `token`=? ";

        $values = [$enc_pass,null,null,$data['email'],$data['token']];

        if(update($query,$values,'sssss'))
        {
            echo 1;
        }else{
            echo 'failed';
        }
    }


?>

