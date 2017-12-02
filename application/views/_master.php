<?php header("Content-type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="ru-RU">
	<head>
	  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	  <title><?php echo $response->title;?></title>
	  <link rel="stylesheet" type="text/css" href="/img/style2.css" />
	</head>
	<body>
		<div class="top">
			<div class="menu">
				<?php 
					if ($this->router->fetch_class()!='login')
					{
						$this->load->view('_menu');
					}
				?>
			</div>
		</div>
		<div class="messages">
			<?php $this->load->view('_messages');?>
		</div>
		<div class="main">
			<?php $this->load->view($response->view);?>
		</div>
		<div class="footer">
			<?php $this->load->view('_footer');?>
			<?//php $this->load->view('_debug');?>
		</div>
	</body>
</html>