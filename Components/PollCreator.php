


<form id="poll_form" class="flex flex-col  font-[Outfit]  p-[1em] rounded-md shadow-sm border w-[50%] ml-[7.5em] mt-[1em] ">
        <div id="error_message" class="text-center"></div>    
        <div class='flex flex-row'>
<img src="<?php echo $_SESSION['profile_img'] ?>" alt='profile_pic' class='h-[3em] w-[3em] rounded-full object-cover'>
    <div class='ml-[1em] flex flex-col gap-[1em] w-[80%] '>
        <input type="text" id="title"  name="title" class='h-[3em] w-[80%] border-none outline-none border' placeholder='Ask a question?'>
        <input type="text" id="option_1" name="option_1" class='h-[2.5em] w-full outline-none border rounded-md' placeholder='Option 1' required='true'>
        <input type="text" id="option_2" name="option_2" class='h-[2.5em] w-full outline-none border rounded-md' placeholder='Option 2' required='true'>
        <input type="text" id="option_3" name="option_3" class='h-[2.5em] w-full outline-none border rounded-md' placeholder='Option 3'>
        <input type="text"  id="option_4" name="option_4" class='h-[2.5em] w-full outline-none border rounded-md' placeholder='Option 4'>
        <button onClick='createPoll(event)' type="submit" class='font-[Outfit] bg-blue-500 text-white py-[.5em] px-[1em] rounded-md'>Create Poll</button>
 
    </div>
</div>
</form>


<script defer>
   
    function createPoll(event){
        event.preventDefault()
        $('.error_msg').remove()
        
                 
        let formData = new FormData( $('#poll_form')[0])
        $('#poll_form').hide()
        $.ajax({
            url: 'pollScript.php',
            type: 'POST',
            dataType: 'text',
            data: formData,
            processData: false,
            contentType:false,
            cache: false,
            success: (res) => {
                res = JSON.parse(res)
                if(res.success == false){
             
                    res.message.forEach((message) => {
                          $('#poll_form').show()
      
                        let markup = `<p id="err_msg" class="error_msg font-[Outfit] text-xl   text-red-500  font-semibold text-center "> ${message} </p>`
      
                        $('#error_message').append(markup)
                    })
                }  else {
                    $('#poll_form').trigger('reset')
                    $('#poll_form').show()
                    getPoll()
    
                }
       
            },
            error: (xhr, status,  err) => {
                console.error('An error occured', status, err)
            }
        })
    }
    </script>