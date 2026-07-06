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

  </head>
<body class="bg-danger">
<!--element nav -->
<?php require("element/nav.php");   ?>
<!--element nav end-->

<div class="container ">
  <!--form coding  start -->
<div class="row">
  <div class="col-md-6"></div>
  <div class="col-md-6 p-5">
<form class="bg-light p-4 rounded color login_form">

  <h2 class="text-center">Login Now !</h2>
  
    <div class="my-2 email_con">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" class="form-control" required>
      <i class="fa fa-circle-notch fa-spin loader_icon d-none"></i>
  </div>

  <div class="my-2 pass_con">
    <label for="password">Password</label>
    <input type="password"name="password" class="form-control" id="password" required>
    <i class="fa fa-eye pass_icon"></i>
  </div>

  
  <div class="text-center">
      <button class="btn btn-primary w-50 login_btn">Login Now !</button>
  </div>

  <div class="msg"></div>
</form>

<!--start coding activation code;-->
<form class="bg-light p-4 rounded color activation_form d-none" autocomplete="off">
  <h2 class="text-center mb-4">Activate Your  Code !</h2>
  
  <div class="mb-4">
    <label for="activation_code" class="form-label">Activation Code</label>
    <input type="text" id="activation_code" class="form-control"required>
    </div>

    <div class="text-center">
      <button class="btn btn-primary w-50 activation_btn">Activate Now !</button>
    </div>

    
    <div class="activation_msg"></div>
</form>

<!--end  coding activation code;-->

  </div>
</div>


</div>
<!--form coding end-->

<!--javascript start coding;-->
<script>
    $(document).ready(function(){

      //show password;
    $(".pass_icon").click(function(){
      if($("#password").attr("type")=="password")
    {
        $("#password").attr("type","text");
        $(this).css("color","black");
    }
    else
    {
        $("#password").attr("type","password");
        $(this).css("color","#ccc");
    }
    })
    //show password end;
        $(".login_form").submit(function(e){
            e.preventDefault();
            $.ajax({
                type:"POST",
                url:"php/user_login.php",
                data:{
                    email:$("#email").val(),
                    password:$("#password").val()
                },
                beforeSend:function(){
                    $(".login_btn").attr("disabled","disabled");
                    $(".login_btn").html("Please wait...");
                },
                success:function(response){
                    $(".login_btn").removeAttr("disabled");
                    $(".login_btn").html("Login Now !");
                    
                    if(response.trim()=="success")
                    {
                        window.location="profile.php";
                    }
                    else if(response.trim()=="pending")
                    {
                        $(".login_form").addClass("d-none");
                        $(".activation_form").removeClass("d-none");
                    }
                    else if(response.trim()=="Wrong password")
                    {
                        var div =document.createElement("DIV");
                        div.className="alert alert-danger mt-3";
                        div.innerHTML="Wrong password !";
                        $(".msg").append(div);
                        
                        setTimeout(function(){
                            $(".msg").html("");

                        },2500);
                    }
                    else if(response.trim()=="user not found")
                    {
                        var div = document.createElement("DIV");
                        div.className="alert alert-warning mt-3";
                        div.innerHTML="User Not Registered!";
                        $(".msg").append(div);
                        setTimeout(function(){
                            $(".msg").html("");
                        },2500);
                    }
                
                }
            })
        });

//activation coding start;
$(".activation_form").submit(function(e){
  e.preventDefault();
  $.ajax({
    type:"POST",
    url:"php/check_activation_code.php",
    data:{
      email:$("#email").val(),
      act:$("#activation_code").val()
    },
    beforeSend:function(){
      $(".activation_btn").html("Checking Activation Code...");
      $(".activation_btn").attr("disabled","disabled");
    },
    success:function(response){
      $(".activation_btn").html("Activate Now !");
      $(".activation_btn").removeAttr("disabled");
      if(response.trim() =="active")
    {
      var div= document.createElement("DIV");
      div.className="alert alert-success mt-3";
      div.innerHTML="Account Activated!";
      $(".activation_msg").append(div);
      
      setTimeout(function(){
        $(".activation_msg").html("");
          window.location="login.php";
      },2500);
    }
    else
    {
      var div = document.createElement("DIV");
          div.className="alert alert-danger mt-3";
          div.innerHTML= response;
          $(".activation_msg").append(div);

          setTimeout(function(){
            $(".activation_msg").html("");
            
          },2500);
    }
    }
  })
})

//activation coding end;
    })
</script>
<!--javascript end coding;-->
</body>
</html>