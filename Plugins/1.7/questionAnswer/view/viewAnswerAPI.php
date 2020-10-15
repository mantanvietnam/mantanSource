<!DOCTYPE html>
<html lang="vi">
	<head>
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta charset="utf-8">
	    <style type="text/css">
	    	img{max-width: 100%;}
	    </style>
	</head>
	<body>
		<b>Câu hỏi: </b><?php echo @$data['Question']['content'];?>
		<br/><br/>
		<b>Trả lời: </b><?php echo @$data['Question']['answer'];?>
	</body>
</html>