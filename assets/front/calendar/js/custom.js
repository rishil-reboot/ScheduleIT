jQuery(function ($) {
	"use strict";

	// $(".navbar-toggler").on("click", function () {
	// 	$(".body-overlay").toggleClass("active");
	// });
	// $(".body-overlay").on("click", function () {
	// 	$(this).removeClass("active");
	// })
	// $(window).on("scroll", function () {
	// 	if ($(window).scrollTop() < $(".header-wrapp").height()) {
	// 	   $(".navbar-collapse").css("top",0);
	// 	}
	//  });


	$(document).on('click.bs.dropdown.data-api', '.dropdown-menu', function (e) {
		e.stopPropagation();
	});

	// $(function () {
	// 	$('.input-number').prop('disabled', true);
	// 	$('.plus-btn').click(function () {
	// 		$('.input-number').val(parseInt($('.input-number').val()) + 1);
	// 	});
	// 	$('.minus-btn').click(function () {
	// 		$('.input-number').val(parseInt($('.input-number').val()) - 1);
	// 		if ($('.input-number').val() == 0) {
	// 			$('.input-number').val(1);
	// 		}

	// 	});
	// });

//    Cummunity Teams 
	$("#team-slider").owlCarousel({
		// center: true,
		items: 5,
		// loop: false,
		margin: 30,
		dots: false,
		nav: true,
		navText: ['<img src="assets/front/nevcm/images/left.png">', '<img src="assets/front/nevcm/images/right.png">'],
		responsive: {
			1280: {
				items: 5
			},
			1024: {
				items: 4
			},
			992: {
				items: 3
			},
			768: {
				items: 2
			},
			320: {
				items: 1
			}
		},

	});

	// Board Members
	$("#members-slider").owlCarousel({
		items: 4,
		loop: true,
		margin: 30,
		dots: false,
		nav: true,
		navText: ['<img src="assets/front/nevcm/images/left.png">', '<img src="assets/front/nevcm/images/right.png">'],
		responsive: {
			1280: {
				items: 4
			},
			1024: {
				items: 3
			},
			992: {
				items: 3
			},
			768: {
				items: 2
			},
			320: {
				items: 1
			}
		},

	});

	$('#slider-homes').owlCarousel({
		margin: 0,
		center: true,
		loop: true,
		nav: false,
		dots: true,
		responsive: {
		0: {
		   items: 1
		},
		768: {
		   items: 2,
		   margin: 15,
		},
		1000: {
		   items: 3,
		}
		}
	});



	$('#testimonialSlider').owlCarousel({
		items: 4,
		loop: true,
		margin: 30,
		nav: true,
		responsiveClass: true,
		navText: ['<i class="fas fa-arrow-left"></i>', '<i class="fas fa-arrow-right"></i>'],
		responsive: {
			1280: {
				items: 2
			},
			600: {
				items: 1
			}
		}
	});


});



