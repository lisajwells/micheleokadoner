 jQuery.noConflict()(function ($) { // this was missing for me
    $(document).ready(function() {

    $(".generation_list li a").click(function(event){
      event.preventDefault();

      $(".generation_list li a").removeClass('active_text');
      $(this).addClass('active_text');
      var gen = $(this).attr('gen');
      $(".image-box").hide();
      $("."+gen).show();
    });

    $(".image-box").mouseover(function(){
    $(this).find(".below_title_gen").addClass("show");

    });
      $(".image-box").mouseout(function(){
      $(this).find(".below_title_gen").removeClass("show");

    });
    $(".masonry_img_box").mouseover(function(){
    $(this).find(".home_below_title_gen").addClass("visible");

    });
      $(".masonry_img_box").mouseout(function(){
      $(this).find(".home_below_title_gen").removeClass("visible");

    });

    });

   /* nav menu js */
  $(document).ready(function($){
    $(".menu li").mouseover(function(){
      $(this).find(".menu-image-title").addClass("show");

    });
    $(".menu li").mouseout(function(){
      $(this).find(".menu-image-title").removeClass("show");

    });

    var $grid = $('.grid').imagesLoaded( function() {
  // init Masonry after all images have loaded
  $grid.masonry({
      // set itemSelector so .grid-sizer is not used in layout
      itemSelector: '.grid-item',
      // use element for option
      columnWidth: '.grid-sizer',
      percentPosition: true
  });
});


  }); // document-ready

});




