<?php
    require('../Admin/inc/db_config.php');
    require('../Admin/inc/essentials.php');
    require('../inc/sendgrid/sendgrid-php.php');


    function send_mail($email,$name,$token)
    {
        $email = new\SendGrid\Mail\Mail();
        $email->setFrom("sajith.lexmo@gmail.com","Kaluwara Web");
        $email->setSubject("Account Varification");

        $email->addTo($email,$name);
       
        $email->addContent(
            "text/html",
            "Click the link to confirm you email: <br>
            <a href='"."'>
            Click Here 
            </a>
            "
        );

        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try{
            $response = $sendgrid->send($email,$name);
            print $response->statusCode() ."\n";
            print_r($response->headers());
            print $response->body() ."\n";
        }catch(Exception $e){
            echo 'caugh exception:'. $e->getMessage() ."\n";
        }
    }



    
   $data = filtration($_POST);

   //match password and confirm passwrd filed

   if($data['pass'] !=$data['cpass'])
   {
    echo 'pass_mismatch';
    exit;
   }

   //check user exits or not

   $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? AND `phonenum`=? LIMIT 1",
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
   send_mail($data['email'],$data['name'],$token);
?>