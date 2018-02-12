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

var test_data = {test_batch1: ["http://www.freshed.com", "http://www.mutualfundinvestorguide.com", "http://www.stonemountainhomebuilders.com"],
test_batch2: ["http://www.freshed.com", "http://www.westernmassland.com", "http://www.greylockrealty.com", "http://www.isgoodrealty.com", "http://www.redhorserealestate.com"]};

$(function(){
	$(document).on("click", ".start", function(){
		var this_start = $(this);
//		this_start.html("running");
		$(".test", $(this).closest(".output")).each(function(){
			var this_test = $(this);
			$.ajax({
				beforeSend: function(){$(".test_status", this_test).html("<span class='pending'>pending...</span>"); },
				type: "GET",
				timeout: 10000,
				url: "curl_test.php",
				cache: false,
				data: {url: decodeURIComponent(test_data[$(this).closest(".output").attr("id")][$(this).attr("data-urlkey")])},
				success: function(data, status, code){},
				error: function(data){$(".test_status", this_test).html("Error"); $(".test_details", this_test).html("<span class='error'>ajax call failed</span>");},
				complete: function(data, status, code){$(".test_status", this_test).html(status); $(".test_details", this_test).html(code); if(!$(".pending", this_test.closest(".output")).length){this_start.html("completed (click to rerun)");}}
			});
		});
	});
	
	$(".output").each(function(){
		$output = $(this);
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
