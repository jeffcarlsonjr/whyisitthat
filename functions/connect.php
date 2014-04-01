<?php

class connect {
    private $host, $username, $password, $database;
	
	public function __construct($host,$usename,$password,$database)
	{
            $this->host = $host;
            $this->username = $usename;
            $this->password = $password;
            $this->database = $database;
	}
	
	public function myconnect()
	{
            $myconnect = mysql_connect($this->host,$this->username,$this->password);
            if(!$myconnect)
                {
                echo mysql_error();

                }
              
                $dbconnect = mysql_select_db($this->database, $myconnect);
                    if(!$dbconnect)
                    {
                    echo mysql_error();

                    }
                
        }
        

}


function cleanInput($input)
        {
            $text = stripslashes($input);
            $text = mysql_real_escape_string($text);
            
            return $text;
        }