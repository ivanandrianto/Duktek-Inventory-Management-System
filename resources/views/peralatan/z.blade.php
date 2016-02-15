<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<style>
html, body {margin: 0; padding: 0;}

.main{
	display: none;
}

#myWorkContent{
    width: auto;
    overflow-x: scroll;
    overflow-y: hidden;
    white-space: nowrap;
}

#myWorkContent div {
    display: inline-block;
    vertical-align: middle;
}

div[class^="col-"], div[class*=" col-"] {
	display: block;
    background-color: white;
	width: 150px;
	height: 1000px;
	border-style: solid;
    border-width: 1px;
}

.content{
	padding:5%;	
	color: white;
	font-family: Arial;
	display: block;
	background-color: red;
	padding-top: -20px;
	width:90%;
}

#myWorkContent img {border: 0;}

</style>

</head>
<body>

	<div id="myWorkContent">
	@for ($i = 0; $i < $period; $i++)
	    <div class="col-{{$i}}"></div>
	@endfor
	</div><!-- end myWorkContent -->

</body>

<script>
@foreach($listOfBooking as $booking)
$(document).ready(function(){
	$(".col-{{$booking['col']}}").append(" <div class='content' style='margin-top:{{$booking['margin']}}px;height:{{$booking['height']}}px;'>{{$booking['id']}}<br>{{$booking['jam_mulai']}} - {{$booking['jam_selesai']}}</div>");
});
@endforeach
</script>

</html>
