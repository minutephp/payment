<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MPayment extends ModelEx {
        protected $table      = 'm_payments';
        protected $primaryKey = 'payment_id';
    }
}