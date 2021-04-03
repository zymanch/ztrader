<?php
namespace  backend\components;

use Psr\Log\LoggerInterface;

/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 22.02.14
 * Time: 12:06
 */
class ConsoleLogger implements LoggerInterface {


    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     */
    public function log($level, $message, array $context = array()){
        switch ($level){

            case \Psr\Log\LogLevel::ERROR:
                $this->error($message, $context);
                break;
            case \Psr\Log\LogLevel::ALERT:
                $this->alert($message, $context);
                break;
            case \Psr\Log\LogLevel::CRITICAL:
                $this->critical($message, $context);
                break;
            case \Psr\Log\LogLevel::EMERGENCY:
                $this->emergency($message, $context);
                break;

            case \Psr\Log\LogLevel::DEBUG:
                $this->debug($message, $context);
                break;

            case \Psr\Log\LogLevel::INFO:
                $this->info($message, $context);
                break;
            case \Psr\Log\LogLevel::NOTICE:
                $this->notice($message, $context);
                break;


            case \Psr\Log\LogLevel::WARNING:
                $this->warning($message, $context);
                break;

        }
    }

    public function emergency($message, array $context = array()) {
        $this->error($message, $context);
    }

    public function alert($message, array $context = array()) {
        $this->error($message, $context);
    }

    public function critical($message, array $context = array()) {
        $this->error($message, $context);
    }

    public function info($message, array $context = array()) {
        print $message."\n";
        $this->_writeContext($context);
    }

    public function error($message, array $context = array()) {
        print "Error: ".$message."\n";
        $this->_writeContext($context);
    }

    public function warning($message, array $context = array()) {
        print "Warning: ".$message."\n";
        $this->_writeContext($context);
    }

    public function notice($message, array $context = array()) {
        print "Notice: ".$message."\n";
        $this->_writeContext($context);
    }

    public function debug($message, array $context = array()) {
        print "Debug: ".$message."\n";
        $this->_writeContext($context);
    }

    private function _writeContext($context) {
        foreach ($context as $key => $value) {
            print sprintf("  %s: %s\n", $key, $value);
        }
    }
}