jQuery(document).ready(function($) {
    // When the user clicks on the button, open the modal
    $(".buttonopt1").on("click", function(){
        $(".option-modal").css("display", "block");
    });
    $(".buttonopt2").on("click", function(){
        $(".option-modal").css("display", "block");
    });
    $(".buttonopt3").on("click", function(){
        $(".option-modal").css("display", "block");
    });
    $(".buttonopt4").on("click", function(){
        $(".option-modal").css("display", "block");
    });

    
    // When the user clicks on <span> (x), close the modal
    $(".option-close").on("click", function(){
        $(".option-modal").css("display", "none");
    });
    
    // Need to close modal when clicking off of it
//    $("body").click(function(e){
//        if(!(($(e.target).closest("#optionModal").length > 0 ))){
//        $("#optionModal").css("display", "none");
//        }
//    });
    
    
    // Need to update Contact Form 7 hidden option with button selected
    $('.buttonopt1').on('click', function(){ 
        $('input[name=text-55]').val('Option 1');
    });
    $('.buttonopt2').on('click', function(){ 
        $('input[name=text-55]').val('Option 2');
    }); 
    $('.buttonopt3').on('click', function(){ 
        $('input[name=text-55]').val('Option 3');
    }); 
    $('.buttonopt4').on('click', function(){ 
        $('input[name=text-55]').val('Option 4');
    }); 
})
    
    
//
//
//    // When the user clicks on the button, open the modal
//    $(".buttonopt1").on("click", function(){
//        $("#optionModal").css("display", "block");
//    }
//
//    // When the user clicks on <span> (x), close the modal
//    $(".option-close").on("click", function(){
//        $("#optionModal").css("display", "none");
//    }
//
//    // When the user clicks anywhere outside of the modal, close it
//
//
//
//
//
//
//
//// Get the modal
//    var modal = document.getElementById("optionModal");
//
//    // Get the button that opens the modal
//    var btn = document.getElementByClassName("buttonopt1");
//
//    // Get the <span> element that closes the modal
//    var span = document.getElementsByClassName("option-close")[0];
//
//    // When the user clicks on the button, open the modal
//    btn.onclick = function() {
//      modal.style.display = "block";
//    }
//
//    // When the user clicks on <span> (x), close the modal
//    span.onclick = function() {
//      modal.style.display = "none";
//    }
//
//    // When the user clicks anywhere outside of the modal, close it
//    window.onclick = function(event) {
//      if (event.target == modal) {
//        modal.style.display = "none";
//      }
//    }
//    
//    
//});