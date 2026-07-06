<?php
session_start();

 if(empty($_SESSION['user']))
 {
    header("Location:login.php");
 }

require("php/db.php");

$user_email = $_SESSION['user'];

$user_sql ="SELECT * FROM users WHERE email='$user_email'";

$user_res = $db->query($user_sql);

$user_data = $user_res->fetch_assoc();

$user_name =  $user_data['name'];

$total_storage =$user_data['storage'];

$used_storage = $user_data['used_storage'];

$plan =$user_data['plans'];
$free_storage=0;
if($plan !="premium")
{
    $per = round(($used_storage*100)/$total_storage,2);
    $free_storage =$total_storage-$used_storage;
}

$user_id = $user_data['id'];
$tf ="user_".$user_id;

$p_status="";



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <style>
        .main-container
        {
            width:100%;
            height:100vh;
        }
        .left{
            width:17%;
            height:100%;
            background-color:#080429;
        }
        .right{
            width:83%;
            height:100%;
            overflow:auto;
        }
        .profile_pic{
            width:100px;
            height:100px;
            border:4px solid white;
            border-radius:100%;
        }
        .storage{
            width:80%;
        }
        .thumb{
            width:75px;
            height:75px;
        }
        .my_menu{
            list-style:none;
            padding:0;
            margin:0;
            width:100%;
        }
        .my_menu li{
            width:100%;
            padding:5px;
            color:white;
            padding-left:50px;
        }
        .my_menu li:hover{
            background-color:#fff;
            color:#080429;
            cursor:pointer;
        }
        .msg{
            width:100%;
            height:100vh;
            background-color:rgba(0,0,0, 0.6);
            position:fixed;
            top:0;
            left:0;
            display: flex;
            justify-content:center;
            align-items:center;

        }
        @media(max-width:992px){
            .right{
                width:100%;
            }
            .mobile_menu{
                position:fixed;
                top:0;
                left:0;
                background-color:#080429;
                width:0%;
                height:100vh;
                z-index:1000000000;
                overflow:auto;
                transition:0.4s;
            }
            .profile_pic{
            width:100px;
            height:100px;
            border:4px solid white;
            border-radius:100%;
        }
           
        }
    </style>
  </head>
<body >

<div class="main-container d-flex">
    <div class="left d-none d-lg-block">
        <!--profile_pic start main-conainer -->
        <div class="d-flex justify-content-center align-items-center flex-column pt-3">
                <div class="profile_pic d-flex justify-content-center align-items-center ">
                    <i class="fa fa-user text-white fs-1"></i>
                </div>
                <span class="text-white fs-4 mt-3"><?php echo $user_name; ?></span>
                <hr class="bg-white w-100">
                <button class="btn btn-light rounded-pill upload"><i class="fa fa-upload"></i>Upload file</button>
    <!--start coding upload progress bar-->
                <div class="progress storage mt-3 d-none u_pro">
                        <div class="progress-bar bg-primary upload_p"style="width:0%"></div>
                    </div>
                    <div class="upload_msg"></div>
    <!--end coding upload progress bar-->
    <!--start coding my files-->
                    <hr class="bg-light w-100">
                    <ul class="my_menu">
                        <li class="menu" p_link="my_files"><i class="fas fa-folder"></i>  My Files</li>
                        <li class="menu" p_link="f_files"><i class="fas fa-star"></i>  Favourite</li>
                        <li class="menu" p_link="buy_storage"><i class="fas fa-shopping-cart "></i>  Buy Storage</li>
                    </ul>
      <!--end coding my files-->   

                    <hr class="bg-light w-100">

                    <?php
                        if($plan != "premium")
                        {
                    ?>
                    <span class=" text-white mb-2"><i class="fas fa-database"></i>  STORAGE</span>
                    <div class="progress storage ">
                        <div class="progress-bar bg-primary pb"style="width:<?php echo $per?>%"></div>
                    </div>

                    <span class="text-light">
                        <span class="us"><?php echo $per; ?></span>MB/<?php echo $total_storage ?>MB</span>
                    <?php 
                        }
                        else{
                        ?>
                <span class=" text-white mb-2"> <i class="fas fa-database"></i>  STORAGE</span>  
                <span class="text-light">
                <span class="us"><?php echo round($used_storage,2);?></span>MB</span>
                <?php }?>
                <a href="php/logout.php" class="btn btn-light mt-3">Logout</a>
        </div>
        <!--profile_pic end main-conainer-->
    </div>
