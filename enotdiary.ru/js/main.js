function togleSliderLog(){
	console.log($('#slid').css('display'))
	if($('#slid').css('display') === 'none')
	{
    	$('#slid').slideDown();
}
else
{
    $('#slid').slideUp();
}			
}
function togleSliderReg(){
	console.log($('#slidreg').css('display'))
	if($('#slidreg').css('display') === 'none')
{
    $('#slidreg').slideDown();
}
else
{
    $('#slidreg').slideUp();
}			
}

function addToOrder(){
	var countPlace = document.getElementById("order-count")
	var countNow = parseInt(countPlace.innerText)
	countNow++
	countPlace.innerText = countNow.toString()
	console.log('countNow: ' + countNow)
}
function setModal(id){
	var src = document.getElementById(id).src
	var newImg = document.createElement("img")
	newImg.src = src
	newImg.id = "modalImg"
	var mod = document.getElementById("itemfull").classList.remove("hidden")
	document.getElementById("modal-center").appendChild(newImg)
}
$(".modal").on("click", function(event){
  	event.stopPropagation();
  	var mod = document.getElementById("itemfull").classList.add("hidden")
  	document.getElementById("modalImg").remove()
});
$("#modal-close").on("click", function(event){
  	var mod = document.getElementById("itemfull").classList.add("hidden")
  	document.getElementById("modalImg").remove()
});

//to basket page
function toOrder(){
	location.href = "order.php";
}


$("#id").keyup(function(event){
    if(event.keyCode == 13){
        event.preventDefault();
        $.ajax({
    		type: 'POST',
    		url: 'php/search_api.php',
    		data: { 
    		    'id': id.value
    		},
    		success: function(status){
    			$("#numOr").html("Подождите...")
    			$("#resF").html("Поиск...")
    			setTimeout(function(){
    				$("#resF").html(status)
    				numOr.innerText = id.value
        			document.getElementById('id').value = ""
        			document.getElementById('id').blur()
				}, 1666); // if you unnderstand this, i'll personaly describe you this
    		}
		});	
    }
});