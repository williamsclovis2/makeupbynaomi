<?php

class CustomerController {

    public static function requestPasswordReset($customer_ID) {

        $diagnoArray[0] = 'NO_ERRORS';
        $errors_str = '';

        $customerTable = new \Customer();

        $seconds = \Config::get('time/seconds');

        global $customer_data;

        $salt = Hash::salt(32);
        $generated_string = Functions::generateStrongPassword(5, false, 'ud');

        $secret_key = $customer_data->password;
        $recovery_string = strtoupper(hash_hmac('SHA256', $generated_string, pack('H*', $secret_key)));

        if ($diagnoArray[0] == 'NO_ERRORS') {
            try {
                $customerTable->update(array(
                    'recovery_string' => $recovery_string
                        ), $customer_ID);
            } catch (Exeption $e) {
                $diagnoArray[0] = "ERRORS_FOUND";
                $diagnoArray[] = $e->getMessage();
            }

            $subject = "Reset password";

            $messageText_0 = 'Dear user';

            $messageText_1 = 'Use the code ' . $generated_string . ' to reset your password';

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
                            <br>
                        </section>
                    </div>
                </body>
            ';

            $message_alt = $messageText_0 . ' ' . $messageText_1;

            $contactDetails['from_email'] = 'support@storiafrica.com';
            $contactDetails['from_names'] = 'Stori Africa Support';
            $contactDetails['to_email'] = $customer_data->email;

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

    public static function passwordResetCodeValidation($code, $recovery_string) {

        $diagnoArray[0] = 'NO_ERRORS';
        $errors_str = '';

        $customerTable = new \Customer();

        global $customer_data;

        $secret_key = $customer_data->password;
        $recovery_string_new = strtoupper(hash_hmac('SHA256', $code, pack('H*', $secret_key)));

        if ($recovery_string_new != $recovery_string) {
            return false;
        }
        return true;
    }

    public static function resetPassword($customer_ID) {

        $diagnoArray[0] = 'NO_ERRORS';
        $errors_str = '';

        $customerTable = new \Customer();

        global $customer_data;

        $salt = Hash::salt(32);
        $generate_password = $_POST['password'];
        $password = Hash::make($generate_password, $salt);

        if ($diagnoArray[0] == 'NO_ERRORS') {
            try {
                $customerTable->update(array(
                    'password' => $password,
                    'salt' => $salt,
                    'recovery_string' => ''
                        ), $customer_ID);
            } catch (Exeption $e) {
                $diagnoArray[0] = "ERRORS_FOUND";
                $diagnoArray[] = $e->getMessage();
            }

            $subject = "Reset password successful";

            $messageText_0 = 'Dear user';

            $messageText_1 = 'Your password has been changed successfully';

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
							<br>
						</section>
					</div>
				</body>
			';

            $message_alt = $messageText_0 . ' ' . $messageText_1;

            $contactDetails['from_email'] = 'support@storiafrica.com';
            $contactDetails['from_names'] = 'Stori Africa Support';
            $contactDetails['to_email'] = $customer_data->email;

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

}