<!--left container coding end;-->

<!--mobile menu coding start-->
<div class="mobile_menu d-block d-lg-none">
    <i class="fas fa-times text-light fs-2 pt-3 ps-4 cut"></i>
        <!--profile_pic start main-conainer -->
        <div class="d-flex justify-content-center align-items-center flex-column pt-1">
                <div class="profile_pic d-flex justify-content-center align-items-center ">
                    <i class="fa fa-user text-white fs-1"></i>
                </div>
                <span class="text-white fs-4 mt-3"><?php echo $user_name; ?></span>
                <hr class="bg-white w-100">
                <button class="btn btn-light rounded-pill upload"><i class="fa fa-upload"></i>Upload file</button>
    <!--start coding upload progress bar-->
                <div class="progress storage mt-3 d-none u_pro">
                        <div class="progress-bar bg-primary upload_p"style="width:0%"></div>
                    </div>
                    <div class="upload_msg"></div>
    <!--end coding upload progress bar-->
    <!--start coding my files-->
                    <hr class="bg-light w-100">
                    <ul class="my_menu">
                        <li class="menu mm" p_link="my_files"><i class="fas fa-folder"></i>  My Files</li>
                        <li class="menu mm" p_link="f_files"><i class="fas fa-star"></i>  Favourite</li>
                        <li class="menu mm" p_link="buy_storage"><i class="fas fa-shopping-cart "></i>  Buy Storage</li>
                    </ul>
      <!--end coding my files-->   

                    <hr class="bg-light w-100">

                    <?php
                        if($plan != "premium")
                        {
                    ?>
                    <span class=" text-white mb-2"><i class="fas fa-database"></i>  STORAGE</span>
                    <div class="progress storage ">
                        <div class="progress-bar bg-primary pb"style="width:<?php echo $per?>%"></div>
                    </div>

                    <span class="text-light">
                        <span class="us"><?php echo $per; ?></span>MB/<?php echo $total_storage ?>MB</span>
                    <?php 
                        }
                        else{
                        ?>
                <span class=" text-white mb-2"> <i class="fas fa-database"></i>  STORAGE</span>  
                <span class="text-light">
                <span class="us"><?php echo round($used_storage,2);?></span>MB</span>
                <?php }?>
                <a href="php/logout.php" class="btn btn-light mt-3 mb-3">Logout</a>
        </div>
        <!--profile_pic end main-conainer-->
    </div>
<!--left container coding end;-->
<!--moble menu coding end-->
    <div class="right">
<!--nav coding searching-->        
    <nav class="navbar navbar-light bg-light p-3 shadow-sm sticky-top">
        <div class="container-fluid">
             <i class="fas fa-bars fs-4 bar  d-block d-lg-none  "></i>               

            <form class="d-flex ms-auto search_frm">
            <input class="form-control me-2" type="search" id="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary btn-sm" type="submit">Search</button>
            </form>
        </div>
</nav>
<!--nav coding searching end;--> 
         <div class="content p-4">
               
         </div>
         
    </div>
  <!--right container end;-->  

    </div>
<!--main-container-- end-->

<div class="msg d-none">

</div>
<?php

if($plan !="free")
{
    $ed =$user_data['expiry_date'];
    $cd = Date('Y-m-d');

    if($ed < $cd)
    {
        $p_status="deactivate";
        echo "<style>.upload,[p_link='my_files'],[p_link='f_files']{pointer-events:none;} </style>";
    }
    else
    {
        $p_status ="activate";
    }


}


