
    let feature_s_form = document.getElementById('feature_s_form');
    let facility_s_form = document.getElementById('facility_s_form');

    feature_s_form.addEventListener('submit', function(e){
        e.preventDefault();
        add_feature();
    })


    function add_feature(){

        let data = new FormData();
        data.append('name', feature_s_form.elements['feature_name'].value);//.elements['feature_name'] like a get a id 
        
        data.append('add_feature','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/feature_facilities.php", true);

        xhr.onload = function(){

        
        var myModal = document.getElementById('feature-s')
        var modal = bootstrap.Modal.getInstance(myModal)
        modal.hide();

        if(this.responseText == 1){

            alert('success','Features has been Added !');
            feature_s_form.elements['feature_name'].value='';
            get_features();
        }
    
        else{
            alert('error','Something Wentwrong ?');
        }


        }

        xhr.send(data);

    }


    function get_features(){

        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/feature_facilities.php", true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function(){
            document.getElementById('features-data').innerHTML = this.responseText;//table-body id
        }

        xhr.send('get_features');
    }

   
    function rem_feature(val){

        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/feature_facilities.php", true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function(){
        if(this.responseText ==1){
            alert('success','Featured removed');
            get_features();
        }
        else if(this.resposeText == 'room_added'){
            alert('success','Featured Added in Room !');
        }
        else{
            alert('error','Something went wrong');
        }

        }

        xhr.send('rem_feature='+val);
    }

    // facility function 

    facility_s_form.addEventListener('submit', function(e){
        e.preventDefault();
        add_facility();
    })

    function add_facility(){

        let data = new FormData();
        
        data.append('icon', facility_s_form.elements['facility_icon'].files[0]);
        data.append('name', facility_s_form.elements['facility_name'].value);//.elements['facility_name'] like a get a id 
        data.append('desc', facility_s_form.elements['facility_desc'].value);

        data.append('add_facility','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/feature_facilities.php", true);

        xhr.onload = function(){


        var myModal = document.getElementById('facility-s')
        var modal = bootstrap.Modal.getInstance(myModal)
        modal.hide();

        if(this.responseText == 'inv_img'){

            alert('error', "Only Svg images are allowed");
            }
            else if(this.responseText == 'inv_size'){
            alert('error','Image Should be less than 1MB');
            }
            else if(this.responseText == 'upd_failed'){
            alert('error','Image Uploaded Failed !')
            }
            else{
            alert('success','Facility image has been uploaded');
            facility_s_form.reset();

            get_facility();

            }


        }

        xhr.send(data);

    }

    function get_facility(){

        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/feature_facilities.php", true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function(){
            document.getElementById('facilities-data').innerHTML = this.responseText;//table-body id
        }

        xhr.send('get_facility');
    }

    function rem_facitity(val){

        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/feature_facilities.php", true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function(){
        if(this.responseText ==1){
            alert('success','Facilities removed');
            get_facility();
        }
        else if(this.resposeText == 'room_added'){
            alert('success','Facilities Added in Room !');
        }
        else{
            alert('error','Something went wrong');
        }

        }

        xhr.send('rem_facitity='+val);
    }

     window.onload = function (){
            get_features();
            get_facility();
    }




