<?php

include_once "cf_dropdown.php";

global $wpdb,$table_prefix;



$redirect_to = (isset($_POST['redirect_to'])) ? sanitize_text_field($_POST['redirect_to']) : '';
$nonce = isset($_REQUEST['_wpnonce']) ? $_REQUEST['_wpnonce'] : '';

if($redirect_to !=='')
{
if(wp_verify_nonce( $nonce, 'p404home_nounce' ))
	{

		$newoptions['p404_redirect_to']= $redirect_to;
		$newoptions['p404_status']=sanitize_text_field($_POST['p404_status']);
		P404REDIRECT_update_my_options($newoptions);
		P404REDIRECT_option_msg('Options Saved!');
		
	}else {
                P404REDIRECT_failure_option_msg('Unable to save data!');
        }
}
$options= P404REDIRECT_get_my_options();
?>

<?php
if(P404REDIRECT_there_is_cache()!='') 
P404REDIRECT_info_option_msg("You have a cache plugin installed <b>'" . P404REDIRECT_there_is_cache() . "'</b>, you have to clear cache after any changes to get the changes reflected immediately! ");
?>

<div class="wrap">
<div ><div class='inner'>
<h2>All 404 Redirect to Homepage</h2>
	
	
<form method="POST">
	404 Redirection Status: 
	<?php
		$drop = new dropdown('p404_status');
		$drop->add('Enabled','1');	
		$drop->add('Disabled','2');
		$drop->dropdown_print();
		$drop->select($options['p404_status']);
	?>
	
	<br/><br/>
	
	Redirect all 404 pages to: 
	<input type="text" name="redirect_to" id="redirect_to" size="30" value="<?php echo $options['p404_redirect_to']?>">		
	
	<br/>
<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo $nonce = wp_create_nonce('p404home_nounce'); ?>" />
<br />
<input  class="button-primary" type="submit" value="  Update Options  " name="Save_Options"></form>  

</div></div>

<br/>
<hr><br/>

<div>
   <i class="fa fa-times-circle"></i><b style="color:red">Oops! Plugin detected some broken links!</b>, You can use our <a target="_blank" href="http://www.clogica.com/product/seo-redirection-premium-wordpress-plugin#404">SEO Redirection Plugin</a> to monitor 404 errors and fix it.
<div id="seo-redirection-msg">
<br />
<input type="button" name="dismiss" value="Dismiss this message" onclick="seoredirection_hide_msg()">
<br />
<br />
<a href="http://www.clogica.com/product/seo-redirection-premium-wordpress-plugin" target="_blank">
<img src="http://www.clogica.com/wp-content/uploads/2015/05/seo-redirection.png"></a>
</div>
</div>

<script type="text/javascript">

function seoredirection_hide_msg()
{
	localStorage.setItem('hide-seoredirection-message', 'y');
	document.getElementById("seo-redirection-msg").style.display = 'none'; 
	window.open('https://www.clogica.com/product/seo-redirection-premium-wordpress-plugin', '_blank ');
}

if(localStorage.getItem('hide-seoredirection-message') == 'y')
{
	document.getElementById("seo-redirection-msg").style.display = 'none'; 
}
</script>

