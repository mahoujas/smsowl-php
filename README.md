## Sms Owl PHP Wrapper

This package is wrapper of Sms Owl REST API hosted at [https://smsowl.in](https://smsowl.in). Sms Owl provides transactional and promotional SMS Gateway services.

### Installing Sms Owl library

You can download library in two ways.

1. Using composer.
2. Download PHP file directly.

#### 1. Using Composer

Install composer in your project. Skip this step if you already have composer.

	curl -sS https://getcomposer.org/installer | php

a. Install the library using either following command

	 php composer.phar require mahoujas/smsowl

b. Or by adding library to composer.json and running update command

	{
	    "require": {
	        "mahoujas/smsowl": "^1.0.0"
	    }
	}

	php composer.phar update

Autoload the classes. Skip this step if you already done it.

	require 'vendor/autoload.php';

#### 2. Download PHP library directly

Download PHP library directly from this [link](https://raw.githubusercontent.com/mahoujas/smsowl-php/master/src/mahoujas/smsowl/smsowl.php)

Include download file in your project.

	include("/path-to-file/smsowl.php");

### Use namespaces

After you have downloaded and included library using either of above method, use the following namespace to access the class.

	use Mahoujas\SmsOwl\SmsOwl;
	use Mahoujas\SmsOwl\SmsType;

### Initialize the object

Credentials should be configured before sending SMS. Credential should be passed as constructor argument for SmsOwlClient constructor
	
	$smsOwl = new SmsOwl("YOUR-ACCOUNT-ID", "YOUR-API-KEY");


### Sending promotional SMS


##### sendPromotionalSms(senderId,to,message,smsType)

 - senderId: Sender Id registered and approved in Sms Owl portal.
 - to: Either single number with country code or array of phone numbers.
 - message: Message to be sent.
 - smsType: It can have either of two values `normal` or `flash` (optional)
	
	
	
		try{
		   $smsId  = $smsOwl->sendPromotionalSms("TESTER", "+9189876543210", "Hello PHP", SmsType::FLASH);
		   	//Process smsId if you need to
		}
		catch(Exception $e){
		    //Handle exception.
		}

Return value is Sms Id for single SMS or array of SMS ids for Bulk Sms


##### sendPromotionalSms(senderId,to,message)

Same as above but smsType defaults to `SmsType::NORMAL`

### Sending Transactional SMS

##### sendTransactionalSms(senderId,to,templateId,placeholderArray);

 - senderId: Sender Id registered and approved in Sms Owl portal.
 - to: Destination number with country prefix. Only single number can be specified.
 - templateId: Template Id of message. Only template message can be send via transactional route.
 - placeholderArray: Placeholder values.

Lets assume templateId of `39ec9de0efa8a48cb6e60ee5` with following template.

	Hello {customerName}, your invoice amount is Rs. {amount}.

-


	try{
        $smsId  = $smsOwl->sendTransactionalSms("TESTER", "+919876543210", "39ec9de0efa8a48cb6e60ee5",array('customerName' => 'Bob', 'amount' => '200' });
        //Process smsid if needed.
    }
    }catch(Exception $e){
        //Handle exception
    }


Return value is Sms Id.