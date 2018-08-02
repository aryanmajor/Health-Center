/*global $ */
$(document).ready(function(){
    $(".option").eq(0).click(function(){
                $(".option").eq(0).fadeOut("fast");
                $(".main_item").eq(0).fadeOut("fast");
                $(".main_item").eq(1).fadeIn("fast");                
                $(".option").eq(1).fadeIn("fast");
            });
    $(".option").eq(1).click(function(){
                $(".option").eq(1).fadeOut("fast");
                $(".main_item").eq(1).fadeOut("fast");
                $(".main_item").eq(0).fadeIn("fast");                
                $(".option").eq(0).fadeIn("fast");
            });
});