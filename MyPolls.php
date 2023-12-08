<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastPoll | Polls</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="./public/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="./public/fontawesome/css/brands.min.css">
    <link rel="stylesheet" href="./public/fontawesome/css/brands.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="./jquery-3.6.0.js" defer></script>

</head>
<body onload="getPoll()" >
    <?php
  
  include './Components/PollsNavbar.php';

?>
<div class='flex flex-col ml-[20%] w-[80%]'>
  <?php
  
  session_start();
  if($_SESSION){

    include './Components/PollCreator.php';
  }
 
  ?>
  <div id="polls" >
  </div>
</div>

<script>
    function getPoll(event){
        $.ajax({
            url: 'fetchMyPolls.php',
            type: 'GET',
            dataType: 'text',
            processData: false,
            contentType:false,
            cache: false,
            success: (res) => {
                res = JSON.parse(res)
                if(res.success == false){
                    $('#err_msg').html(res.message)
                  
                  } else {
                  $('#polls').empty()
                    
                  res.forEach((poll) => {
                    const total = Number(poll.option_three_count) + Number(poll.option_one_count) + Number(poll.option_two_count) + Number(poll.option_four_count)
                    
                    let option_one_percentage = 0
                    let option_two_percentage = 0
                    let option_three_percentage = 0
                    let option_four_percentage = 0
                    if (total != 0) {
                   
                     option_one_percentage = (Number(poll.option_one_count) / total) * 100
                     option_one_percentage = Math.round(option_one_percentage)
                     
        
                     option_two_percentage = (Number(poll.option_two_count) / total) * 100
                      option_two_percentage = Math.round(option_two_percentage)
                    
                     option_three_percentage = (Number(poll.option_three_count) / total) *100
                    option_three_percentage = Math.round(option_three_percentage)
                    
                     option_four_percentage = (Number(poll.option_four_count) / total) * 100
                      option_four_percentage = Math.round(option_four_percentage)
                    
                    }
                    if (poll.voted == false ) {

                    
                    let markup = ` <div class='poll flex flex-col gap-[1em] font-[Outfit]   p-[1em] rounded-md shadow-sm border w-[50%] ml-[7.5em] mt-[1em]' id=${poll.id}><div class='flex flex-row '> <img src=${poll.profile_img} alt='profile_pic' class='h-[3em] w-[3em] rounded-full object-cover'> <div  class='ml-[1em] flex flex-col '> <p class='font-bold'>${poll.fullname}</p><p class='font-bold text-[#d3d2d2]'>${poll.username}</p> </div>  </div><p class='font-bold mt-[1em]'>${poll.text}</p>
                     <div onClick='vote(event)'  class='cursor-pointer relative flex flex-row justify-between text-[#d3d2d2] border border-[#d3d2d2] rounded-md font-bold p-[.5em]'>
                     <div value='
                    ${option_one_percentage}' style="width: ${option_one_percentage}%; z-index:-1;" class='poll_results absolute w-[${option_one_percentage}%]   p-[.5em] bg-[#ebebeb]   ml-[-.5em] mt-[-.5em]' >&nbsp</div>  
                     <p>${poll.option_1}</p> 
                     <p value=${poll.option_one_count} class='option_one_count' class='option_value'>${option_one_percentage}%</p>  
                     </div>
                     
                     <div onClick='vote(event)' class='cursor-pointer relative flex flex-row justify-between text-[#d3d2d2] border border-[#d3d2d2] rounded-md font-bold p-[.5em]'  >
                     <div value='
                    ${option_two_percentage}' style="width: ${option_two_percentage}%; z-index:-1;" class='poll_results absolute w-[${option_one_percentage}%]   p-[.5em] bg-[#ebebeb]   ml-[-.5em] mt-[-.5em]' >&nbsp</div>  
                     <p>${poll.option_2}</p><p  class='option_two_count' value=${poll.option_two_count}>${option_two_percentage}%</p>    </div>
                     
                     <div onClick='vote(event)' ${poll.option_3 == '' ?"style='display:none;'": ''} class='cursor-pointer relative flex flex-row justify-between text-[#d3d2d2] border border-[#d3d2d2] rounded-md font-bold p-[.5em]' > 
                     <div value='
                      ${option_three_percentage}' style="width: ${option_three_percentage}%; z-index:-1;" class='poll_results absolute w-[${option_one_percentage}%]   p-[.5em] bg-[#ebebeb]   ml-[-.5em] mt-[-.5em]' >&nbsp</div>  
                     <p>${poll.option_3}</p> 
                      <p value=${poll.option_three_count} class='option_three_count'>${option_three_percentage}%</p> 
                        </div>

                         <div ${poll.option_4 == '' ?"style='display:none;'": ''} onClick='vote(event)' class='cursor-pointer relative flex flex-row justify-between text-[#d3d2d2] border border-[#d3d2d2] rounded-md font-bold p-[.5em]' > 
                         <div value='
                  ${option_four_percentage}' style="width: ${option_four_percentage}%; z-index:-1;" class='poll_results absolute w-[${option_one_percentage}%]   p-[.5em] bg-[#ebebeb]   ml-[-.5em] mt-[-.5em]' >&nbsp</div>  
                         <p>${poll.option_4}</p><p class='option_four_count' value=${poll.option_four_count}>${option_four_percentage}%</p>     </div><p class=' text-[#d3d2d2] font-bold mt-[1em]'>${total} Votes</p> `
                    $("#polls").append(markup)
                    let  poll_results = $('.poll_results')
            for (let index = 0; index < poll_results.length; index++) {
              if(poll_results[index].getAttribute('value') == 0) {
                poll_results[index].remove()
              }
            } 
        
                  }else {
                      let markup =       `    <div class='poll flex flex-col gap-[1em] font-[Outfit]   p-[1em] rounded-md shadow-sm border w-[50%] ml-[7.5em] mt-[1em]' id="${poll.id}"><div class='flex flex-row '> <img src=${poll.profile_img} alt='profile_pic' class='h-[3em] w-[3em] rounded-full object-cover'> <div  class='ml-[1em] flex flex-col '> <p class='font-bold'>${poll.fullname}</p><p class='font-bold text-[#d3d2d2]'>${poll.username}</p> </div>  </div><p class='font-bold mt-[1em]'>${poll.text}</p> 
                      
                <div class='flex  lg:w-[30.15em] relative flex-row justify-between  text-[#d3d2d2] border border-[#d3d2d2] rounded-md font-bold p-[.5em] ' style="z-index: 63;"> 
                div value='${option_one_percentage}' style="width: ${option_one_percentage}%; z-index:-1;" class='poll_results absolute w-[${option_one_percentage}%]   p-[.5em] bg-[#ebebeb]   ml-[-.5em] mt-[-.5em]' >&nbsp</div>   <p>${poll.option_1}</p>   <p>${option_one_percentage}%</p></div>   


                <div class='flex   lg:w-[30.15em]  relative flex-row justify-between  text-[#d3d2d2] border border-[#d3d2d2] rounded-md font-bold p-[.5em] ' style="z-index: 63;">   <div value='${option_two_percentage}' style="width: ${option_two_percentage}%; z-index:-1;" class='poll_results absolute w-[${option_two_percentage}%]   p-[.5em] bg-[#ebebeb]   ml-[-.5em] mt-[-.5em]' style='z-index: -1'>&nbsp</div>  <p>${poll.option_2}</p>    <p>${option_two_percentage}%</p> </div>  

                <div ${poll.option_3 == '' ?"style='display:none;'": ''} class='flex   lg:w-[30.15em]  relative flex-row justify-between  text-[#d3d2d2] border border-[#d3d2d2] rounded-md font-bold p-[.5em] ' style="z-index: 63;">  <div  value='${option_three_percentage}' style="width: ${option_three_percentage}%; z-index:-1;" class='poll_results absolute w-[${option_three_percentage}%]   p-[.5em] bg-[#ebebeb]   ml-[-.5em] mt-[-.5em]'>&nbsp</div>  <p>${poll.option_3}</p><p>${option_three_percentage}%</p></div>  

              <div ${poll.option_4 == '' ?"style='display:none;'": ''} class='flex   lg:w-[30.15em]  relative flex-row justify-between  text-[#d3d2d2] border border-[#d3d2d2] rounded-md font-bold p-[.5em] ' style="z-index: 63;"> <div value='${option_four_percentage}'       style="width: ${option_four_percentage}%; z-index:-1;" class='poll_results absolute w-[${option_four_percentage}%]   p-[.5em] bg-[#ebebeb]   ml-[-.5em] mt-[-.5em]' style='z-index: -1'>&nbsp</div>  <p>${poll.option_4}</p>  <p>${option_four_percentage}%</p></div><p class='text-[#d3d2d2]  font-bold mt-[1em]'>${total} Votes</p></div>`
                      $("#polls").append(markup)
      
                    }
             let  poll_results = $('.poll_results')
            for (let index = 0; index < poll_results.length; index++) {
              if(poll_results[index].getAttribute('value') == 0) {
                poll_results[index].remove()
              }
            } 
              
          
          
          
          })
       
            }
            },
            error: (xhr, status,  err) => {
                console.error('An error occured', status, err)
            }
        })
    }

    function vote(event){
      document = event.target
      let value = event.target.children[1].getAttribute('value')
      let option = event.target.children[1].getAttribute('class')
      let pollId = event.target.parentElement.getAttribute('id')
      let formData = new FormData() 
      console.log(value,option)   
      formData.append('option',option)
      formData.append('poll_id',pollId)
      formData.append('option_value',Number(value)+1)

      $.ajax({
          url: 'voteScript.php',
            type: 'POST',
            dataType: 'text',
            data: formData,
            processData: false,
            contentType:false,
            cache: false,
                success: (res) => {
                console.log(res)
                res = JSON.parse(res)
                console.log(res)
                if(res.success == false){
                    $('#err_msg').html(res.message)
                  
                  }  else if(res.message == 403) {
                      window.location.href = 'login.php'
                   } else {
          let poll = res.message[0]
          console.log(poll)        
          const total = Number(poll.option_three_count) + Number(poll.option_one_count) + Number(poll.option_two_count) + Number(poll.option_four_count)
     
          let option_one_percentage = 0
          let option_two_percentage = 0
          let option_three_percentage = 0
          let option_four_percentage = 0
          if (total != 0) {
          
                      option_one_percentage = (Number(poll.option_one_count) / total) * 100
                     option_one_percentage = Math.round(option_one_percentage)
                     
        
                     option_two_percentage = (Number(poll.option_two_count) / total) * 100
                      option_two_percentage = Math.round(option_two_percentage)
                    
                     option_three_percentage = (Number(poll.option_three_count) / total) *100
                    option_three_percentage = Math.round(option_three_percentage)
                    
                     option_four_percentage = (Number(poll.option_four_count) / total) * 100
                      option_four_percentage = Math.round(option_four_percentage)
           
          }
          
        
                    $('.poll').eq(pollId-1).replaceWith(

                      `
       <div class='poll flex flex-col gap-[1em] font-[Outfit]   p-[1em] rounded-md shadow-sm border w-[50%] ml-[7.5em] mt-[1em]' id=${poll.id}><div class='flex flex-row '> <img src=${poll.profile_img} alt='profile_pic' class='h-[3em] w-[3em] rounded-full object-cover'> <div  class='ml-[1em] flex flex-col '> <p class='font-bold'>${poll.fullname}</p><p class='font-bold text-[#d3d2d2]'>${poll.username}</p> </div>  </div><p class='font-bold mt-[1em]'>${poll.text}</p>
      
       <div class='flex  lg:w-[30.15em] relative flex-row justify-between  text-[#d3d2d2] border border-[#d3d2d2] rounded-md font-bold p-[.5em] ' style="z-index: 63;">
        <div value="${option_one_percentage}" style=" width: ${option_one_percentage}%; z-index:-1;" class='absolute poll_results w-[${option_one_percentage}%]   p-[.5em] bg-[#ebebeb]   ml-[-.5em] mt-[-.5em]' style='z-index: -1'>&nbsp</div>
        <p>${poll.option_1}</p>
        <p>${option_one_percentage}%</p>
    </div>
  
          <div class='flex   lg:w-[30.15em]  relative flex-row justify-between  text-[#d3d2d2] border border-[#d3d2d2] rounded-md font-bold p-[.5em] ' style="z-index: 63;">
        <div value="${option_two_percentage}" style="width: ${option_two_percentage}%; z-index:-1;" class='absolute poll_results w-[${option_two_percentage}%]   p-[.5em] bg-[#ebebeb]   ml-[-.5em] mt-[-.5em]' style='z-index: -1'>&nbsp</div>
        <p>${poll.option_2}</p>
        <p>${option_two_percentage}%</p>
    </div>
  
          <div class='flex   lg:w-[30.15em]  relative flex-row justify-between  text-[#d3d2d2] border border-[#d3d2d2] rounded-md font-bold p-[.5em] ' style="z-index: 63;">
        <div value="${option_three_percentage}" style="width: ${option_three_percentage}%; z-index:-1;" class='absolute poll_results w-[${option_three_percentage}%]   p-[.5em] bg-[#ebebeb]   ml-[-.5em] mt-[-.5em]' style='z-index: -1'>&nbsp</div>
        <p>${poll.option_3}</p>
        <p>${option_three_percentage}%</p>
    </div>
  
          <div class='flex   lg:w-[30.15em]  relative flex-row justify-between  text-[#d3d2d2] border border-[#d3d2d2] rounded-md font-bold p-[.5em] ' style="z-index: 63;">
        <div value='${option_four_percentage}' style="width: ${option_four_percentage}%; z-index:-1;" class='absolute poll_results w-[${option_four_percentage}%]   p-[.5em] bg-[#ebebeb]   ml-[-.5em] mt-[-.5em]' style='z-index: -1'>&nbsp</div>
        <p>${poll.option_4}</p>
        <p>${option_four_percentage}%</p>
    </div>
  
    <p class='text-[#d3d2d2]  font-bold mt-[1em]'>${total} Votes</p>
    
</div>`
                    
                    )                   

                    
            let  poll_results = $('.poll_results')
            for (let index = 0; index < poll_results.length; index++) {
              if(poll_results[index].getAttribute('value') == 0) {
                console.log(poll_results[index])
                poll_results[index].remove()
              }
            }  
            } 
             
            },
            error: (xhr, status,  err) => {
                console.error('An error occured', status, err)
            }
        })
    }
    


    </script>
</body>
</html>