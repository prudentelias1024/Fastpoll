<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastPoll | Signup</title>
    <link rel="stylesheet" href="index.css">
    <script src="./jquery-3.6.0.js" defer></script>

</head>
<body>
<form id="signup_form"   class="w-full lg:w-1/3  lg:border lg:rounded-lg m-auto mt-[4em] px-6 lg:px-12 py-6 flex flex-col gap-[1em]">
       <div class="full w-full">
         <label class="font-[Outfit] text-[1em] font-bold" for="profile_pic">Profile Picture</label> 
         <input  class="w-full  h-12 border font-[Outfit] lg:p-4 rounded-sm font-bold"  accept='image/*'  type="file" name="profile_img" />
         <p id="profile_img_err_msg" class="error_msg font-[Outfit] text-sm   text-red-500  font-semibold  ">  </p>
      
     </div>

     <div class="full w-full">
         <label class="font-[Outfit] text-[1em] font-bold" for="fullname">Full Name</label> 
         <input  class="w-full  h-8 border font-[Outfit] lg:p-4 rounded-sm font-bold"   type="text" name="fullname" />
         <p id="fullname_err_msg" class=" font-[Outfit] text-sm   text-red-500  font-semibold ">   </p>
       
     </div>
   
    
       
     <div class="email">
         <label class="font-[Outfit] text-[1em] font-bold" for="email">Email</label> 
         <input  class="w-full h-8 border font-[Outfit] p-4 rounded-sm font-bold"   type="text" name="email" />
         <p id="email_err_msg" class="error_msg font-[Outfit] text-sm   text-red-500  font-semibold ">  </p>
      
     </div>
     <div class="phone_no">
         <label class="font-[Outfit] text-[1em] font-bold" for="username">Username</label> 
         <input  class="w-full h-8 border font-[Outfit] p-4 rounded-sm font-bold"   type="text" name="username" />
         <p id="username_err_msg" class="error_msg font-[Outfit] text-sm   text-red-500  font-semibold ">  </p>
      
     </div>

     <div class="full w-full">
         <label class="font-[Outfit] text-[1em] font-bold" for="dob">Date Of Birth</label> 
         <input  class="w-full  h-8 border font-[Outfit] lg:p-4 rounded-sm font-bold"   type="date" name="dob" />
         <p id="dob_err_msg" class="error_msg font-[Outfit] text-sm   text-red-500  font-semibold ">  </p>
      
     </div>
   
   
     <div class="password">
         <label class="font-[Outfit] text-[1em] font-bold" for="password">Password</label> 
         <input  class="w-full h-8 border font-[Outfit] p-4 rounded-sm font-bold" type="password" name="password"   /> 
         <p id="password_err_msg" class="error_msg font-[Outfit] text-sm  text-red-500  font-semibold ">  </p>
      
    </div>

     <div class="confirm_pass">
         <label class="font-[Outfit] text-[1em] font-bold" for="password_conf">Confirm Password</label> 
         <input  class="w-full h-8 border font-[Outfit] p-4 rounded-sm font-bold" type="password" name="password_conf"   /> 
         <p id="password_conf_err_msg" class="error_msg font-[Outfit] text-sm   text-red-500  font-semibold ">  </p>
      
    </div>
     <button onClick="submitForm(event)" class="bg-blue-500 text-white font-[Outfit] p-2 rounded-lg" name="signup" type="submit">Signup</button>
  
  <a class='font-[Sen] m-auto text-blue-500' href='./login.php'>Login Here?</a>
  </form>

    
<script>
    function submitForm(event){
        event.preventDefault()
      
        let formData = new FormData($('#signup_form')[0]);
        $.ajax({
            url: 'signupScript.php',
            type: 'POST',
            data: formData,
            processData:false,
            contentType:false,
            cache:false,
            dataType: 'text',

            success:  (response) =>{
                console.log(response)
                response = JSON.parse(response)
                if(response.success == false){
                    response.message.forEach((message) => {
                        if(message.fullname_error){
                            $('#fullname_err_msg').html(message.fullname_error)
                        }
                        
                        if(message.username_error){
                            $('#username_err_msg').html(message.username_error)
                        }
                        
                        if(message.email_error){
                            $('#email_err_msg').html(message.email_error)
                        }
                        
                        if(message.dob_error){
                            $('#dob_err_msg').html(message.dob_error)
                        }
                        
                        if(message.password_error){
                            $('#password_err_msg').html(message.password_error)
                        }
                        
                        if(message.password_conf_error){
                            $('#password_conf_err_msg').html(message.password_conf_error)
                        }
                        
                        if(message.profile_image_error){
                            $('#profile_img_err_msg').html(message.profile_image_error)
                        }
                        
                        $('#poll_form').show()
      
                        let markup = `<p id="err_msg" class="error_msg font-[Outfit] text-xl   text-red-500  font-semibold text-center "> ${message} </p>`
      
                        $('#error_message').append(markup)
                    })
           
                }  else{
                    window.location.href = 'login.php'
                }
              
            },
            error: (error) =>{
                console.error('An Occured occured', error)
            }

        })
    }
</script>


</body>
</html>