<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MPaymentIdent extends ModelEx {
        protected $table      = 'm_payment_idents';
        protected $primaryKey = 'payment_ident_id';
    }
}