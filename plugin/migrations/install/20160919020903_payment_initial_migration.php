<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class PaymentInitialMigration extends AbstractMigration
{
    public function change()
    {
        // Automatically created phinx migration commands for tables from database minute

        // Migration for table m_payment_idents
        $table = $this->table('m_payment_idents', array('id' => 'payment_ident_id'));
        $table
            ->addColumn('user_id', 'integer', array('null' => true, 'limit' => 11))
            ->addColumn('ident', 'string', array('null' => true, 'limit' => 255))
            ->addIndex(array('ident'), array('unique' => true))
            ->create();


        // Migration for table m_payment_logs
        $table = $this->table('m_payment_logs', array('id' => 'payment_log_id'));
        $table
            ->addColumn('user_id', 'integer', array('limit' => 11))
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('subscription_id', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('transaction_id', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('payment_event', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('data_json', 'text', array('null' => true, 'limit' => MysqlAdapter::TEXT_LONG))
            ->addColumn('status', 'string', array('null' => true, 'limit' => 255))
            ->create();


        // Migration for table m_payments
        $table = $this->table('m_payments', array('id' => 'payment_id'));
        $table
            ->addColumn('payment_log_id', 'integer', array('null' => true, 'limit' => 11))
            ->addColumn('user_id', 'integer', array('limit' => 11))
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('amount', 'integer', array('limit' => 11))
            ->addColumn('payment_for', 'string', array('limit' => 255))
            ->addIndex(array('user_id'), array())
            ->create();


    }
}
