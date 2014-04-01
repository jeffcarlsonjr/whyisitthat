<?php


class usersClass {
    
    protected $crud;
    
    public function __construct() {
        $this->crud = new CRUD();
    }
    
    public function displayUsers() {
        $this->crud->multiSelectNoWhere('wiit-user');
    }
    
    public function createUsers($data, $table) {
        $this->crud->insert($data, $table);
    }
    
    public function displayUsersName($id)
    {
        $row = $this->crud->select('wiit_user', 'id='.$id);
        
        return $row['username'];
    }
    
    public function checkUsers($data, $table)
    {
        $email = $data['email'];
        $query = "SELECT * FROM wiit_user WHERE email = $email ";
       
        $result = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_assoc($result);
        if(!empty($row['id']))
        {
            session_start();
            $_SESSION['user_id'] = $row['id'];
            
            
            return $_SESSION['user_id'];
        }
        elseif(empty($row['id']))
        {
            
            $this->createUsers($data, $table);
        }
   
    }
}
