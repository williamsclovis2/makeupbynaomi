<?php

class Payment {

    public static function getInput($key, $default = false) {
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    /**
     * A simple algorithm to generate a random reference to the order
     * @return string
     */
    public static function generateMerchTxnRef() {
        $txnRef = rand(9, 999);

        // Saved in the database associated with the order id

        return $txnRef;
    }

    /**
     * Generate secure hash from url params
     * Tested with the example provided in the pdf (page 74)
     * 
     * @param  array $params
     * @return string
     */
    public static function generateSecureHash($secret, array $params) {
        $secureHash = "";

        // Sorting params first based on the keys
        ksort($params);

        foreach ($params as $key => $value) {
            // Check if key equals to vpc_SecureHash or vpc_SecureHashType to discard it
            if (in_array($key, array('vpc_SecureHash', 'vpc_SecureHashType')))
                continue;

            // If key either starts with vpc_ or user_
            if (substr($key, 0, 4) === "vpc_" || substr($key, 0, 5) === "user_") {

                $secureHash .= $key . "=" . $value . "&";
            }
        }

        // Remove the last `&` character from string
        $secureHash = rtrim($secureHash, "&");

        //
        return strtoupper(hash_hmac('sha256', $secureHash, pack('H*', $secret)));
    }

    public static function pay($pda) {

        $returnResult = array('state' => false,
            'message' => 'Unknown error');

        $seconds = \Config::get('time/seconds');
        $_PDT['vpc_CardExp'] = $pda['cardExp'];
//            $_PDT['vpc_ReturnURL']=DN."/vpcapi"; // VPC URL
        $_PDT['vpc_Version'] = "1"; // VPC Version
        $_PDT['vpc_Command'] = "pay"; // Command Type
        $_PDT['vpc_AccessCode'] = "69E28154"; // Merchant AccessCode from jerome:
        // $_PDT['vpc_AccessCode']="CF9FAB30"; // Merchant AccessCode:
        // $_PDT['vpc_AccessCode']="090752E2"; // Merchant AccessCode Active
        $_PDT['vpc_MerchTxnRef'] = $pda['paymentRn']; // Merchant Transaction Reference
        $_PDT['vpc_Merchant'] = "TESTBOK000003"; // MerchantID from jerome
        // $_PDT['vpc_Merchant']="TESTBK0000003"; // MerchantID
        // $_PDT['vpc_Merchant']="BK0000003"; // MerchantID Active
        $_PDT['vpc_OrderInfo'] = $pda['order']; // Order Info
        $_PDT['vpc_Locale'] = "en"; // Local

        $secHashSec = "62E8CC6E522EEDEF625561CDAAAE74E8"; // Hash added  from jerome
        // $secHashSec="BE35CB8ED75A6C5BF23B121E3A9AEE74"; // Hash added 

        if ($pda['currency'] == "RWF") {
            $_PDT['vpc_Currency'] = 646;
            $mult = 1;
        } elseif ($pda['currency'] == "USD") {
            $_PDT['vpc_Currency'] = 840;
            $mult = 100;
        }
        // $mult = 100;

        $_PDT['vpc_Amount'] = $pda['amount'] * $mult;

        $_PDT['vpc_CardNum'] = $pda['cardNum']; // MerchantID
        $_PDT['vpc_CardSecurityCode'] = $pda['csc'];

        $vpcURL = "https://migs.mastercard.com.au/vpcdps";

        ksort($_PDT);

        // create a variable to hold the POST data information and capture it
        $postData = "";
        $ampersand = "";
        foreach ($_PDT as $key => $value) {
            // create the POST data input leaving out any fields that have no value
            if (strlen($value) > 0) {
                $postData .= $ampersand . urlencode($key) . '=' . urlencode($value);
                $ampersand = "&";
            }
        }

        $_PDT['vpc_SecureHash'] = strtoupper(hash_hmac('SHA256', $postData, pack('H*', $secHashSec)));
        $_PDT['vpc_SecureHashType'] = 'SHA256';

        $postData .= '&' . urlencode('vpc_SecureHash') . '=' . urlencode($_PDT['vpc_SecureHash']) . '&' . urlencode('vpc_SecureHashType') . '=' . urlencode($_PDT['vpc_SecureHashType']);

        // Get a HTTPS connection to VPC Gateway and do transaction turn on output buffering to stop response going to browser
        ob_start();
        // initialise Client URL object
        $ch = curl_init();
        // set the URL of the VPC
        curl_setopt($ch, CURLOPT_URL, $vpcURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        // connect
        curl_exec($ch);
        // get response
        $response = ob_get_contents();
        // turn output buffering off.
        ob_end_clean();
        // set up message paramter for error outputs
        $message = "";
        // serach if $response contains html error code
        if (strchr($response, "<html>") || strchr($response, "<html>")) {
            ;
            $message = $response;
        } else {
            // check for errors from curl
            if (curl_error($ch))
                $message = "%s: s" . curl_errno($ch) . "<br/>" . curl_error($ch);
        }
        // close client URL
        curl_close($ch);
        // Extract the available receipt fields from the VPC Response
        // If not present then let the value be equal to 'No Value Returned'
        $map = array();
        // process response if no errors
        if (strlen($message) == 0) {
            $pairArray = explode("&", $response);
            foreach ($pairArray as $pair) {
                $param = explode("=", $pair);
                $map[urldecode($param[0])] = urldecode($param[1]);
            }
            $message = null2unknown($map, "vpc_Message");
        }

        // Standard Receipt Data
        # merchTxnRef not always returned in response if no receipt so get input
        //TK//$merchTxnRef     = $vpc_MerchTxnRef;
        $merchTxnRef = $_PDT["vpc_MerchTxnRef"];

        $amount = null2unknown($map, "vpc_Amount");    //Purchase Amount:
        $vpc_Currency = null2unknown($map, "vpc_Currency");    //Purchase Amount:
        $locale = null2unknown($map, "vpc_Locale");
        $batchNo = null2unknown($map, "vpc_BatchNo");
        $command = null2unknown($map, "vpc_Command"); // Command
        $version = null2unknown($map, "vpc_Version"); // version
        $cardType = null2unknown($map, "vpc_Card");
        $orderInfo = null2unknown($map, "vpc_OrderInfo"); //Order Information
        $receiptNo = null2unknown($map, "vpc_ReceiptNo");
        $merchantID = null2unknown($map, "vpc_Merchant"); //Merchant ID:
        $authorizeID = null2unknown($map, "vpc_AuthorizeId");
        $transactionNo = null2unknown($map, "vpc_TransactionNo");
        $acqResponseCode = null2unknown($map, "vpc_AcqResponseCode");
        $txnResponseCode = null2unknown($map, "vpc_TxnResponseCode"); //  //VPC Transaction Response Code
        $txnResponseCode = getResponseDescription($txnResponseCode); //  //Transaction Response Code Description
        $message; // Message


        $_PDT['vpc_SecureHash'] = strtoupper(hash_hmac('SHA256', $postData, pack('H*', $secHashSec)));
        $_PDT['vpc_SecureHashType'] = 'SHA256';

        $first_data = urlencode('vpc_Amount') . '=' . urlencode(@$_PDT['vpc_Amount']);
        $first_data .= '&' . urlencode('vpc_Command') . '=' . urlencode(@$_PDT['vpc_Command']);
        $first_data .= '&' . urlencode('vpc_Currency') . '=' . urlencode(@$pda['currency']);
        $first_data .= '&' . urlencode('vpc_Locale') . '=' . urlencode(@$_PDT['vpc_Locale']);
        $first_data .= '&' . urlencode('vpc_MerchTxnRef') . '=' . urlencode(@$_PDT['vpc_MerchTxnRef']);
        $first_data .= '&' . urlencode('vpc_Merchant') . '=' . urlencode(@$_PDT['vpc_Merchant']);
        $first_data .= '&' . urlencode('vpc_OrderInfo') . '=' . urlencode(@$_PDT['vpc_OrderInfo']);
        $first_data .= '&' . urlencode('vpc_Version') . '=' . urlencode(@$_PDT['vpc_Version']);

        $second_data = urlencode('vpc_Amount') . '=' . urlencode(@$map['vpc_Amount']);
        $second_data .= '&' . urlencode('vpc_Command') . '=' . urlencode(@$map['vpc_Command']);
        $second_data .= '&' . urlencode('vpc_Currency') . '=' . urlencode(@$map['vpc_Currency']);
        $second_data .= '&' . urlencode('vpc_Locale') . '=' . urlencode(@$map['vpc_Locale']);
        $second_data .= '&' . urlencode('vpc_MerchTxnRef') . '=' . urlencode(@$map['vpc_MerchTxnRef']);
        $second_data .= '&' . urlencode('vpc_Merchant') . '=' . urlencode(@$map['vpc_Merchant']);
        $second_data .= '&' . urlencode('vpc_OrderInfo') . '=' . urlencode(@$map['vpc_OrderInfo']);
        $second_data .= '&' . urlencode('vpc_Version') . '=' . urlencode(@$map['vpc_Version']);

        $posted_hash = strtoupper(hash_hmac('SHA256', $first_data, pack('H*', $secHashSec)));
        $received_hash = strtoupper(hash_hmac('SHA256', $second_data, pack('H*', $secHashSec)));

        if (@$map['vpc_Message'] == "Approved" && $posted_hash == $received_hash) {

            $seconds = \Config::get('time/seconds');

            $amount = $amount / $mult;

            $receipt_string = "ReceiptNo: {$receiptNo} | TransactionNo: {$transactionNo} | Acquirer Response Code: {$acqResponseCode} | Bank Authorization ID: {$authorizeID} | Batch Number: {$batchNo} | Card Type: {$cardType} | Amount: {$amount} | Message: {$message}";

            $payment_data = (object) array('txnResponseCode' => $txnResponseCode,
                        'command' => $map['vpc_Command'],
                        'receipt_string' => $receipt_string,
                        'receiptNo' => $receiptNo,
                        'transactionNo' => $transactionNo,
                        'currency' => $vpc_Currency,
                        'orderInfo' => $orderInfo);

            $returnResult = array('state' => true,
                'payment_data' => $payment_data,
                'message' => 'Approved');
        } else {
            $returnResult = array('state' => false,
                'message' => $message);
        }

        return $returnResult;
    }

    public static function paymentConfirmedEmail($memberIDs) {

        foreach ($memberIDs as $member_reg_ID) {
            $participantTable = new \Participant();
            $participantTable->selectQuery("SELECT `ID`,`code`,`payment_rn`,`payment_method`,`residence_country`,`firstname`,`lastname`,`othername`,`email`,`amount`,`currency`,`payment_state`,`category`,`pass_type`,`state`,`host_account_ID`,`invite_ID`,`token` FROM `events_participant` WHERE `ID`=? AND `payment_state`='Confirmed' ORDER BY `ID` DESC", array($member_reg_ID));
            $participant_data = $participantTable->first();

            $subject = 'Receipt: Transform Africa Summit 2017 Registration';

            $currency = $participant_data->currency;

            $messageText_0 = 'Dear <b>' . $participant_data->firstname . ' ' . $participant_data->lastname . ' ' . $participant_data->othername . '</b>,';

            if ($participant_data->state != "Confirmed") {
                $messageText_1 = 'Your payment for the Transform Africa Summit 2017 (Kigali, Rwanda, 10 - 12 May 2017) has been done successfully. We are reviewing your registration and get back to you within 7 working days';
            } else {
                $messageText_1 = 'Thank you for registration for Africa’s largest ICT summit, The Transform Africa Summit 2017 in Kigali Rwanda.<br><br>
                Your payment has been successfully processed.';
            }

            $messageText_2 = 'Your Payment details are:';

            $messageText_3 = '<b>Confirmation</b><br>';

            $messageText_4 = 'You will receive your confirmation to attend the summit via email within 7 working 
            days of your registration (which will be complete upon receipt of payment)';

            $messageText_5 = 'Kindly email us on enquiries@smartafrica.org, if you have not received your 
            confirmation within this period.';

            $messageText_6 = '<b>Collecting your badge</b>';

            $messageText_7 = 'The accreditation center is located opposite the Convention Center at the Parliament 
            building.';

            $messageText_8 = 'You will be able to collect your badge from the 23rd of April 2017. Ensure that you 
            bring the identification document you used in your registration process.';

            $messageText_9 = 'Please note that your badge will only be issued once you have received your 
            confirmation to attend the summit.';

            $message_body = '
                <body>
                    <div style="padding: 10px; margin-left: 10px margin-right: 10px">

                        <section>
                            <p style="margin-bottom: 25px; font-size: 13px;">
                                ' . $messageText_0 . '
                            </p>
                            <p style="font-size: 13px;">
                                ' . $messageText_1 . '
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_2 . '
                            </p>

                            <p style="font-size: 13px;">
                                Registration ID: ' . $participant_data->code . '<br>
                                Names: ' . $participant_data->firstname . ' ' . $participant_data->lastname . ' ' . $participant_data->othername . '<br>
                                Pass Type: ' . $participant_data->pass_type . '<br>
                                Price: ' . $currency . ' ' . $participant_data->amount . '<br>
                                Payment Receipt: <a href="' . DN . '/receipt-single/' . $participant_data->token . '"> [Click here to view your Receipt]</a>
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_3 . '
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_4 . '
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_5 . '
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_6 . '
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_7 . '
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_8 . '
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_9 . '
                            </p>
                            <p style="font-size: 13px;">
                                <b>Accommodation:</b><br>
                                Please book your accommodation only when you have received your confirmation to attend.<br><br>
                                <a href="' . DN . '/accomodation">Click here</a> to book accommodation and use promotional code <b>TAS2017</b> to receive discounted conference rates up till 10 April 2017.
                                
                            </p>
                            <p style="font-size: 13px;">
                                <b>Plan your trip:</b><br>
                                <a href="' . DN . '/plan">Click here for travel information including visas.</a>
                            </p>
                            <p style="font-size: 13px;">
                                <b>Dedicated Bus Network:</b><br>
                                To ease your travel around Kigali, you will receive an email at a later date with details on the dedicated 
                                Transform Africa Summit bus network.  You will be able to purchase pre-paid travelcards giving you access 
                                to the entire Transform Africa Summit bus network during your stay in Kigali.
                            </p>
                            <p style="font-size: 13px;">
                                <b>Car hire:</b><br>
                                Should you wish to hire a car during your stay here? Please email transformafricasummit@smartafrica.org
                            </p>
                            <p style="font-size: 13px;">
                                <b>Stay connected</b> <br>
                                <b>Twitter / Facebook:</b> TASummit <br>
                                <b>Connect with our official tag:</b> #TAS2017<br>
                                <b>Youtube:</b> TransformAfricaSummit<br>
                            </p>
                            <br>
                        </section>
                        <div style="font-size: 13px; padding: 0px; color: #222; position: relative">
                            <div style="background: #fff;text-align: left; color: #222; border-top: 1px solid #ddd; padding: 10px 5px">
                                Regards,<br><br>

                                Transform Africa Summit Team<br>
                                Smart Africa Secretariat<br>
                                E:  enquiries@smartafrica.org<br>
                                T:  + 250 732 301011<br>
                                + 250 732 301013<br>
                                + 250 732 301014<br>
                                <a href="' . DN . '/tcs">Terms & Conditions</a> | 
                                <a href="' . DN . '/privacy">Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                </body>
            ';

            $message_alt = $messageText_0 . ' ' . $messageText_1 . ' ' . $messageText_2;

            $contactDetails['from_email'] = 'enquiries@smartafrica.org';
            $contactDetails['from_names'] = 'Smart Africa Team';
            $contactDetails['to_email'] = $participant_data->email;

            $contactDetails['attach'] = false;

            $email_status = Functions::smartMailer($contactDetails, $subject, $message_body, $message_alt);
        }
        return true;
    }

    public static function paymentCancelledEmail($memberIDs) {

        foreach ($memberIDs as $member_reg_ID) {
            $participantTable = new \Participant();
            $participantTable->selectQuery("SELECT `ID`,`code`,`payment_rn`,`payment_method`,`residence_country`,`firstname`,`lastname`,`othername`,`email`,`amount`,`currency`,`payment_state`,`category`,`pass_type`,`state`,`host_account_ID`,`invite_ID`,`token` FROM `events_participant` WHERE `ID`=? AND `payment_state`='Cancelled' ORDER BY `ID` DESC", array($member_reg_ID));
            $participant_data = $participantTable->first();

            $subject = 'Your payment link for Transform Africa Summit 2017';

            $currency = $participant_data->currency;
            // $currency = 'RWF';
            print_r($currency);

            $messageText_0 = 'Dear <b>' . $participant_data->firstname . ' ' . $participant_data->lastname . ' ' . $participant_data->othername . '</b>,';

            if ($participant_data->state != "Confirmed") {
                $messageText_1 = 'Thank you for registration for Africa’s largest ICT summit, 
                The Transform Africa Summit 2017 in Kigali Rwanda.<br><br>
                It appears that your have cancelled your card transaction mid-way through the process.';
            } else {
                $messageText_1 = 'Your payment for the Transform Africa Summit 2017 (Kigali, Rwanda, 10 - 12 May 2017) has been done successfully.';
            }

            $messageText_2 = 'Your Payment details are:';

            $messageText_3 = '<b>Confirmation</b><br>';

            $messageText_4 = 'You will receive your confirmation to attend the summit via email within 7 working 
            days of your registration (which will be complete upon receipt of payment)';

            $messageText_5 = 'Kindly email us on enquiries@smartafrica.org, if you have not received your 
            confirmation within this period.';

            $messageText_6 = '<b>Collecting your badge</b>';

            $messageText_7 = 'The accreditation center is located opposite the Convention Center at the Parliament 
            building.';

            $messageText_8 = 'You will be able to collect your badge from the 23rd of April 2017. Ensure that you 
            bring the identification document you used in your registration process.';

            $messageText_9 = 'Please note that your badge will only be issued once you have received your 
            confirmation to attend the summit.';

            $message_body = '
                <body>
                    <div style="padding: 10px; margin-left: 10px margin-right: 10px">

                        <section>
                            <p style="margin-bottom: 25px; font-size: 13px;">
                                ' . $messageText_0 . '
                            </p>
                            <p style="font-size: 13px;">
                                ' . $messageText_1 . '
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_2 . '
                            </p>

                            <p style="font-size: 13px;">
                                Registration ID: ' . $participant_data->code . '<br>
                                Names: ' . $participant_data->firstname . ' ' . $participant_data->lastname . ' ' . $participant_data->othername . '<br>
                                Pass Type: ' . $participant_data->pass_type . '<br>
                                Price: ' . $currency . ' ' . $participant_data->amount . '<br>
                                Kindly follow this link to go through the payment process again <a href="' . DN . '/payment/' . $participant_data->code . '"> [Click here to Pay]</a>
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_3 . '
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_4 . '
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_5 . '
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_6 . '
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_7 . '
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_8 . '
                            </p>
                            <p style="font-size: 13px;">
                                 ' . $messageText_9 . '
                            </p>
                            <p style="font-size: 13px;">
                                <b>Accommodation:</b><br>
                                <a href="' . DN . '/accomodation">Click here to book your accommodation. You will need your registration ID.</a>
                            </p>
                            <p style="font-size: 13px;">
                                <b>Plan your trip:</b><br>
                                <a href="' . DN . '/plan">Click here for travel information including visas requirements.</a>
                            </p>
                            <p style="font-size: 13px;">
                                <b>Dedicated Bus Network:</b><br>
                                To ease your travel around Kigali, you will receive an email at a later date with details on the dedicated Transform Africa Summit bus network.  You will be able to purchase pre-paid travelcards giving you access to the entire Transform Africa Summit bus network during your stay in Kigali.
                            </p>
                            <p style="font-size: 13px;">
                                <b>Car hire:</b><br>
                                Should you wish to hire a car during your stay here? Please email transformafricasummit@smartafrica.org
                            </p>
                            <p style="font-size: 13px;">
                                <b>Stay connected</b> <br>
                                <b>Twitter / Facebook:</b> TASummit <br>
                                <b>Connect with our official tag:</b> #TAS2017<br>
                                <b>Youtube:</b> TransformAfricaSummit<br>
                            </p>
                            <br>
                        </section>
                        <div style="font-size: 13px; padding: 0px; color: #222; position: relative">
                            <div style="background: #fff;text-align: left; color: #222; border-top: 1px solid #ddd; padding: 10px 5px">
                                Regards,<br><br>

                                Transform Africa Summit Team<br>
                                Smart Africa Secretariat<br>
                                E:  enquiries@smartafrica.org<br>
                                T:  + 250 732 301011<br>
                                + 250 732 301013<br>
                                + 250 732 301014<br>
                                <a href="' . DN . '/tcs">Terms & Conditions</a> | 
                                <a href="' . DN . '/privacy">Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                </body>
            ';

            $message_alt = $messageText_0 . ' ' . $messageText_1 . ' ' . $messageText_2;

            $contactDetails['from_email'] = 'tas2017@smartafrica.org';
            $contactDetails['from_names'] = 'Smart Africa Team';
            $contactDetails['to_email'] = $participant_data->email . ', tas2017registration@cube.rw';

            $contactDetails['attach'] = false;

            $email_status = Functions::smartMailer($contactDetails, $subject, $message_body, $message_alt);
        }
        return true;
    }

}

?>