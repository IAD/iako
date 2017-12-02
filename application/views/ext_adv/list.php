<?php
	include	($_SERVER['DOCUMENT_ROOT'].'/config.php');
	if (isset($config['main_site']))
	{
		$domen=$config['main_site'];
	}
	else
	{
		$domen='iako.ru';
	}
?>
<script type="text/javascript">
    var url = 'http://<?php echo $domen; ?>/adv';

    function doCallOtherDomain(){
        var XHR = window.XDomainRequest || window.XMLHttpRequest
        var xhr = new XHR();

        xhr.open('GET', url, true);

        // замена onreadystatechange
        xhr.onload = function() {
            document.getElementById('adv_content').innerHTML = xhr.responseText
        }

        xhr.onerror = function() {
            //alert("Error")
        }

        xhr.send()
    }

    function callOtherDomain() {
        try {
            doCallOtherDomain()
        } catch (e) {
            alert("В этом браузере данная фича не поддерживается.")
        }
    }
	 window.onload= function(){ callOtherDomain(); }
    </script>
