$(document).ready(function(){
	
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s);
	js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=880248125398440";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));	
	
	
	
$(window).scroll(function() {
if (($(this).scrollTop() > 195) && $(window).width() > 1100){  
    $('.sidebar').addClass("fixed_sidebar");
  }
  else{
    $('.sidebar').removeClass("fixed_sidebar");
  }
});
$(document).ready(function(){

$("#active_tab1").click(function () {
$("#active_tab2").removeClass("active_tab");
$("#active_tab1").addClass("active_tab");
});
$("#active_tab2").click(function () {
$("#active_tab1").removeClass("active_tab");
$("#active_tab2").addClass("active_tab");
});
});

$(document).ready(function(){
	$("#site_comment").click(function(){
    $("#facebook_cm").hide();
    $("#site").show();
	});

	$("#facebook_comment").click(function(){
		$("#site").hide();
	    $("#facebook_cm").show();
	});
});

$(function() {
	$('[data-toggle="tooltip"]').tooltip()
})

$('#boxes').infinitescroll({
	navSelector: ".paginate",
	nextSelector: ".paginate a:last",
	itemSelector: ".box",
	debug: false,
	dataType: 'html',
	path: function(index) {
		return "?page=" + index;
	}
}, function(newElements, data, url) {
	var $newElems = $(newElements);
	$('#boxes').masonry('appended', $newElems, true);
});$('#boxes').infinitescroll({
	navSelector: ".paginate",
	nextSelector: ".paginate a:last",
	itemSelector: ".box",
	debug: false,
	dataType: 'html',
	path: function(index) {
		return "?page=" + index;
	}
}, function(newElements, data, url) {
	var $newElems = $(newElements);
	$('#boxes').masonry('appended', $newElems, true);
});

$.validate({
	modules: 'security',
	modules: 'file'
});

$('#img_description').restrictLength($('#maxlength'));
	
});


