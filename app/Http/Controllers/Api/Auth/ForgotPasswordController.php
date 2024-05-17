<?php
/*
 * LaraClassifier - Classified Ads Web Application
 * Copyright (c) BeDigit. All Rights Reserved
 *
 * Website: https://laraclassifier.com
 * Author: BeDigit | https://bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - https://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Auth\Traits\VerificationTrait;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Front\ForgotPasswordRequest;
use App\Http\Controllers\Api\Auth\Helpers\SendsPasswordResetEmails;
use App\Http\Controllers\Api\Auth\Helpers\SendsPasswordResetSms;

/**
 * @group Authentication
 */
class ForgotPasswordController extends BaseController
{
    use SendsPasswordResetEmails, SendsPasswordResetSms;
	use VerificationTrait;
    
    /**
     * Forgot password
	 *
	 * @bodyParam auth_field string required The user's auth field ('email' or 'phone'). Example: email
	 * @bodyParam email string The user's email address or username (Required when 'auth_field' value is 'email'). Example: user@demosite.com
	 * @bodyParam phone string The user's mobile phone number (Required when 'auth_field' value is 'phone'). Example: null
	 * @bodyParam phone_country string required The user's phone number's country code (Required when the 'phone' field is filled). Example: null
	 * @bodyParam captcha_key string Key generated by the CAPTCHA endpoint calling (Required when the CAPTCHA verification is enabled from the Admin panel).
     *
	 * @param \App\Http\Requests\Front\ForgotPasswordRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function sendResetLink(ForgotPasswordRequest $request): \Illuminate\Http\JsonResponse
	{
		// Get the right auth field
		$authField = getAuthField();
        
        // Send the Token by SMS
        if ($authField == 'phone') {
            return $this->sendResetTokenSms($request);
        }
        
        // Go to the core process
        return $this->sendResetLinkEmail($request);
    }
}
