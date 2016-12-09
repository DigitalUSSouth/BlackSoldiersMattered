window.addEventListener("awesomplete-selectcomplete", function(e){
  // User made a selection from dropdown. 
  // This is fired before the selection is applied
  var soldierId = $("#nameInput").val();
  window.location = "soldier?id="+soldierId;
  //alert(e.text);
}, false);


/*$(".awesomplete").change(function(e) {
    alert("hi");
    if(e.which == 13) {
        alert($(this).value());
    }
});*/