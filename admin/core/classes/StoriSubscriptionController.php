<?php

class StoriSubscriptionController {

    public static function setActivation($ID, $result) {

        $storiSubscriptionTable = new StoriSubscription();

        $transaction_status = 'APPROVED';

        $date_activation = date('d-m-Y');
        $date_expiration = date('d-m-Y', strtotime('+1 month', strtotime($date_activation)));

        $activation_status = "ACTIVATED";

        $storiSubscriptionTable->update(array(
            'transaction_status' => $transaction_status,
            'activation_status' => $activation_status,
            'date_activation' => $date_activation,
            'transaction_response' => $result,
            'date_expiration' => $date_expiration
                ), $ID);
    }

    public static function setFailed($ID, $result) {

        $storiSubscriptionTable = new StoriSubscription();

        $transaction_status = 'DECLINED';

        $storiSubscriptionTable->update(array(
            'transaction_status' => $transaction_status,
            'activation_status' => 'FAILED',
            'transaction_response' => $result
                ), $ID);
    }

    public static function setPending($ID, $result) {

        $storiSubscriptionTable = new StoriSubscription();

        $transaction_status = 'DECLINED';

        $storiSubscriptionTable->update(array(
            'transaction_response' => $result
                ), $ID);
    }

}
