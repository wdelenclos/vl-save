<?php

function P404REDIRECT_HideMessageAjaxFunction()
	{  
		add_option( 'P404REDIRECT_upgrade_message','yes');
	}  
	
function P404REDIRECT_after_plugin_row($plugin_file, $plugin_data, $status) {
	        
			if(get_option('P404REDIRECT_upgrade_message') !='yes')
			{
				$class_name = $plugin_data['slug'];
				
		        echo '<tr id="' .$class_name. '-plugin-update-tr" class="plugin-update-tr active">';
		        echo '<td  colspan="3" class="plugin-update">';
		        echo '<div id="' .$class_name. '-upgradeMsg" class="update-message" style="background:#FFF8E5; padding-left:10px; border-left:#FFB900 solid 4px" >';

				echo 'Show & fix all broken links with our <a target="_blank" href="http://www.clogica.com/product/seo-redirection-premium-wordpress-plugin#404">SEO redirection Plugin';
				        
				//echo '<span id="HideMe" style="cursor:pointer" ><a href="javascript:void(0)"><strong>dismiss</strong></a> this message</span>';
		        echo '</div>';
		        echo '</td>';
		        echo '</tr>';
		        
		        ?>
		        
		        <script type="text/javascript">
			    jQuery(document).ready(function() {
				    var row = jQuery('#<?php echo $class_name;?>-plugin-update-tr').closest('tr').prev();
				    jQuery(row).addClass('update');
					
					
					jQuery("#HideMe").click(function(){ 
					  jQuery.ajax({  
							type: 'POST',  
							url: '<?php echo admin_url();?>/admin-ajax.php',  
							data: {  
								action: 'P404REDIRECT_HideMessageAjaxFunction'
							},  
							success: function(data, textStatus, XMLHttpRequest){  
								
								jQuery("#<?php echo $class_name;?>-upgradeMsg").hide();  
								  
							},  
							error: function(MLHttpRequest, textStatus, errorThrown){  
								alert(errorThrown);  
							}  
						});  
				  });
  
			    });
			    </script>
		        
		        <?php
			}
	    }
		
function P404REDIRECT_get_current_URL()
{
	$prt = $_SERVER['SERVER_PORT'];
	$sname = $_SERVER['SERVER_NAME'];
	
	if (array_key_exists('HTTPS',$_SERVER) && $_SERVER['HTTPS'] != 'off' && $_SERVER['HTTPS'] != '')
	$sname = "https://" . $sname; 
	else
	$sname = "http://" . $sname; 
	
	if($prt !=80)
	{
	$sname = $sname . ":" . $prt;
	} 
	
	$path = $sname . $_SERVER["REQUEST_URI"];
	
	return $path ;

}

//---------------------------------------------------- 

function P404REDIRECT_init_my_options()
{	
	add_option(OPTIONS404);
	$options = array();
	$options['p404_redirect_to']= site_url();
	$options['p404_status']= '1';	
	update_option(OPTIONS404,$options);
} 

//---------------------------------------------------- 

function P404REDIRECT_update_my_options($options)
{	
	update_option(OPTIONS404,$options);
} 

//---------------------------------------------------- 

function P404REDIRECT_get_my_options()
{	
	$options=get_option(OPTIONS404);
	if(!$options)
	{
		P404REDIRECT_init_my_options();
		$options=get_option(OPTIONS404);
	}
	return $options;			
}

//---------------------------------------------------- 

function P404REDIRECT_option_msg($msg)
{	
	echo '<div id="message" class="updated"><p>' . $msg . '</p></div>';		
}

//---------------------------------------------------- 

function P404REDIRECT_info_option_msg($msg)
{	
	echo '<div id="message" class="updated"><p><div class="info_icon"></div> ' . $msg . '</p></div>';		
}

//---------------------------------------------------- 

function P404REDIRECT_warning_option_msg($msg) 
{	
	echo '<div id="message" class="error"><p><div class="warning_icon"></div> ' . $msg . '</p></div>';		
}

//---------------------------------------------------- 

function P404REDIRECT_success_option_msg($msg)
{	
	echo '<div id="message" class="updated"><p><div class="success_icon"></div> ' . $msg . '</p></div>';		
}

//---------------------------------------------------- 

function P404REDIRECT_failure_option_msg($msg)
{	
	echo '<div id="message" class="error"><p><div class="failure_icon"></div> ' . $msg . '</p></div>';		
}


//---------------------------------------------------- 
function P404REDIRECT_there_is_cache()
{	

$plugins=get_option( 'active_plugins' );

		    for($i=0;$i<count($plugins);$i++)
		    {   
		       if (stripos($plugins[$i],'cache')!==false)
		       {
		       	  return $plugins[$i];
		       }
		    }


	return '';				
}

   