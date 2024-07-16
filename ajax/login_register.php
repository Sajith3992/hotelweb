<?php

    require ('../Admin/inc/db_config.php');
    require ('../Admin/inc/essentials.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


   session_start();


    function send_mail($uemail,$name,$token)
    {
        require ('../PhpMailer/Exception.php');
        require ('../PhpMailer/PHPMailer.php');
        require ('../PhpMailer/SMTP.php');


        $mail = new PHPMailer(true);

        try {
            //Server settings
            
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'k3992.sajith@gmail.com';                     //SMTP username
            $mail->Password   = 'oqghlfrartsvzlcm';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('k3992.sajith@gmail.com', 'KaluWeb');
            $mail->addAddress($uemail,$name);    
           
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML   <a href='email_confirm.php?email=$uemail&token=$token'>Verify</a>
            $mail->Subject = 'Verification Code -->>';
            $mail->Body    = "Thanks for registration!
            Click the link below to verify the email address
            
            <a href='".SITE_URL."email_confirm.php?email_confirmation&email=$uemail&token=$token"."'>Verify </a>"
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

        if(!send_mail($data['email'],$data['name'],$token))
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

?>

