<?php

class SubscriberController {

    public static function addAccount($fields) {
        $diagnoArray[0] = 'NO_ERRORS';
        $subscriberTable = new \Subscriber();

        $str = new \Str();

        $firstname = @$fields['firstname'];

        $lastname = @$fields['lastname'];

        $telephone = @$fields['telephone'];
        $photo = @$fields['photo'];
        $registration_ID = @$fields['code'];

        $email = @$fields['email'];

        if (!isset($fields['email'])) {
            return false;
        }
        $validate = new Validate();
        $pre_username = $str->sanAsUsername(remSpaces($firstname));
        $username = $validate->autoUniqueMaker('subscriber', 'username', $pre_username);

        $seconds = \Config::get('time/seconds');

        $salt = Hash::salt(32);
        $generate_password = Functions::generateStrongPassword(6, false, 'ud');
        $password = Hash::make($generate_password, $salt);

        if ($diagnoArray[0] == 'NO_ERRORS') {

            $subscriber_exist = $subscriberTable->find_user($email, array('ID'));
            if (!$subscriber_exist) {
                try {
                    $subscriberTable->insert(array(
                        'registration_ID' => $registration_ID,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'phone' => $telephone,
                        'photo' => $photo,
                        'username' => $username,
                        'email' => $email,
                        'password' => $password,
                        'salt' => $salt,
                        'added_temp' => $seconds,
                        'added_date' => Dates::get('d-m-Y H:i:s', $seconds),
                        'state' => "Activated"
                    ));
                } catch (Exeption $e) {
                    $diagnoArray[0] = "ERRORS_FOUND";
                    $diagnoArray[] = $e->getMessage();
                }

                $find_user = $subscriberTable->find_user($email, array('ID'));
                if ($find_user) {

                    $subscriber_data = $subscriberTable->data();

                    $subscriber_ID = $subscriber_data->ID;

                    $cur_digit = strlen($subscriber_ID);
                    $total_digit = 6;
                    $code_string = $subscriber_ID;

                    if ($cur_digit < $total_digit) {
                        while (strlen($code_string) < $total_digit) {
                            $code_string = '0' . $code_string;
                        }
                    }

                    $categ_code = "GRP";
                    $subscriber_code = $categ_code . '-' . $code_string;

                    $subscriberTable->update(array('group_ID' => $subscriber_code), $subscriber_ID);

                    $subject = "Transform Africa Summit 2017 Group Booking Account ";

                    $messageText_0 = 'Dear <b>' . $firstname . ' ' . $lastname . '</b>,';

                    $messageText_1 = 'Further to communication from the Smart 
                    Africa team with regard to group booking for your organization 
                    for the Transform Africa Summit 2017, your group booking 
                    account has been successfully created.';

                    $messageText_2 = '<b>Deadline for registration: 25th April 2017.</b>';

                    $messageText_3 = '**Kindly save this email for future reference**';

                    $messageText_4 = '<b>How the group booking portal works</b><br>';

                    $messageText_5 = '1. Use the link below (Transform Africa Summit 
                        2017 Group Booking Portal) and log in using the following details:-';

                    $messageText_6 = '<b>2. Assigned passes</b><br> 
                    These are passes that you have already been pre-assigned by the Smart 
                    Africa team on a discount or complimentary basis for Smart Africa Member 
                    state officials, Smart Africa Private Sector members, Sponsors & Exhibitors.<br> 

                    These are already listed in your booking portal. Simply assign individuals & 
                    send their invites so that they may complete their registration. <br>

                    They will not appear if you do not have pre-assigned passes.';

                    $messageText_7 = '<b>3. Purchased tickets</b><br>
                    These are passes that you can purchase if you should require more passes 
                    than assigned. These passes can only be purchased once your group members 
                    have completed registration.<br>

                    This list will be empty when you first log on and will populate itself as 
                    you send invites to group individuals and select their passes.';

                    $messageText_8 = '<b>4. Completing your Groups Registrations & Processing 
                    Payment if applicable</b><br>

                    a.  An invoice can be downloaded from our account at any time when your 
                    group registration is complete. <br>
                    b.  Please note that closing your group and processing an invoice for 
                    payment will not allow for further registrations under your group account. <br>
                    A new group account can be created for you for additional registrations 
                    by sending an email to enquiries@smartafrica.org.';

                    $message_body = '
                        <body>
                            <div style="padding: 10px; margin-left: 10px; margin-right: 10px">

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
                                         ' . $messageText_3 . '
                                    </p>
                                    <p style="font-size: 13px;">
                                         ' . $messageText_4 . '
                                    </p>
                                    <p style="font-size: 13px;">
                                         ' . $messageText_5 . '
                                    </p>
                                    <p style="font-size: 13px;">
                                        <b>Username:</b> ' . $email . '<br/>
                                        <b>Password:</b> ' . $generate_password . '<br>
                                        You will be able to log-in within 30 mins from receipt of this email
                                    </p>
                                    <p style="font-size: 13px;">
                                        <b>Link:</b> <a href="' . DN . '/login">Login Now</a>
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
                                    <br>
                                </section>
                                <section>
                                    <p style="font-size: 13px;">
                                        <b>Accommodation:</b><br>
                                        <a href="' . DN . '/accomodation">Click here to submit your group accommodation requirements.</a> <br><br>
                                        
                                        Use promotional code<b>TAS2017</b> to receive discounted conference rates up till 10 April 2017.

                                    </p>
                                    <p style="font-size: 13px;">
                                        <b>Plan your trip:</b><br>
                                        <a href="' . DN . '/plan">Click here for travel information including visas requirements.</a>
                                    </p>
                                    <p style="font-size: 13px;">
                                        <b>Dedicated Bus Network:</b><br>
                                        To ease your travel around Kigali, you will receive an email at a later date with details 
                                        on the dedicated Transform Africa Summit bus network. You will be able to purchase pre-paid 
                                        travelcards giving you access to the entire Transform Africa Summit bus network during your 
                                        stay in Kigali.
                                    </p>
                                    <p style="font-size: 13px;">
                                        <b>Car hire:</b><br>
                                        Should you wish to hire a car during your stay here? Please email transport@smartafrica.org.
                                    </p>
                                    <br>
                                    <p style="font-size: 13px;">
                                        <b>Stay connected</b> <br>
                                        <b>Twitter / Facebook:</b> TASummit <br>
                                        <b>Connect with our official tag:</b> #TAS2017<br>
                                        <b>Youtube:</b> TransformAfricaSummit<br>
                                    </p>
                                    <br>
                                    <p style="font-size: 13px;">
                                        If you have received this email in error, please forward to it enquiries@smartafrica.org.
                                    </p>
                                    <br>
                                </section>
                                <div style="font-size: 13px; padding: 0px; position: relative">
                                    <div style="text-align: left; border-top: 1px solid #ddd; padding: 10px 5px">
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
                    $contactDetails['to_email'] = $email;

                    $contactDetails['attach'] = false;

                    $email_status = Functions::smartMailer($contactDetails, $subject, $message_body, $message_alt);
                }
            }
        }
    }

    public static function addSpecialAccount() {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();
        $prfx = 'subscriber-';
        foreach ($_POST as $index => $val) {
            $ar = explode($prfx, $index);
            if (count($ar)) {
                $_SIGNUP[end($ar)] = $val;
            }
        }

        global $session_user_data;

        $validation = $validate->check($_SIGNUP, array(
            'firstname' => array(
                'name' => 'First Name',
                'string' => true,
                'required' => true
            ),
            'lastname' => array(
                'name' => 'Last Names',
                'string' => true
            ),
            'email' => array(
                'name' => 'Email Address',
                'email' => true,
                'unique' => "subscriber",
                'required' => true
            ),
            'company_name' => array(
                'name' => 'Company name'
            )
        ));

        if ($validation->passed()) {
            $subscriberTable = new \Subscriber();

            $str = new \Str();

            $_SIGNUP = (object) $_SIGNUP;

            $firstname = $str->sanAsName($_SIGNUP->firstname);

            $lastname = $str->sanAsName($_SIGNUP->lastname);

            $company_name = $_SIGNUP->company_name;

            $pre_username = $str->sanAsUsername(remSpaces($firstname));
            $username = $validate->autoUniqueMaker('subscriber', 'username', $pre_username);
            $_POST['signup_username'] = $username;
            $email = $str->data_in($_SIGNUP->email);

            $seconds = \Config::get('time/seconds');

            $salt = Hash::salt(32);
            $generate_password = Functions::generateStrongPassword(6, false, 'ud');
            $password = Hash::make($generate_password, $salt);
            if ($diagnoArray[0] == 'NO_ERRORS') {
                try {
                    $subscriberTable->insert(array(
                        'admin_ID' => $session_user_data->ID,
                        'type' => 'Group',
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'company_name' => $company_name,
                        'username' => $username,
                        'email' => $email,
                        'password' => $password,
                        'salt' => $salt,
                        'added_date' => Dates::get('d-m-Y H:i:s', $seconds),
                        'added_temp' => $seconds,
                        'state' => "Activated"
                    ));
                } catch (Exeption $e) {
                    $diagnoArray[0] = "ERRORS_FOUND";
                    $diagnoArray[] = $e->getMessage();
                }

                $find_user = $subscriberTable->find_user($email, array('ID'));
                if ($find_user) {

                    $subscriber_data = $subscriberTable->data();

                    $subscriber_ID = $subscriber_data->ID;

                    $cur_digit = strlen($subscriber_ID);
                    $total_digit = 6;
                    $code_string = $subscriber_ID;

                    if ($cur_digit < $total_digit) {
                        while (strlen($code_string) < $total_digit) {
                            $code_string = '0' . $code_string;
                        }
                    }

                    $categ_code = "GRP";
                    $subscriber_code = $categ_code . '-' . $code_string;

                    $subscriberTable->update(array('group_ID' => $subscriber_code), $subscriber_ID);

                    Session::put("success", "Account created successfully. The Default password was sent to $email");

                    $subject = "Transform Africa Summit 2017 Group Booking Account";

                    $messageText_0 = 'Dear <b>' . $firstname . ' ' . $lastname . '</b>,';

                    $messageText_1 = 'Further to communication from the Smart Africa team with regard to group booking 
                    for your organization for the Transform Africa Summit 2017, your group booking 
                        account has been successfully created.<br><br>
                    <b>Your group ID is ' . $subscriber_code . '</b><br>
                    <b>Deadline for registration: 25<sup>th</sup> April 2017</b><br>
                    ** Kindly save this email for future reference **';

                    $messageText_2 = '<b>How the group booking portal works</b><br>
                    1.  Use the link below (Transform Africa Summit 2017 Group Booking Portal) 
                    and log in using the following details:-';

                    $messageText_3 = '2. <b>Assigned passes </b><br>
These are passes that you have already been pre-assigned by the Smart Africa 
team on a discount or complimentary basis for Smart Africa Member state officials, 
Smart Africa Private Sector members, Sponsors & Exhibitors. <br>

These are already listed in your booking portal. Simply assign individuals & send 
their invites so they may complete their registration. <br>

They will not appear if you do not have pre-assigned passes.';

                    $messageText_4 = '3. <b>Purchased tickets </b><br>
These are passes that you will purchase once your group members have completed registration.<br>

This list will be empty when you first log on and will populate itself as you send invites to group individuals and select their passes. 
';

                    $messageText_5 = '4.  <b>Completing your Groups Registrations & Processing Payment if applicable</b><br>  

a.  An invoice can be downloaded from our account at any time when your group registration is complete. <br>
b.  Please note that closing your group and processing an invoice for payment will not allow for further registrations under your group account. <br>
c.  A new group account can be created for you for additional registrations by sending an email to enquiries@smartafrica.org. 
';

                    // $messageText_6 = '<p style="font-size: 13px;">
                    //             <b>Setting up meetings at the Summit – Meet me at TAS</b><br>
                    //             From March 2017, you will be able to log-in to your profile and set-up meetings with other delegates as so will others be able to do the same to meet with you. Your company name will be displayed as well as your job title and so will that of other delegates so you can select who you would like to request a meeting with. You will be notified when the meeting requests start. 
                    //             If you wish to not participate in Meet me @ TAS, click here. 
                    //         </p>';

                    $message_body = '
                        <body>
                            <div style="padding: 10px; margin-left: 10px; margin-right: 10px">

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
                                        Username: ' . $email . '
                                    </p>
                                    <p style="font-size: 13px;">
                                        Password: ' . $generate_password . '
                                    </p>
                                    <p style="font-size: 13px;">
                                        Link: <a href="' . DN . '/login">Login Now</a><br>
                                        You will be able to log-in within 30 mins from receipt of this email
                                    </p>
                                    <p style="font-size: 13px;">
                                        You will be able to log-in within 30 mins from receipt of this email
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
                                        <b>Accommodation:</b><br>
                                        <a href="' . DN . '/accomodation">Click here to submit your group accommodation requirements.</a> <br><br>
                                        
                                        Use promotional code<b>TAS2017</b> to receive discounted conference rates up till 10 April 2017.

                                    </p>
                                    <p style="font-size: 13px;">
                                        <b>Plan your trip:</b><br>
                                        <a href="' . DN . '/plan">Click here for travel information including visas requirements.</a>
                                    </p>
                                    <p style="font-size: 13px;">
                                        <b>Dedicated Bus Network:</b><br>
                                        To ease your travel around Kigali, you will receive an email at a later date with details on 
                                        the dedicated Transform Africa Summit bus network.  You will be able to purchase pre-paid 
                                        travel cards giving you access to the entire Transform Africa Summit bus network during 
                                        your stay in Kigali.
                                    </p>
                                    <p style="font-size: 13px;">
                                        <b>Car hire:</b><br>
                                        Should you wish to hire a car during your stay here? Please email 
                                        transport@smartafrica.org
                                    </p>
                                    ' . @$messageText_6 . '
                                    <p style="font-size: 13px;">
                                        <b>Stay connected</b> <br>
                                        <b>Twitter / Facebook:</b> TASummit <br>
                                        <b>Connect with our official tag:</b> #TAS2017<br>
                                        <b>Youtube:</b> TransformAfricaSummit<br><br>
                                        If you have received this email in error, please forward to it enquiries@smartafrica.org. 

                                    </p>
                                    <br>
                                </section>
                                <div style="font-size: 13px; padding: 0px; position: relative">
                                    <div style="text-align: left; border-top: 1px solid #ddd; padding: 10px 5px">
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
                    $contactDetails['to_email'] = $email;

                    $contactDetails['attach'] = false;

                    $email_status = Functions::smartMailer($contactDetails, $subject, $message_body, $message_alt);
                }
            }
        } else {
            $diagnoArray[0] = 'ERRORS_FOUND';
            $error_msg = ul_array($validation->errors());
        }
        if ($diagnoArray[0] == 'ERRORS_FOUND') {
            return (object) [
                        'ERRORS' => true,
                        'ERRORS_SCRIPT' => $validate->getErrorLocation()
            ];
        } else {
            $subscriber_data = $subscriberTable->data();
            return (object) [
                        'ERRORS' => false,
                        'SUCCESS' => true,
                        'ERRORS_SCRIPT' => array('data' => $subscriber_data)
            ];
        }
    }

    public static function addSpecialAccountInvite() {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();
        $prfx = 'subscriber-';
        foreach ($_POST as $index => $val) {
            $ar = explode($prfx, $index);
            if (count($ar)) {
                $_SIGNUP[end($ar)] = $val;
            }
        }

        global $session_user_data;

        $validation = $validate->check($_SIGNUP, array(
            'firstname' => array(
                'name' => 'First Name',
                'string' => true,
                'required' => true
            ),
            'lastname' => array(
                'name' => 'Last Names',
                'string' => true
            ),
            'email' => array(
                'name' => 'Email Address',
                'email' => true,
                'unique' => "subscriber",
                'required' => true
            ),
            'company_name' => array(
                'name' => 'Company name'
            )
        ));

        if ($validation->passed()) {
            $subscriberTable = new \Subscriber();

            $str = new \Str();

            $_SIGNUP = (object) $_SIGNUP;

            $firstname = $str->sanAsName($_SIGNUP->firstname);

            $lastname = $str->sanAsName($_SIGNUP->lastname);

            $company_name = $_SIGNUP->company_name;

            $pre_username = $str->sanAsUsername(remSpaces($firstname));
            $username = $validate->autoUniqueMaker('subscriber', 'username', $pre_username);
            $_POST['signup_username'] = $username;
            $email = $str->data_in($_SIGNUP->email);

            $seconds = \Config::get('time/seconds');

            $salt = Hash::salt(32);
            $generate_password = Functions::generateStrongPassword(6, false, 'ud');
            $password = Hash::make($generate_password, $salt);
            if ($diagnoArray[0] == 'NO_ERRORS') {
                try {
                    $subscriberTable->insert(array(
                        'admin_ID' => $session_user_data->ID,
                        'type' => 'Individual',
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'company_name' => $company_name,
                        'username' => $username,
                        'email' => $email,
                        'password' => $password,
                        'salt' => $salt,
                        'added_date' => Dates::get('d-m-Y H:i:s', $seconds),
                        'added_temp' => $seconds,
                        'state' => "Activated"
                    ));
                } catch (Exeption $e) {
                    $diagnoArray[0] = "ERRORS_FOUND";
                    $diagnoArray[] = $e->getMessage();
                }

                $find_user = $subscriberTable->find_user($email, array('ID'));
                if ($find_user) {

                    $subscriber_data = $subscriberTable->data();

                    $subscriber_ID = $subscriber_data->ID;

                    $cur_digit = strlen($subscriber_ID);
                    $total_digit = 6;
                    $code_string = $subscriber_ID;

                    if ($cur_digit < $total_digit) {
                        while (strlen($code_string) < $total_digit) {
                            $code_string = '0' . $code_string;
                        }
                    }

                    $categ_code = "GRP";
                    $subscriber_code = $categ_code . '-' . $code_string;

                    $subscriberTable->update(array('group_ID' => $subscriber_code), $subscriber_ID);

                    Session::put("success", "Account created successfully. The Default password was sent to $email");

                    $subject = "Transform Africa Summit 2017 Group Booking Account";

                    $messageText_0 = 'Dear <b>' . $firstname . ' ' . $lastname . '</b>,';

                    $messageText_1 = 'Further to communication from the Smart Africa team with regard to group booking 
                    for your organization for the Transform Africa Summit 2017, your group booking 
                        account has been successfully created.<br><br>
                    <b>Your group ID is ' . $subscriber_code . '</b><br>
                    <b>Deadline for registration: 25<sup>th</sup> April 2017</b><br>
                    ** Kindly save this email for future reference **';

                    $messageText_2 = '<b>How the group booking portal works</b><br>
                    1.  Use the link below (Transform Africa Summit 2017 Group Booking Portal) 
                    and log in using the following details:-';

                    $messageText_3 = '2. <b>Assigned passes </b><br>
These are passes that you have already been pre-assigned by the Smart Africa 
team on a discount or complimentary basis for Smart Africa Member state officials, 
Smart Africa Private Sector members, Sponsors & Exhibitors. <br>

These are already listed in your booking portal. Simply assign individuals & send 
their invites so they may complete their registration. <br>

They will not appear if you do not have pre-assigned passes.';

                    $messageText_4 = '3. <b>Purchased tickets </b><br>
These are passes that you will purchase once your group members have completed registration.<br>

This list will be empty when you first log on and will populate itself as you send invites to group individuals and select their passes. 
';

                    $messageText_5 = '4.  <b>Completing your Groups Registrations & Processing Payment if applicable</b><br>  

a.  An invoice can be downloaded from our account at any time when your group registration is complete. <br>
b.  Please note that closing your group and processing an invoice for payment will not allow for further registrations under your group account. <br>
c.  A new group account can be created for you for additional registrations by sending an email to enquiries@smartafrica.org. 
';

                    // $messageText_6 = '<p style="font-size: 13px;">
                    //             <b>Setting up meetings at the Summit – Meet me at TAS</b><br>
                    //             From March 2017, you will be able to log-in to your profile and set-up meetings with other delegates as so will others be able to do the same to meet with you. Your company name will be displayed as well as your job title and so will that of other delegates so you can select who you would like to request a meeting with. You will be notified when the meeting requests start. 
                    //             If you wish to not participate in Meet me @ TAS, click here. 
                    //         </p>';

                    $message_body = '
                        <body>
                            <div style="padding: 10px; margin-left: 10px; margin-right: 10px">

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
                                        Username: ' . $email . '
                                    </p>
                                    <p style="font-size: 13px;">
                                        Password: ' . $generate_password . '
                                    </p>
                                    <p style="font-size: 13px;">
                                        Link: <a href="' . DN . '/login">Login Now</a><br>
                                        You will be able to log-in within 30 mins from receipt of this email
                                    </p>
                                    <p style="font-size: 13px;">
                                        You will be able to log-in within 30 mins from receipt of this email
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
                                        <b>Accommodation:</b><br>
                                        <a href="' . DN . '/accomodation">Click here to submit your group accommodation requirements.</a> <br><br>
                                        
                                        Use promotional code<b>TAS2017</b> to receive discounted conference rates up till 10 April 2017.

                                    </p>
                                    <p style="font-size: 13px;">
                                        <b>Plan your trip:</b><br>
                                        <a href="' . DN . '/plan">Click here for travel information including visas requirements.</a>
                                    </p>
                                    <p style="font-size: 13px;">
                                        <b>Dedicated Bus Network:</b><br>
                                        To ease your travel around Kigali, you will receive an email at a later date with details on 
                                        the dedicated Transform Africa Summit bus network.  You will be able to purchase pre-paid 
                                        travel cards giving you access to the entire Transform Africa Summit bus network during 
                                        your stay in Kigali.
                                    </p>
                                    <p style="font-size: 13px;">
                                        <b>Car hire:</b><br>
                                        Should you wish to hire a car during your stay here? Please email 
                                        transport@smartafrica.org
                                    </p>
                                    ' . @$messageText_6 . '
                                    <p style="font-size: 13px;">
                                        <b>Stay connected</b> <br>
                                        <b>Twitter / Facebook:</b> TASummit <br>
                                        <b>Connect with our official tag:</b> #TAS2017<br>
                                        <b>Youtube:</b> TransformAfricaSummit<br><br>
                                        If you have received this email in error, please forward to it enquiries@smartafrica.org. 

                                    </p>
                                    <br>
                                </section>
                                <div style="font-size: 13px; padding: 0px; position: relative">
                                    <div style="text-align: left; border-top: 1px solid #ddd; padding: 10px 5px">
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
                    $contactDetails['to_email'] = $email;

                    $contactDetails['attach'] = false;

                    $email_status = Functions::smartMailer($contactDetails, $subject, $message_body, $message_alt);
                }
            }
        } else {
            $diagnoArray[0] = 'ERRORS_FOUND';
            $error_msg = ul_array($validation->errors());
        }
        if ($diagnoArray[0] == 'ERRORS_FOUND') {
            return (object) [
                        'ERRORS' => true,
                        'ERRORS_SCRIPT' => $validate->getErrorLocation()
            ];
        } else {
            $subscriber_data = $subscriberTable->data();
            return (object) [
                        'ERRORS' => false,
                        'SUCCESS' => true,
                        'ERRORS_SCRIPT' => array('data' => $subscriber_data)
            ];
        }
    }

    public static function aSpecialAccountInviteReminder($email, $user_fullname) {

        if ($email != '' && $user_fullname != '') {






            // Session::put("success","Account created successfully. The Default password was sent to $email");

            $subject = "Transform Africa Summit 2017 Group Registration Reminder";

            $messageText_0 = 'Dear <b>' . $user_fullname . '</b>,';

            $messageText_1 = 'Your group account was created for your organization to attend the Transform Africa Summit 2017 in Kigali from the 10 – 12 May 2017';

            $messageText_2 = 'Kindly log-in to your group account and review invitees & their status.';

            $messageText_3 = 'Status Explained<br>
            •   Not registered – The invitee has not registered <br>
            •   Registered / Pending Confirmation – The invitee has registered and the registration is being processed <br>
            •   Confirmed – The invitees registration has been approved to attend the summit <br>
            •   Not approved – The invitees registration has not been approved to attend the summit 
            ';

            $messageText_4 = 'If all your invitees have completed registration and are confirmed, 
            kindly proceed to close the account by clicking on ‘close and process invoice’ 
            below the registration table.';

            $messageText_5 = 'An invoice will be sent to you shortly for bank transfer or direct deposit payments.';

            $messageText_6 = 'You can also pay by Visa or Mastercard online. <br><br>
            <b>Deadline for registration: 25th April 2017</b>';

            $message_body = '
                <body>
                    <div style="padding: 10px; margin-left: 10px; margin-right: 10px">

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
                                <b>Accommodation:</b><br>
                                <a href="' . DN . '/accomodation">Click here to submit your group accommodation requirements.</a> <br><br>
                                
                                Use promotional code<b>TAS2017</b> to receive discounted conference rates up till 10 April 2017.

                            </p>
                            <p style="font-size: 13px;">
                                <b>Plan your trip:</b><br>
                                <a href="' . DN . '/plan">Click here for travel information including visas requirements.</a>
                            </p>
                            <p style="font-size: 13px;">
                                <b>Dedicated Bus Network:</b><br>
                                To ease your travel around Kigali, you will receive an email at a later date with details on 
                                the dedicated Transform Africa Summit bus network.  You will be able to purchase pre-paid 
                                travel cards giving you access to the entire Transform Africa Summit bus network during 
                                your stay in Kigali.
                            </p>
                            <p style="font-size: 13px;">
                                <b>Car hire:</b><br>
                                Should you wish to hire a car during your stay here? Please email 
                                transport@smartafrica.org
                            </p>
                            
                            <p style="font-size: 13px;">
                                <b>Stay connected</b> <br>
                                <b>Twitter / Facebook:</b> TASummit <br>
                                <b>Connect with our official tag:</b> #TAS2017<br>
                                <b>Youtube:</b> TransformAfricaSummit<br><br>
                                If you have received this email in error, please forward to it enquiries@smartafrica.org. 

                            </p>
                            <br>
                        </section>
                        <div style="font-size: 13px; padding: 0px; position: relative">
                            <div style="text-align: left; border-top: 1px solid #ddd; padding: 10px 5px">
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
            $contactDetails['to_email'] = $email;

            $contactDetails['attach'] = false;

            $email_status = Functions::smartMailer($contactDetails, $subject, $message_body, $message_alt);
        }
    }

    public static function setHost($host_ID) {
        $subscriberTable = new \Subscriber();
        global $session_subscriber_ID;
        echo $session_subscriber_ID;
        $subscriberTable->update(array('registration_ID' => $host_ID), $session_subscriber_ID);
    }

    public static function updatePassword($user_ID) {
        $diagnoArray[0] = 'NO_ERRORS';
        $errors_str = '';
        $validate = new \Validate();
        $prfx = 'user-';
        foreach ($_POST as $index => $val) {
            $ar = explode($prfx, $index);
            if (count($ar)) {
                $_SIGNUP[end($ar)] = $val;
            }
        }

        global $session_subscriber_data;

        $validation = $validate->check($_SIGNUP, array(
            'password' => array(
                'name' => 'Password',
                'strong_password' => true,
                'min' => 6,
                'required' => true
            ),
            'repassword' => array(
                'required' => true,
                'name' => 'Confirm Password',
                'matches' => 'password',
            )
        ));

        $current_salt = $session_subscriber_data->salt;
        $current_passwordText = Input::get($prfx . 'current_password', 'post');
        $current_password = Hash::make($current_passwordText, $current_salt);

        if ($current_password != $session_subscriber_data->password) {
            $diagnoArray[0] == 'ERRORS_FOUND';
            $errors_str = "Current password is incorect<br>";
        }

        if ($validation->passed()) {
            $subscriberTable = new \Subscriber();

            $str = new \Str();

            $_SIGNUP = (object) $_SIGNUP;

            $seconds = \Config::get('time/seconds');

            $salt = Hash::salt(32);
            $passwordText = Input::get($prfx . 'password', 'post');
            $password = Hash::make($passwordText, $salt);

            if ($diagnoArray[0] == 'NO_ERRORS') {
                try {
                    $subscriberTable->update(array(
                        'password' => $password,
                        'salt' => $salt
                            ), $session_subscriber_data->ID);
                } catch (Exeption $e) {
                    $diagnoArray[0] = "ERRORS_FOUND";
                    $diagnoArray[] = $e->getMessage();
                }

                Session::put("success", "Password updated successfully.");

                $subject = "Password Account";

                $messageText_0 = 'Dear <b>' . $session_subscriber_data->firstname . '</b>,';

                $messageText_1 = 'Your password was successfully updated ';

                $messageText_2 = ' ';

                $message_body = '
                    <body>
                        <div style="padding: 10px; margin-left: 10px; margin-right: 10px">

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
                                    <b>Stay connected</b> <br>
                                    <b>Twitter / Facebook:</b> TASummit <br>
                                    <b>Connect with our official tag:</b> #TAS2017<br>
                                    <b>Youtube:</b> TransformAfricaSummit<br><br>
                                    If you have received this email in error, please forward to it enquiries@smartafrica.org. 

                                </p>
                                <br>
                            </section>
                            <div style="font-size: 13px; padding: 0px; position: relative">
                                <div style="text-align: left; border-top: 1px solid #ddd; padding: 10px 5px">
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

                $contactDetails['from_email'] = 'noreply@smartafrica.org';
                $contactDetails['from_names'] = 'Smart Africa Team';
                $contactDetails['to_email'] = $user_data->email;

                $contactDetails['attach'] = false;

                $email_status = Functions::smartMailer($contactDetails, $subject, $message_body, $message_alt);
            } else {
                $diagnoArray[0] = 'ERRORS_FOUND';
                $error_msg = ul_array($validation->errors());
            }
        } else {
            $diagnoArray[0] = 'ERRORS_FOUND';
        }
        if ($diagnoArray[0] == 'ERRORS_FOUND') {
            return (object) [
                        'ERRORS' => true,
                        'ERRORS_STRING' => $errors_str,
                        'ERRORS_SCRIPT' => $validate->getErrorLocation()
            ];
        } else {
            return (object) [
                        'ERRORS' => false,
                        'SUCCESS' => true,
                        'ERRORS_STRING' => $errors_str,
                        'ERRORS_SCRIPT' => $validate->errors()
            ];
        }
    }

    public static function requestPasswordReset($subscriber_ID) {

        $diagnoArray[0] = 'NO_ERRORS';
        $errors_str = '';

        $validate = new \Validate();
        $prfx = 'recover-';
        foreach ($_POST as $index => $val) {
            $ar = explode($prfx, $index);
            if (count($ar)) {
                $_SIGNUP[end($ar)] = $val;
            }
        }

        $subscriberTable = new \Subscriber();

        $str = new \Str();

        $seconds = \Config::get('time/seconds');

        global $subscriber_data;

        $salt = Hash::salt(32);
        $generated_string = Functions::generateStrongPassword(32, false, 'ud');

        $secret_key = $subscriber_data->password;
        $recovery_string = strtoupper(hash_hmac('SHA256', $generated_string, pack('H*', $secret_key)));

        if ($diagnoArray[0] == 'NO_ERRORS') {
            try {
                $subscriberTable->update(array(
                    'recovery_string' => $recovery_string
                        ), $subscriber_ID);
            } catch (Exeption $e) {
                $diagnoArray[0] = "ERRORS_FOUND";
                $diagnoArray[] = $e->getMessage();
            }

            $subject = "Click here to reset your password";

            $link = DN . "/login/resetpassword/{$subscriber_ID}/{$generated_string}";

            $messageText_0 = 'Dear <b>' . $subscriber_data->firstname . '</b>,';

            $messageText_1 = 'Click on this link to reset your password <a href="' . $link . '">[ Click here to passsword reset ]</a>';

            $message_body = '
                <body>
                    <div style="padding: 10px; margin-left: 10px; margin-right: 10px">

                        <section>
                            <p style="margin-bottom: 25px; font-size: 13px;">
                                ' . $messageText_0 . '
                            </p>
                            <p style="font-size: 13px;">
                                ' . $messageText_1 . '
                            </p>
                            <p style="font-size: 13px;">
                                <b>Stay connected</b> <br>
                                <b>Twitter / Facebook:</b> TASummit <br>
                                <b>Connect with our official tag:</b> #TAS2017<br>
                                <b>Youtube:</b> TransformAfricaSummit<br><br>
                                If you have received this email in error, please forward to it enquiries@smartafrica.org. 

                            </p>
                            <br>
                        </section>
                        <div style="font-size: 13px; padding: 0px; position: relative">
                            <div style="text-align: left; border-top: 1px solid #ddd; padding: 10px 5px">
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

            $message_alt = $messageText_0 . ' ' . $messageText_1;

            $contactDetails['from_email'] = 'noreply@smartafrica.org';
            $contactDetails['from_names'] = 'Smart Africa Team';
            $contactDetails['to_email'] = $subscriber_data->email;

            $contactDetails['attach'] = false;

            $email_status = Functions::smartMailer($contactDetails, $subject, $message_body, $message_alt);
        }

        if ($diagnoArray[0] == 'ERRORS_FOUND') {
            return (object) [
                        'ERRORS' => true,
                        'ERRORS_STRING' => $errors_str,
            ];
        } else {
            return (object) [
                        'ERRORS' => false,
                        'SUCCESS' => true,
                        'ERRORS_STRING' => $errors_str,
                        'ERRORS_SCRIPT' => ''
            ];
        }
    }

    public static function resetPassword($subscriber_ID) {

        $diagnoArray[0] = 'NO_ERRORS';
        $errors_str = '';

        $validate = new \Validate();
        $prfx = 'reset-';
        foreach ($_POST as $index => $val) {
            $ar = explode($prfx, $index);
            if (count($ar)) {
                $_SIGNUP[end($ar)] = $val;
            }
        }

        $validation = $validate->check($_SIGNUP, array(
            'password' => array(
                'name' => 'Password',
                'strong_password' => true,
                'min' => 6,
                'required' => true
            )
        ));

        if ($validation->passed()) {
            $subscriberTable = new \Subscriber();

            $str = new \Str();

            $seconds = \Config::get('time/seconds');

            global $subscriber_data;

            $salt = Hash::salt(32);
            $generate_password = $_SIGNUP['password'];
            $password = Hash::make($generate_password, $salt);

            if ($diagnoArray[0] == 'NO_ERRORS') {
                try {
                    $subscriberTable->update(array(
                        'password' => $password,
                        'salt' => $salt,
                        'recovery_string' => ''
                            ), $subscriber_ID);
                } catch (Exeption $e) {
                    $diagnoArray[0] = "ERRORS_FOUND";
                    $diagnoArray[] = $e->getMessage();
                }

                Session::put("success", "Password updated successfully.");

                $subject = "Your password has changed successfully";

                $messageText_0 = 'Dear <b>' . $subscriber_data->firstname . '</b>,';

                $messageText_1 = 'Your password has changed successfully';

                $messageText_2 = ' ';

                $message_body = '
                    <body>
                        <div style="padding: 10px; margin-left: 10px; margin-right: 10px">

                            <section>
                                <p style="margin-bottom: 25px; font-size: 13px;">
                                    ' . $messageText_0 . '
                                </p>
                                <p style="font-size: 13px;">
                                    ' . $messageText_1 . '
                                </p>
                                <p style="font-size: 13px;">
                                    <b>Stay connected</b> <br>
                                    <b>Twitter / Facebook:</b> TASummit <br>
                                    <b>Connect with our official tag:</b> #TAS2017<br>
                                    <b>Youtube:</b> TransformAfricaSummit<br><br>
                                    If you have received this email in error, please forward to it enquiries@smartafrica.org. 

                                </p>
                                <br>
                            </section>
                            <div style="font-size: 13px; padding: 0px; position: relative">
                                <div style="text-align: left; border-top: 1px solid #ddd; padding: 10px 5px">
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

                $contactDetails['from_email'] = 'noreply@smartafrica.org';
                $contactDetails['from_names'] = 'Smart Africa Team';
                $contactDetails['to_email'] = $subscriber_data->email;

                $contactDetails['attach'] = false;

                $email_status = Functions::smartMailer($contactDetails, $subject, $message_body, $message_alt);
            }
        } else {
            $diagnoArray[0] = 'ERRORS_FOUND';
            $errors_str = ul_array($validation->errors());
        }
        if ($diagnoArray[0] == 'ERRORS_FOUND') {
            return (object) [
                        'ERRORS' => true,
                        'ERRORS_STRING' => $errors_str,
            ];
        } else {
            return (object) [
                        'ERRORS' => false,
                        'SUCCESS' => true,
                        'ERRORS_STRING' => $errors_str,
                        'ERRORS_SCRIPT' => ''
            ];
        }
    }

    public static function update($user_ID) {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();
        $prfx = 'user-';
        foreach ($_POST as $index => $val) {
            $ar = explode($prfx, $index);
            if (count($ar)) {
                $_SIGNUP[end($ar)] = $val;
            }
        }

        global $session_subscriber_data;

        $validation = $validate->check($_SIGNUP, array(
            'firstname' => array(
                'name' => 'First Name',
                'required' => true
            ),
            'lastname' => array(
                'name' => 'Last Names',
                'string' => true
            ),
            'telephone' => array(
                'name' => 'Telephone',
                'required' => true
            )
        ));

        if ($validation->passed()) {
            $subscriberTable = new \Subscriber();

            $str = new \Str();

            $_SIGNUP = (object) $_SIGNUP;

            $firstname = $str->sanAsName($_SIGNUP->firstname);

            $lastname = $str->sanAsName($_SIGNUP->lastname);

            $telephone = $str->sanAsName($_SIGNUP->telephone);

            $seconds = \Config::get('time/seconds');

            if ($diagnoArray[0] == 'NO_ERRORS') {
                try {
                    $subscriberTable->update(array(
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'phone' => $telephone
                            ), $user_ID);
                } catch (Exeption $e) {
                    $diagnoArray[0] = "ERRORS_FOUND";
                    $diagnoArray[] = $e->getMessage();
                }
            }
        } else {
            $diagnoArray[0] = 'ERRORS_FOUND';
            $error_msg = ul_array($validation->errors());
        }
        if ($diagnoArray[0] == 'ERRORS_FOUND') {
            return (object) [
                        'ERRORS' => true,
                        'ERRORS_SCRIPT' => $validate->getErrorLocation()
            ];
        } else {
            return (object) [
                        'ERRORS' => false,
                        'SUCCESS' => true,
                        'ERRORS_SCRIPT' => $validate->errors()
            ];
        }
    }

    public static function groupAdminLog($user_ID) {
        $subscriberTable = new \Subscriber();
        try {
            $subscriberTable->update(array(
                'type' => 'Group'
                    ), $user_ID);
        } catch (Exeption $e) {
            $diagnoArray[0] = "ERRORS_FOUND";
            $diagnoArray[] = $e->getMessage();
        }
    }

    public static function login($origin = null) {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();
        $prfx = 'login_';
        foreach ($_POST as $index => $val) {
            $ar = explode($prfx, $index);
            if (count($ar)) {
                $_LOGIN[end($ar)] = $val;
            }
        }
        $validation = $validate->check($_LOGIN, array(
            'username' => array(
                'name' => 'Username',
                'required' => true
            ),
            'password' => array(
                'name' => 'Password',
                'required' => true
            )
        ));

        if ($validation->passed()) {
            $subscriberTable = new \Subscriber();

            $str = new \Str();
            $_LOGIN = (object) $_LOGIN;
            $username = $str->data_in($_LOGIN->username);
            $password_txt = $str->data_in($_LOGIN->password);
            $remember = false;
            if (Input::checkInput($prfx . 'remember', 'post', 1)) {
                $remember = (Input::get($prfx . 'remember', 'post') == 'on') ? true : false;
            }
            $login = $subscriberTable->login($username, $password_txt, $remember);
            if ($login !== true) {
                $diagnoArray[0] = 'ERRORS_FOUND';
            }
            if (count($subscriberTable->errors())) {
                if ($login == 'password') {
                    $form_error = true;
                    $diagnoArray[0] = "ERRORS_FOUND";
                    Session::put('loginerror', 'Password');
                } else if ($login == 'username') {
                    $form_error = true;
                    $diagnoArray[0] = "ERRORS_FOUND";
                    Session::put('loginerror', 'Username');
                }
            }

            $seconds = \Config::get('time/seconds');
            if ($diagnoArray[0] == 'NO_ERRORS') {
                
            }
        } else {
            $diagnoArray[0] = 'ERRORS_FOUND';
            $error_msg = ul_array($validation->errors());
        }
        if ($diagnoArray[0] == 'ERRORS_FOUND') {
            return (object) [
                        'ERRORS' => true,
                        'SUCCESS' => false,
                        'ERRORS_SCRIPT' => $validate->getErrorLocation()
            ];
        } else {
            return (object) [
                        'ERRORS' => false,
                        'SUCCESS' => true,
                        'ERRORS_SCRIPT' => ""
            ];
        }
    }

    public static function changeState($state, $user_ID) {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();

        $ID = $user_ID;

        $seconds = \Config::get('time/seconds');

        $subscriberTable = new Subscriber();
        global $session_subscriber_data;

        try {
            switch ($state) {
                case 'Activate';
                    $subscriberTable->update(array(
                        'state' => 'Activated'
                            ), $ID);
                    break;
                case 'Block';
                    $subscriberTable->update(array(
                        'state' => 'Blocked'
                            ), $ID);
                    break;
            }
        } catch (Exeption $e) {
            $diagnoArray[0] = "ERRORS_FOUND";
            $diagnoArray[] = $e->getMessage();
        }
        if ($diagnoArray[0] == 'ERRORS_FOUND') {
            return (object) [
                        'ERRORS' => true,
                        'ERRORS_SCRIPT' => $diagnoArray
            ];
        } else {
            return (object) [
                        'ERRORS' => false,
                        'SUCCESS' => true,
                        'ERRORS_SCRIPT' => ""
            ];
        }
    }

}
