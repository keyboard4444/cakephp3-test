<?php
namespace App\Controller;

use Cake\Log\Log;

class StudylogsController extends AppController
{
    //Purpose is to study cakephp logs https://book.cakephp.org/3.0/en/core-libraries/logging.html
    
    public function index(){
        
        //since error.log and hellodb handle alert error, this will write into error.log and hellodb (database table log_entry)
        $this->log("This is a JOJO 55", 'alert');
        Log::alert('This is a JOJO 66');
        
        //since helloworld.log handle notice error, this will write into helloworld
        $this->log("This is a JOJO 22", 'notice');
        Log::notice('This is a JOJO 11');
        
        //however, below here 'terminator' is scoped under 'gettodachoppa' logging, so it goes to gettodachoppa + helloworld (since its still a notice error)
        Log::notice('This is a JOJO 33', ['scope' => ['terminator']]);
        $this->log("This is a JOJO 44", 'notice', ['scope' => ['terminator']]);
        
        pr("HELLO");
        $this->autoRender = false;
    }
}