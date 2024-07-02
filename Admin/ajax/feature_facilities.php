<?php
    require('../inc/db_config.php');
    require('../inc/essentials.php');
    adminLogin();

    //features
    if(isset($_POST['add_feature'] ))
    {
        $frm_data = filtration($_POST);

        $q = "INSERT INTO `feature`(`name`) VALUES (?)";
        $values = [$frm_data['name']];
        $res = insert($q,$values,'s');
        echo $res;

    }

    if(isset($_POST['get_features']))
    {
        $res = selectAll('feature');
        $i =1;
        while($row = mysqli_fetch_assoc($res))
        {
            $path = ABOUT_IMG_PATH;
            echo <<<data
                <tr>
                <td>$i</td>
                <td>$row[name]</td>
                <td>
                 <button type="button" onclick="rem_feature($row[id])" class="btn btn-danger btn-sm shadow-none">
                    <i class="bi bi-trash3-fill"></i>   Delete
                  </button>
                </td>
                </tr>
            data;
            $i++;
        }
        
    }

    if(isset($_POST['rem_feature'])){

        $frm_data = filtration($_POST);
        $values = [$frm_data['rem_feature']];

        $check_q = select('SELECT * FROM `room_features` WHERE `features_id`=?',[$frm_data['rem_feature']],'i');

        if(mysqli_num_rows($check_q)==0){

            $q = "DELETE FROM `feature` WHERE `id`=?";
            $res = delete($q,$values ,'i');
            echo $res;
    
        } else{
            echo 'room_added';
        }
    }


    //facilities 

    if(isset($_POST['add_facility'] ))
        {
            $frm_data = filtration($_POST);
    
            $img_r = uploadSvgImage($_FILES['icon'],FACILITIES_FOLDER);
    
            if($img_r == 'inv_img'){
                echo $img_r;
            }
            elseif($img_r == 'inv_size'){
                echo $img_r;
            }
            elseif($img_r == 'upd_failed'){
                echo $img_r;
            }
            else{
                $q = "INSERT INTO `facilities`(`icon`,`name`,`description`) VALUES (?,?,?)";
                $values = [$img_r,$frm_data['name'],$frm_data['desc']];
                $res = insert($q,$values,'sss');
                echo $res;
            }
    }


    if(isset($_POST['get_facility']))
    {
        $res = selectAll('facilities');
        $i =1;
        $path = FACILITIES_IMG_PATH;

        while($row = mysqli_fetch_assoc($res))
        {
            
            echo <<<data
                <tr>
                    <td class="align-middle">$i</td>
                    <td><img src="$path$row[icon]" width="60px"></td>
                    <td>$row[name]</td>
                    <td>$row[description]</td>
                    <td>
                        <button type="button" onclick="rem_facitity($row[id])" class="btn btn-danger btn-sm shadow-none">
                            <i class="bi bi-trash3-fill"></i>   Delete
                        </button>
                    </td>
                </tr>
            data;
            $i++;
        }
        
    }

    if(isset($_POST['rem_facitity'])){

        $frm_data = filtration($_POST);
        $values = [$frm_data['rem_facitity']];

        $check_q = select('SELECT * FROM `room_facilities` WHERE `facility_id`=?',[$frm_data['rem_facitity']],'i');

        if(mysqli_num_rows($check_q)==0){

            $pre_q = "SELECT * FROM `facilities` WHERE `id`=?";
            $res = select($pre_q,$values,'i');
            $img = mysqli_fetch_assoc($res);
    
            if(deleteImage($img['icon'],FACILITIES_FOLDER))//delete path folder
            {
                $q = "DELETE FROM `facilities` WHERE `id`=?";
                $res = delete($q,$values ,'i');
                echo $res;
            }
            else{
                echo 0;
            }

        }else{
            echo 'room_added';
        }




        
    }


?>