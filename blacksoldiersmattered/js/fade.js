$(document).ready(function() {
	
$("img.hoverimg").hover(
function() {
$(this).stop().animate({"opacity": "0.2"}, "fast");
},
function() {
$(this).stop().animate({"opacity": "1"}, "fast");
});

$("p.text").hover(
function() {
$(this).stop().animate({"opacity": "0"}, "fast");
},
function() {
$(this).stop().animate({"opacity": "1"}, "fast");
});

});