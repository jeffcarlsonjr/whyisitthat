$(document).ready(function(){
    $('#comments').load('./ajax/displayComments.php');
})

$(document).ready(function(){
    $( "#add" ).click(function() {
      $( ".commentForm" ).toggle();
    });
});

$(document).ready(function(){
    $('.twitter').click(function(event){
        window.open($('#twitter-home').attr('href'), '_blank');
    });
    
    $('.facebook').click(function(event){
        window.open($('#facebook-home').attr('href'), '_blank');
    });
    
    
});
$(document).ready(function(){
    var callAjax = function(){
      $.ajax({
        method:'get',
        url:'./ajax/displayComments.php',
        success:function(data){
          $("#comments").html(data);
        }
      });
    }
    setInterval(callAjax,10000);
  });

function likeComment(id)
{
   
    $.ajax({
        'url': './ajax/addLike.php', 
        'type': 'GET',
        'dataType': 'json', 
        data: {id: id}, 
        success: function(json) {
            var num = json.count;

            $('[data-like-count="'+id+'"]').html("("+num+")");
            likes(id);
        },
        'error': function(data) {}
      });
}

function unLikeComment(id)
{
   
    $.ajax({
        'url': './ajax/unLike.php', 
        'type': 'GET',
        'dataType': 'json', 
        data: {id: id}, 
        success: function(json) {
            var num = json.count;
           $('[data-like-count="'+id+'"]').html("("+num+")");
            
            if(num === 'null'){ $('[data-like-count="'+id+'"]').html("("+num+")");}
            likes(id);
        },
        'error': function(data) {}
      });
}


//function addComment()
//{
//    var userName = $('#username').val();
//    var email = $('#email').val();
//    var comment = $('comment').val();
//  
//    
//    $.ajax({
//        url: './ajax/addComment.php',
//        type: 'GET',
//        dataType: 'json',
//        data : {username: userName, email: email, comment: comment},
//        success: function(data) {
//            
//        },
//        error: function(data) {}
//    });
//}

function likes(id)
{
   $.ajax({
            url:'./ajax/checkLike.php',
            type: 'GET',
            data: {id: id},
            dataType: 'JSON',
            success: function(data){
                
                var response = data.data;
             
                if(response === 'no'){
                    $("[data-like-id='"+id+"']").html('<span class="toLike" data-type-like onclick="likeComment('+id+')">Like</span>');
//                    console.log(response);
//                    console.log("[data-like-id='"+id+"']")
                    
                }
                else if(response === 'yes'){
                    $("[data-like-id='"+id+"']").html('<span class="toLike" data-type-unlike onclick="unLikeComment('+id+')">Unlike</span>');
                    $("[data-like-id='"+id+"']").css('width', '46px');
//                    console.log(response);
//                    console.log("[data-like-id='"+id+"']")
                }
            }
        });
}
$(document).ready(function(){
    var date = new Date();
    var year = date.getFullYear();
    
    
    $('footer').html('&copy; '+ year + ' All Rights Reservered Whyisitthat.com');
    
})  
        

    
