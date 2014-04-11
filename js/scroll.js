/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function thing(id){
            var groups = id;
            }

$(document).ready(function(){
        
       

                
                var track_load = 0; //total loaded record group(s)
                var loading  = false; //to prevents multipal ajax loads
                var total_groups = groups //total record group(s)

                $('#comments1').load("./pageScroll.php", {'group_no':track_load}, function() {track_load++;}); //load first group

                $(window).scroll(function() { //detect page scroll

                    if($(window).scrollTop() + $(window).height() == $(document).height())  //user scrolled to bottom of the page?
                    {

                        if(track_load < total_groups && loading==false) //there's more data to load
                        {
                            loading = true; //prevent further ajax loading
                            $('.animation_image').show(); //show loading image

                            //load data from the server using a HTTP POST request
                            $.post('./pageScroll.php',{'group_no': track_load}, function(data){

                                $("#comments1").append(data); //append received data into the element

                                //hide loading image
                                $('.animation_image').hide(); //hide loading image once data is received

                                track_load++; //loaded group increment
                                loading = false; 

                            }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?

                                alert(thrownError); //alert with HTTP error
                                $('.animation_image').hide(); //hide loading image
                                loading = false;

                            });

                        }
                    }
                });  
    
})
