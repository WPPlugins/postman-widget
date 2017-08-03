<?php 
	/*
	This file is part of Postman Widget.

    Postman Widget is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Postman Widget is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Postman Widget.  If not, see <http://www.gnu.org/licenses/>.
	*/
	
    if(isset($_POST['paloma_hidden'])) {  
        //Form data sent  
		$paloma_customer_id = $_POST['paloma_customer_id'];
		$paloma_customer_hash = $_POST['paloma_customer_hash'];
		update_option('paloma_customer_id', $paloma_customer_id);
		update_option('paloma_customer_hash', $paloma_customer_hash);
?>
		<div class="updated"><p><strong><?php _e('Options saved.','paloma'); ?></strong></p></div>  
<?php  
	}
	else
	{
		if (isset($_POST['paloma_address_list_id']) && $_POST['paloma_address_list_id'] != '') {
			$paloma_address_list_id = $_POST['paloma_address_list_id'];
			update_option('paloma_address_list_id', $paloma_address_list_id);
		}
        //Normal page display  
		$paloma_customer_id = get_option('paloma_customer_id');
		$paloma_customer_hash = get_option('paloma_customer_hash');
		$paloma_address_list_id = get_option('paloma_address_list_id');
    }   
?>

<div class="wrap">  
	<h2><?php _e( 'API Settings', 'paloma' );?></h2>
  
	<form name="paloma_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
		<input type="hidden" name="paloma_hidden" value="Y">  
		<h4><?php _e( 'In order to collect newsletter subscriptions from your Postman Widget, you need to provide a valid Customer ID and Hash. If you are an active customer, contact support to receive your ID and hash: support@paloma.se', 'paloma' ); ?></h4>
		<p><?php _e('Customer-ID:', 'paloma'); ?> <input type="text" name="paloma_customer_id" value="<?php echo $paloma_customer_id; ?>" size="20"> <?php _e('ex: 1702', 'paloma'); ?></p>  
		<p><?php _e('Customer-Hash:', 'paloma'); ?> <input type="text" name="paloma_customer_hash" value="<?php echo $paloma_customer_hash; ?>" size="20"> <?php _e('ex: HTYU6hjGHF5Y', 'paloma'); ?></p>  
		<p class="submit">  
		<input type="submit" name="Submit" value="<?php _e('Save changes', 'paloma' ) ?>" />  
		</p>  
		<hr />  
	</form>
	<?php
		$client = new SoapClient("https://api.paloma.se/PalomaWebService.asmx?WSDL");
		$results = $client->ListAddressLists(array('customerID' => $paloma_customer_id,
								'customerHash' => $paloma_customer_hash));
		if(is_array($results->ListAddressListsResult->AddressLists->AddressList))
		{
			printf("<b>". __('You have %d address lists.','paloma') . "</b>", count($results->ListAddressListsResult->AddressLists->AddressList));
		}
		else
		{
			echo "<b>". __('Either the ID and hash are incorrect or you do not have any address lists.', 'paloma') . "</b>";
		}
		
		?>

</div>  