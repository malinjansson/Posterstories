<?php
    class Logger {
        private static $instance;
        protected function __construct(){
        }

        public static function GetInstance() {
            if(Logger::$instance == null){
                Logger::$instance = require_once "Utils/logging.php";
            }
            return Logger::$instance;
        }
    }
?>