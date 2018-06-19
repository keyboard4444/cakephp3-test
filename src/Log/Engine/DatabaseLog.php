<?php

namespace App\Log\Engine;
use Cake\Log\Engine\BaseLog;
use Cake\ORM\TableRegistry;

class DatabaseLog extends BaseLog
{
    public function __construct($options = [])
    {
        parent::__construct($options);
        // ...
    }

    public function log($level, $message, array $context = [])
    {
        $logTableName = $this->getConfig('model'); //get the 'model' name from the config that we declare at app.php
        $logTableObject = TableRegistry::getTableLocator()->get($logTableName); //initialize the model
        
        //save the data
        /*
        CREATE TABLE `log_entry` (
            `id` int(10) UNSIGNED NOT NULL,
            `level` varchar(100) DEFAULT NULL,
            `message` text,
            `context` text,
            `created` datetime DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
         */
        $logEntry = $logTableObject->newEntity();
        $logEntry->level = $level;
        $logEntry->message = $message;
        $logEntry->context = implode(", ", collection($context)->unfold()->toList());
        $logEntry->created = date("Y-m-d H:i:s");
        $logTableObject->save($logEntry);
    }
}
