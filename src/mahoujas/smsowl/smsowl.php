<?php
	namespace Mahoujas\SmsOwl;

	use Exception;

	class SmsType{
		const NORMAL = "normal";
		const FLASH = "flash";
	}

	class SmsOwl
	{
		private $accountId = "";
		private $apiKey = "";
		const URL = "https://api.smsowl.in/v1/sms";
	    
		function __construct($accountId,$apiKey) {
	       $this->accountId = $accountId;
	       $this->apiKey = $apiKey;
	    }

	    private function initCurl(){
	    	$ch = curl_init(self::URL); 
	    	curl_setopt($ch, CURLOPT_HEADER, false);
	    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	    	curl_setopt($ch, CURLOPT_HTTPHEADER,
		        array("Content-type: application/json"));
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_SSLVERSION, 4);
			return $ch;
		}


	    public function sendPromotionalSms($senderId,$to,$message,$smsType = SmsType::NORMAL){
	    	$data = $this->getCommonArray("promotional",$smsType,$senderId,$to);
	    	$data["message"] = $message;
	    	$dataJson = json_encode($data);
    		$curl = $this->initCurl();
    		curl_setopt($curl, CURLOPT_POSTFIELDS,$dataJson);
    		$response  = curl_exec($curl);
    		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);    		
    		curl_close($curl);
    		$jsonRespone = json_decode($response);
    		if($httpCode == 200){
    			if(is_array($to)){
    				return $jsonRespone->smsIds;
    			}else{
    				return $jsonRespone->smsId;
    			}
    		}else{
    			throw new Exception($jsonRespone->message);
    		}
	    }

	    public function sendTransactionalSms($senderId,$to,$templateId,$placeholderArray){
	    	$data = $this->getCommonArray("transactional","normal",$senderId,$to);
	    	$data["templateId"] = $templateId;
	    	$data["placeholders"] = $placeholderArray;
	    	$dataJson = json_encode($data);
	    	$curl = $this->initCurl();
	    	curl_setopt($curl, CURLOPT_POSTFIELDS,$dataJson);
    		$response  = curl_exec($curl);
    		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);    		
    		curl_close($curl);
    		$jsonRespone = json_decode($response);
    		if($httpCode == 200){
    			return $jsonRespone->smsId;
    		}else{
    			throw new Exception($jsonRespone->message);
    		}
	    }


	    private function getCommonArray($dndType,$smsType,$senderId,$to){
	    	return array(    	
	    		'accountId'=> $this->accountId,
		    	'apiKey'=> $this->apiKey,
		    	'dndType'=> $dndType,
		    	'smsType'=> $smsType,
		    	'senderId'=> $senderId,
		    	'to' => $to
		    );
	    }


	}
?>