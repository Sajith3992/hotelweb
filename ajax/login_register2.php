<?php

    require('../inc/sendgrid/sendgrid-php.php');


    function send_mail($uemail,$name,$token)
    {
        $email = new\SendGrid\Mail\Mail();
        $email->setFrom("sajith.lexmo@gmail.com","Kaluwara Web");
        $email->setSubject("Account Varification");

        $email->addTo($uemail,$name);
       
        $email->addContent(
            "text/html",
            "Click the link to confirm you email: <br>
            <a href='".SITE_URL."email_confirm.php?email_confirmation&email=$uemail&token=$token"."'>
            Click Here 
            </a>
            "
        );

        $sendgrid = new \SendGrid(SENDGRID_API_KEY);

            try{
                $sendgrid->send($email);
                return 1;
            }
            catch(Exception $e)
            {
                return 0;
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
        `pincode`, `dob`, `profile`, `password`, `token`) 
         VALUES (?,?,?,?,?,?,?,?,?)";
    
        $values = [$data['name'],$data['email'],$data['address'],$data['phonenum'],
        $data['pincode'],$data['dob'],$img,$enc_pass,$token];

        if(insert($query,$values,'sssssssss'))
        {
            echo 1;
        }else
        {
            echo 'ins_faild';
        }


    }    





?>