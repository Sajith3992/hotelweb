    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/common.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    

    <?php

      require('admin/inc/db_config.php');
      require('admin/inc/essentials.php');

      $contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
      $settings_q = "SELECT * FROM `setting` WHERE `sr_no`=?";
      $values = [1];
      $contact_r = mysqli_fetch_assoc(select($contact_q,$values,'i'));
      $settings_r = mysqli_fetch_assoc(select($settings_q,$values,'i'));


      // $contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
      // $values = [1];
      // $contact_r = mysqli_fetch_assoc(select($contact_q,$values,'i'));



    ?>