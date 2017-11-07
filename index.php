<html>
<head>
<title>Website Test Script Sample by Joshua Lipinski</title>
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
</head>
<style>html, body {font: 1em arial}
.start {display: inline-block; padding: .5em; color: white; cursor: pointer; margin: 1em 0 2em 0; background: green;}
.error {color: #cc0000; font-weight: bold}
.success {color: green; font-weight: bold}
.test_status .pending {color: #666666}
</style>
<body>
<script>

var test_data = {test_batch1: [
<?php
//done in php because javascript escapes backslash
$test_urls = array(
"http://www.freshed.com",
"http://www.mutualfundinvestorguide.com",
"http://www.stonemountainhomebuilders.com"
);
echo implode(",", array_map(function($v){return '"' . urlencode($v) . '"';}, $test_urls));
?>
],
test_batch2: [
<?php
//done in php because javascript escapes backslash
$test_urls = array(
"http://www.freshed.com",
"http://www.westernmassland.com",
"http://www.greylockrealty.com",
"http://www.isgoodrealty.com",
"http://www.redhorserealestate.com"
);
echo implode(",", array_map(function($v){return '"' . urlencode($v) . '"';}, $test_urls));
?>
]
};

$(function(){
	$(document).on("click", ".start", function(){
		var this_start = $(this);
//		this_start.html("running");
		$(".test", $(this).closest(".output")).each(function(){
			var this_test = $(this);
			$.ajax({
				beforeSend: function(){$(".test_status", this_test).html("<span class='pending'>pending...</span>"); },
				type: "GET",
				url: "curl_test.php",
				cache: false,
				data: {url: test_data[$(this).closest(".output").attr("id")][$(this).attr("data-urlkey")]},
				success: function(data){$(".test_status", this_test).html("Completed"); $(".test_details", this_test).html(data);},
				error: function(data){$(".test_status", this_test).html("Error"); $(".test_details", this_test).html("<span class='error'>ajax call failed</span>");}
			});
		});
	});
	
	$(".output").each(function(){
		$output = $(this);
		console.log(test_data[$(this).attr("id")]);
		$.each(test_data[$(this).attr("id")], function(k,v){
			$('<div/>', {class: 'test', attr: {'data-urlkey': k}, html: "(" + (k+1) + ") <span class='test_status'>Queued</span>: <span class='test_details'>" + decodeURIComponent(v) + "</span>"}).appendTo($output);
		});
		
		$output.append("<div class='start'>START</div>");
	});
});

</script>	
<div class='output' id='test_batch1'></div>
<div class='output' id='test_batch2'></div>
</body>
</html>