?>
<script>
    $(document).ready(function(){
        $(".upload").click(function(){
            var input = document.createElement("INPUT");
            input.setAttribute("type","file");
            input.click();
            input.onchange=function(){
                $(".u_pro").removeClass("d-none");
                var file = new FormData();
                file.append("data",input.files[0]);
                var file_size = Math.floor(input.files[0].size/1024/1024);
                var free_storage= <?php echo $free_storage?>;
                var plan = "<?php echo $plan; ?>";
                
                function upload(){
                    $.ajax({
                    type:"POST",
                    url:"php/upload.php",
                    data:file,
                    processData:false,
                    contentType:false,
                    cache:false,
                    xhr:function(){
                        var request = new XMLHttpRequest();
                        request.upload.onprogress= function(e){
                            var loaded = (e.loaded/1024/1024).toFixed(2);
                            var total = (e.total/1024/1024).toFixed(2);
                            var upload_per =((loaded*100)/total).toFixed(0);
                            $(".upload_p").css("width",upload_per+"%");
                            $(".upload_p").html(upload_per+"%");
                        }
                        return request;
                    },
                    success:function(response){
                        var obj = JSON.parse(response);
                        $(".u_pro").addClass("d-none");
                        if(obj.msg =="File Upload Successfully")
                            {
                                var new_per =(obj.used_storage*100)/<?php echo $total_storage?>;
                                $(".us").html(obj.used_storage);
                                $(".pb").css("width",new_per+"%");

                                var div =document.createElement("DIV");
                                div.className ="alert alert-success mt-3";
                                div.innerHTML=obj.msg;
                                $(".upload_msg").append(div);
                                my_files();

                                setTimeout(function(){
                                    $(".upload_msg").html("");
                                    $(".upload_p").css("width","0%");
                                     $(".upload_p").html("");
                                },3000);

                                
                            }
                            else
                            {
                                var div =document.createElement("DIV");
                                div.className ="alert alert-danger mt-3";
                                div.innerHTML=obj.msg;
                                $(".upload_msg").append(div);
                                
                                setTimeout(function(){
                                    $(".upload_msg").html("");
                                    $(".upload_p").css("width","0%");
                                    $(".upload_p").html("");
                                },3000);
                            }
                        
                    }

                })
                }
                if(plan == "premium")
                {
                    upload();
                }
                else
                {
                    if(file_size<free_storage)
                        {
                            upload();
                        }

                
            // large size coding end;
                    else {
                                var div =document.createElement("DIV");
                                div.className ="alert alert-danger mt-3";
                                div.innerHTML="File Size Too Large.Kindly Purchase More Storage";
                                $(".upload_msg").append(div);
                                
                                setTimeout(function(){
                                    $(".upload_msg").html("");
                                    $(".upload_p").css("width","0%");
                                    $(".upload_p").html("");
                                    $(".u_pro").addClass("d-none");
                                },3000);
                            }
                            // large size coding end else;
            }
                }
                
            

        });
        //menu coding start my files;
        $(".menu").each(function(){
            $(this).click(function(){
                var page_link = $(this).attr("p_link");
                $.ajax({
                    type:"POST",
                    url:"php/pages/"+page_link+".php",
                    beforeSend:function(){
                        var div =document.createElement("DIV");
                        $(div).addClass("alert alert-primary fs-1 p-5 text-center");
                        $(div).html("<i class='fas fa-spinner fa-spin display-1'></i><br>Loading...");
                        $(".msg").html(div);
                        $(".msg").removeClass("d-none");
                    },
                    success:function(response){
                    $(".msg").addClass("d-none");
                    $(".content").html(response);
                    }

                })
                
            })
        })
         //menu coding end my files;

         
         //start coding files click refresh;
        function my_files()        
        {
           if("<?php echo $plan;?>" !="free"){

            
            if("<?php echo $p_status;?>" == "activate")
                {
                    $('[p_link="my_files"]').click();
                }
            else
            {
                $('[p_link="buy_storage"]').click();
            }
        }
        else
        {
            $('[p_link="my_files"]').click();
        }
            
        }
         my_files();

         //mobile menu cut coding;
        $(".cut").click(function(){
            $(".mobile_menu").css({"width":"0%"});
        })

        $(".bar").click(function(){
            $(".mobile_menu").css({"width":"75%"});
        })

        $(".mm").each(function(){
            $(this).click(function(){
                $(".mobile_menu").css({"width":"0%"});   
            })
        })
//search coding;
        $(".search_frm").submit(function(e){
            e.preventDefault();
            var query = $("#search").val();
            $.ajax({
                    type:"POST",
                    url:"php/pages/search.php",
                    data: {
                        query:query
                    },
                    beforeSend:function(){
                        var div =document.createElement("DIV");
                        $(div).addClass("alert alert-primary fs-1 p-5 text-center");
                        $(div).html("<i class='fas fa-spinner fa-spin display-1'></i><br>Loading...");
                        $(".msg").html(div);
                        $(".msg").removeClass("d-none");
                    },
                    success:function(response){
                    $(".msg").addClass("d-none");
                    $(".content").html(response);
                    }

                })
                

        })


         //end coding files click refresh;

    })

    
</script>
</body>
</html>