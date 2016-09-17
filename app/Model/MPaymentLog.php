<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MPaymentLog extends ModelEx {
        protected $table      = 'm_payment_logs';
        protected $primaryKey = 'payment_log_id';
    }
}