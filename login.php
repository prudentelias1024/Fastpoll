<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fastpoll | Login</title>
    <script src="./jquery-3.6.0.js" defer></script>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<div>

        <form id='login_form'   class="w-full lg:w-1/3  lg:border lg:rounded-lg m-auto mt-[4em] px-6 lg:px-12 py-6 flex flex-col gap-[2em]">
        <!-- <form id='login_form'   class="w-full lg:w-1/3  lg:border lg:rounded-lg m-auto mt-[4em] px-6 lg:px-12 py-6 flex flex-col gap-[2em]"> -->
 
        <p id="err_msg" class="font-[Outfit] text-xl   text-red-500  font-semibold text-center ">  </p>
        <p class="font-[Outfit] text-2xl font-semibold text-center ">Fastpoll</p>
   
     <div class="email">
         <label class="font-[Outfit] text-[1em] font-bold" for="username">Email/Username</label> 
         <input id="usernameoremail"  class="w-full h-8 border font-[Outfit] p-4 rounded-sm font-bold"   type="text" name="usernameoremail" />
         
     </div>
   
     <div class="password">
         <label class="font-[Outfit] text-[1em] font-bold" for="password">Password</label> 
         <input id='password'  class="w-full h-8 border font-[Outfit] p-4 rounded-sm font-bold" type="password" name="password"   /> 
    </div>
   
     <button onClick='submitForm(event)' class="bg-blue-500 text-white font-[Outfit] p-2 rounded-lg" name="login" type="submit">Login</button>
     <a class='font-[Sen] m-auto text-blue-500' href='./signup.php'>Signup Here?</a>
    <form>                                                                                                                                                                
    </div>

    <script>
    function submitForm(event){
        event.preventDefault()
        let formData = new FormData($('#login_form')[0]);
        $.ajax({
            url: 'loginScript.php',
            type: 'POST',
            processData: false,
            contentType: false,
            dataType: 'text ',
            cache:false,
            data:formData,  
            success:  (response) =>{
                console.log(response)
                response = JSON.parse(response)
                console.log(response)
                if(response.success == false){
                    $('#err_msg').html(response.message)
                }  else{
                    window.location.href = 'polls.php'
                }
            },
            error: (xhr,status,error) => {
                console.log(error)
            }

        })
    }
</script>

</body>

</html>