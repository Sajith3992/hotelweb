<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaluwara Resort - Contact</title>

    <?php require('inc/links.php'); ?>
   
</head>
<body class="bg-light">
    

<?php require('inc/header.php'); ?>

<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">Contact Us</h2>
    <div class="h-line bg-dark"></div>

    <p class="text-center mt-3">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quia atque et 
        libero assumenda culpa reiciendis! Iure minus recusandae odio delectus?</p>
</div>




<div class="container">
    <div class="row">
        <div class="col-lg-6 col-mb-6 mb-5 px-4">
            <div class="bg-white rounded shadow p-4 ">
                <iframe class="w-100 rounded mb-4" height="320px" src="<?php echo $contact_r['iFrame'] ?>"  loading="lazy" ></iframe>
                <h5>Address</h5>
                <a href="<?php echo $contact_r['gmap'] ?>" target="_blank" class="d-inline text-decoration-none">
                    <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_r['address'] ?>
                </a>
             
                <h5 class="mt-4">Call Us</h5>

                    <a href="tel : +<?php echo $contact_r['phone1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                    <i class="bi bi-telephone-fill"></i>  +<?php echo $contact_r['phone1'] ?>
                    </a>
                  <br>
                  <?php
                    if($contact_r['phone2']!=''){
                        echo <<<data
                            <a href="tel : +$contact_r[phone2]" class="d-inline-block mb-2 text-decoration-none text-dark">
                                <i class="bi bi-telephone-fill"></i>  +$contact_r[phone2]
                            </a>
                        data;
                    }
                  ?>

        
                    <h5 class="mt-4">Email</h5>
                    <a href="mailto: araliyareso.info@gmail.com" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-envelope-at-fill"></i> <?php echo $contact_r['email'] ?>
                    </a>

                    <h5 class="mt-4">Follow Us</h5>
                    <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block text-dark fs-5 me-2">
                        <i class="bi bi-facebook me-1"></i> 
                    </a>
                    <?php
                        if($contact_r['insta']!=''){
                            echo <<<data
                                <a href="contact_r[insta]" class="d-inline-block text-dark fs-5 me-2">
                                    <i class="bi bi-instagram me-1"></i> 
                                </a>
                            data;
                        }
                    ?>
                    <?php
                        if($contact_r['twit']!=''){
                            echo <<<data
                                <a href="contact_r[twit]" class="d-inline-block text-dark fs-5 me-2 ">
                                    <i class="bi bi-twitter-x me-1"></i>  
                                </a>
                            data;
                        }
                    ?>
                    <?php
                        if($contact_r['tiktok']!=''){
                            echo <<<data
                            <a href="contact_r[tiktok]" class="d-inline-block text-dark fs-5 me-2">
                            <i class="bi bi-tiktok"></i> 
                            </a>
                            data;
                        }
                    ?>
                    <?php
                        if($contact_r['linked_in']!=''){
                            echo <<<data
                                <a href="contact_r[linked_in]" class="d-inline-block text-dark fs-5 ">
                                <i class="bi bi-linkedin"></i></i> 
                                </a>
                            data;
                        }
                    ?> 


            </div>
        </div>

        <div class="col-lg-4 col-mb-6 mb-5 px-4">
            <div class="bg-white rounded shadow p-4 ">
                
                <form method="post">
                    <h5>Send a message</h5>
                        <div class="mb-3">
                            <label  class="form-label" style="font-weight: 500;">Name</label>
                            <input name="name" required type="text" class="form-control shadow-none" >
                        </div>
                        <div class="mb-3">
                            <label  class="form-label" style="font-weight: 500;">Email </label>
                            <input name="email" required type="email" class="form-control shadow-none" >
                        </div>
                        <div class="mb-3">
                            <label  class="form-label" style="font-weight: 500;">Subject </label>
                            <input name="subject" required type="text" class="form-control shadow-none" >
                        </div>
                        <div class="mb-3">
                            <label  class="form-label" style="font-weight: 500;">Message </label>
                            <textarea name="message" required class="form-control shadow-none" rows="5" style="resize: none;"></textarea>
                        </div>
                        <button type="submit" name="send" class=" custom-bg text-bk mt-3 ">Send</button>
                </form>
            </div>
        </div>

    </div>
</div>

<?php

        if(isset($_POST['send'])){

            $frm_data = filtration($_POST);

            $q = "INSERT INTO `users_query`( `name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
            $values = [$frm_data['name'],$frm_data['email'],$frm_data['subject'],$frm_data['message']];

            $res = insert($q,$values,'ssss');
            if($res==1){
                alert('success','Mail Send');
            }
            
            else
            {
                alert('error','Please check again');
            }
            print_r($res);
        }

?>

<?php require('inc/footer.php'); ?>


</body>
</html>