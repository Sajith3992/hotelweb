<!-- Footer -->

<div class="container-fluid bg-white mt-5">
  <div class="row">
    <div class="col-lg-4 p-4">
     <h3 class="h-font fw-bold fs-3 mb-2">Kaluwara Resort</h3>
     <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
      Assumenda animi quod mollitia ab,
       quos ut atque ea fugit delectus eligendi?
      </p>
    </div>
    <div class="col-lg-4 p-4">
    <h5 class="mb-3">Links</h5>
    <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a><br>
    <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a><br>
    <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Facilities</a><br>
    <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact Us</a><br>
    <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About Us</a>
    </div>
    <div class="col-lg-4 p-4">
      <h5 class="mb-3">Follow Us</h5>
      <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block mb-2 text-dark text-decoration-none mb-2">
      <i class="bi bi-facebook"></i>  Facebook
    </a>
    <?php
       if($contact_r['insta']!=''){
          echo <<<data
             <a href="contact_r[insta]" class="d-inline-block text-dark fs-5 me-2">
                <i class="bi bi-instagram me-1"></i> Instagram
             </a>
           data;
       }
      ?>
      <?php
       if($contact_r['twit']!=''){
          echo <<<data
             <a href="contact_r[twit]" class="d-inline-block text-dark fs-5 me-2">
                <i class="bi bi-twitter-x me-1"></i> Twitter
             </a>
           data;
       }
      ?>
      <?php
       if($contact_r['tiktok']!=''){
          echo <<<data
             <a href="contact_r[tiktok]" class="d-inline-block text-dark fs-5 me-2">
                <i class="bi bi-tiktok"></i>Tik-tok 
             </a>
           data;
       }
      ?>
      <?php
       if($contact_r['linked_in']!=''){
          echo <<<data
             <a href="contact_r[linked_in]" class="d-inline-block text-dark fs-5 me-2">
                  <i class="bi bi-linkedin"></i></i>LinkedIn 
             </a>
           data;
       }
      ?>

    </div>
  </div>
</div>

<h6 class="text-center bg-dark text-white p-3 m-2">Design and Developed by Sajith Webdev</h6>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
      function setActive()
      {
        let navbar = document.getElementById('nav-bar');
        let a_tag = document.getElementsByTagName('a');

        for(i=0; i<a_tag.length; i++){
          let file = a_tag[i].href.split('/').pop();
          let file_name = file.split('.')[0];

          if(document.location.href.indexOf(file_name) >=0){
            a_tag[i].classList.add('active');
          }
        }
      }

      let register_form = document.getElementById('register-form');

      register_form.addEventListener('submit',(e)=>{
        e.preventDefault();

        let data = new FormData();

        data.append('name',register_form.elements['name'].value);//form input name
        data.append('"email',register_form.elements['"email'].value);
        data.append('phonenum',register_form.elements['phonenum'].value);
        data.append('address',register_form.elements['address'].value);
        data.append('pincode',register_form.elements['pincode'].value);
        data.append('dob',register_form.elements['dob'].value);
        data.append('pass',register_form.elements['pass'].value);
        data.append('cpass',register_form.elements['cpass'].value);
        data.append('profile',register_form.elements['profile'].file[0]);
        data.append('register','');

        var myModal = document.getElementById('registerModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/login_register.php", true);
        // xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function(){
         
        }

        xhr.send(data);

      });



      setActive();
</script>