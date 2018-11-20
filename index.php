<!DOCTYPE html>
<html>
<head>
	<title>chicken-it</title>
	    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script  src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>


	<div class="container header">
		<h1 class="center">Auto Query 2 Bootstrapform</h1>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-2">Query</div>
			<div class="col-md-10">
				<input type="text" class="form-control" id="query">
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">Label length:</div>
			<div class="col-md-3">
				<input type="number" value="6" max="12" min="0" id="label">
			</div>
			<div class="col-md-3">Input length:</div>
			<div class="col-md-3">
				<input type="number" value="6" max="12" min="0" id="input">
			</div>
		</div>
		<div class="row content">
			<button type="button" class="btn btn-secondary">Give me my Form</button>
		</div>
	</div>
	<div class="container footer">
<textarea id="result" class="form-control"></textarea>
		  
	</div>
</body>
</html>
<script type="text/javascript">
	function formatFactory(html) {
    function parse(html, tab = 0) {
        var tab;
        var html = $.parseHTML(html);
        var formatHtml = new String();   

        function setTabs () {
            var tabs = new String();

            for (i=0; i < tab; i++){
              tabs += '\t';
            }
            return tabs;    
        };


        $.each( html, function( i, el ) {
            if (el.nodeName == '#text') {
                if (($(el).text().trim()).length) {
                    formatHtml += setTabs() + $(el).text().trim() + '\n';
                }    
            } else {
                var innerHTML = $(el).html().trim();
                $(el).html(innerHTML.replace('\n', '').replace(/ +(?= )/g, ''));
                

                if ($(el).children().length) {
                    $(el).html('\n' + parse(innerHTML, (tab + 1)) + setTabs());
                    var outerHTML = $(el).prop('outerHTML').trim();
                    formatHtml += setTabs() + outerHTML + '\n'; 

                } else {
                    var outerHTML = $(el).prop('outerHTML').trim();
                    formatHtml += setTabs() + outerHTML + '\n';
                }      
            }
        });

        return formatHtml;
    };   
    
    return parse(html.replace(/(\r\n|\n|\r)/gm," ").replace(/ +(?= )/g,''));
} 

	$('button').click(function(){
		var value = $('#query').val();
		var label = $('#label').val();
		var input = $('#input').val();
		if(value){
			$.post('generatebootstrap.php', {sql: value,label: label, input: input}, function(data, textStatus, xhr) {
				// console.log(data);
				json =  JSON.parse(data);
				// console.log(json);
				// $.each(json, function(index, val) {
				// 	 new_val = $(val).html();
				// 	 $('#result').append(new_val);
				// });
				var html = '';
				 var len = json.length;
				for (var i = 0; i < len; i++) {
					var html = html + json[i] + '\n';
				}

				$('#result').val(html);
				 var beautify = formatFactory($('textarea').val());
 				$('textarea').val(beautify);
			});
		}

	});



</script>