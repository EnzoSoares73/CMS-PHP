<?php
    
    class Connect{
        
        private $host;
        private $dbname;
        private $username;
        private $password;
        
        function __construct() {//constructor
            $array = parse_ini_file("dbconfig.ini");//get database variables from dbconfig.ini
            
            $this->host = $array['host'];
            $this->dbname = $array['dbname'];
            $this->username = $array['username'];
            $this->password = $array['password'];
            
        }
        
        function connection() { //connect to database
            if (!$myConnection= mysqli_connect("$this->host","$this->username","$this->password")) {
                trigger_error("ERROR: Could not connect to mysql");
            }
            if (!mysqli_select_db($myConnection, $this->dbname)) {
                trigger_error("ERROR: No database");
            }
            return $myConnection;
        }
        
        function query($myConnection, $sql) { //executes query
            if(!$result = mysqli_query($myConnection, $sql)){
                trigger_error("ERROR: Could not execute $sql. " . mysqli_error($myConnection));
            }
            return $result;
            
        }
        
        function queryToArray2D($query) {//transforms a query result in to a 2d array
            $array = [];
            while ($row = $query->fetch_assoc()) {
                $array[] = $row;
            }
            return $array;
        }
        
        function queryToArray($query) {//transforms a query result in to an array
            $array = [];
            while ($row = $query->fetch_row()) {
                $array[] = $row[0];
            }
            return $array;
        }
        
        function print_rImproved($array) {//print_r as it should be
            echo '<pre>'; print_r($array); echo '</pre>';
        }
        /**
         * @return mixed
         */
        public function getHost()
        {
            return $this->host;
        }
    
        /**
         * @param mixed $host
         */
        public function setHost($host)
        {
            $this->host = $host;
        }
    
        /**
         * @return mixed
         */
        public function getDbname()
        {
            return $this->dbname;
        }
    
        /**
         * @param mixed $dbname
         */
        public function setDbname($dbname)
        {
            $this->dbname = $dbname;
        }
    
        /**
         * @return mixed
         */
        public function getUsername()
        {
            return $this->username;
        }
    
        /**
         * @param mixed $username
         */
        public function setUsername($username)
        {
            $this->username = $username;
        }
    
        /**
         * @return mixed
         */
        public function getPassword()
        {
            return $this->password;
        }
    
        /**
         * @param mixed $password
         */
        public function setPassword($password)
        {
            $this->password = $password;
        }
    
        
        
        
    }