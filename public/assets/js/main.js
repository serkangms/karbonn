 /* Map Area Start */
 $(document).on("click", ".pin", function () {
  let id = $(this).data('id');
  if ($(window).width() <= 340) {
    let aria = $(".pinShowPrd-" + id).attr("aria-label").split("/")[0].trim();
  }
  else {
    $(".boxPinShow").removeClass("d-inline");
    $(".boxPinShow").removeClass("position-relative");
    $(".pinShow-" + id).toggleClass("d-inline");
    $(".pinShow-" + id).toggleClass("position-relative");
  }
});
 /* Map Area End */


 $(document).ready(function () {
  $(".hide").click(function () {
    $(".bg-pin-show").attr("style", "display:none");
    $(".boxPinShow").attr("style", "opacity:0");
  });
  $(".show").click(function () {
    $(".bg-pin-show").attr("style", "display:block");
    $(".boxPinShow").attr("style", "opacity:1");
  });


});

 /* Menu Area Start */
 $('.nav').on('click',function() {
   $(".side-categories").addClass("animate__animated animate__fadeInRight");
   $(".side-categories").attr("style", "display:block!important");
   $("#header .custom-container").addClass("custom0");
   $("#page-header .custom-container").addClass("custom0");
   $(".logo").addClass("logo-opcty");
   $("#navicon").attr("style", "display:none");
   $("#header").attr("style", " z-index: 9999; background-color: rgba(0, 0, 0, 0.8); position: fixed; height:100%; width:100%;");
   $("#page-header").attr("style", "z-index: 9999; background-color: rgba(0, 0, 0, 0.8); position: fixed; height:100%; width:100%;");
   $(".top-bar").addClass("margin-bar");


 });

 $("#closeButton").click(function () {
   $(".side-categories").removeClass("d-block");
   $(".side-categories").removeAttr("style");
   $("#header .custom-container").removeClass("custom0");
   $("#page-header .custom-container").removeClass("custom0");
   $(".logo").removeClass("logo-opcty");
   $("#navicon").attr("style", "display:block");
   $("#header").removeAttr("style");
   $("#page-header").removeAttr("style");
   $(".top-bar").removeClass("margin-bar");
 });

 $("#closeButton2").click(function () {
   $(".side-categories").removeClass("d-block");
   $(".side-categories").removeAttr("style");
   $("#header .custom-container").removeClass("custom0");
   $("#page-header .custom-container").removeClass("custom0");
   $(".logo").removeClass("logo-opcty");
   $("#navicon").attr("style", "display:block");
   $("#header").removeAttr("style");
   $("#page-header").removeAttr("style");
   $(".top-bar").removeClass("margin-bar");
 });


 /* Menu Area End */


 /* Ask Question Area Start */
 $(document).ready(function(){
  $(".ask-box").hover(function(){
    $(".ask-title").css("color", "#BD1D1D");
  });
});
 /* Ask Question Area End */


 /* Career Area Start */
 $(document).ready(function(){
  $(".career-content .job").hover(function(){
    $(".career-content .job .line").css("background", "#BD1D1D");
  }, 
  function(){
   $(".career-content .job .line").css("background", "#FFFFFF");
 });
});

 $(document).ready(function(){
  $(".career-content .intern").hover(function(){
    $(".career-content .intern .line").css("background", "#FFFFFF");
  }, 
  function(){
   $(".career-content .intern .line").css("background", "#BD1D1D");
 });
});
 /* Career Area End */


 /* Fancybox Area Start */
 function lightbox_open() {
  var lightBoxVideo = document.getElementById("VisaChipCardVideo");
  window.scrollTo(0, 0);
  document.getElementById('light').style.display = 'block';
  document.getElementById('fade').style.display = 'block';
  lightBoxVideo.play();
  $(".navbar-light").attr("style","z-index:2 !important");
}

function lightbox_close() {
  var lightBoxVideo = document.getElementById("VisaChipCardVideo");
  document.getElementById('light').style.display = 'none';
  document.getElementById('fade').style.display = 'none';
  lightBoxVideo.pause();
  $(".navbar-light").removeAttr("style");
}


$('.fancybox').on('click', function(){
  $(".carousel-inner").attr("style","width:101%!important");
}); 



if($('.fancybox').on('click', function() {
  $(".carousel-inner").attr("style","width:101%!important");
}));

  /* Fancybox Area End */


  /* Owl Carousel Area Start */
  $('#carousel-services').owlCarousel({
    loop:true,
    items:5,
    margin:10,
    nav:true,
    dots:false,
    navText : ['<img src="assets/img/prev-arrow.svg">','<img src="assets/img/next-arrow.svg">'],
    responsive:{
     0:{
       margin: 10,
       stagePadding: 25,
       items:1,
       nav:true,
     },
     600:{
       margin: 10,
       stagePadding: 25,
       items:2,
       nav:true
     },
     1000:{
      margin: 10,
      stagePadding: 100,
      items:4,
      nav:true,
      loop:true
    }
  }
});

  $('#carousel-circulars').owlCarousel({
    loop:true,
    items:5,
    margin:10,
    nav:true,
    dots:false,
    navText : ['<img src="assets/img/light-prev-arrow.svg">','<img src="assets/img/light-next-arrow.svg">'],
    responsive:{
     0:{
      items:1,
      nav:true,
    },
    768:{
      items:1,
      nav:true
    },
    1000:{

      items:2,
      nav:true,
      loop:true
    },
    1400:{

      items:3,
      nav:true,
      loop:true
    }
  }
});


  $('#carousel-ask').owlCarousel({
    loop:false,
    items:6,
    margin:10,
    nav:false,
    responsive:{
     0:{
      items:1,
    },
    500:{
      items:2,
    },
    768:{
      items:3,
    },
    1000:{
      items:4,
    },
    1200:{
      items:5,
    },
    1400:{
      items:6,
    },
    1600:{
      items:6,
      margin:5,
    },
    2100:{
      items:7,
    }
  }
});


  $('#carousel-homenews').owlCarousel({
    loop:false,
    items:1,
    margin:5,
    nav:true,
    dots:false,

  });

  /* Owl Carousel Area End */


  /* History Tab Area Start */
  function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
  }

  document.getElementById("defaultOpen").click();



// Show the first tab and hide the rest
$('#tabs-nav li:first-child').addClass('active');
$('.tab-content').hide();
$('.tab-content:first').show();

// Click function
$('#tabs-nav li').click(function(){
  $('#tabs-nav li').removeClass('active');
  $(this).addClass('active');
  $('.tab-content').hide();
  
  var activeTab = $(this).find('a').attr('href');
  $(activeTab).fadeIn();
  return false;
});

/* History Tab Area End */


/* News Area Splide Start */ 
document.addEventListener( 'DOMContentLoaded', function () {
  new Splide('#splide', {

    perPage: 1,

    autoplay: false,
    interval: 8000,

    updateOnMove: true,
    pagination: false,
    throttle: 300,

  }).mount();
});

/* News Area Splide End */ 
