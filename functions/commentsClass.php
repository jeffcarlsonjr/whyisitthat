<?php


class commentsClass {
    
    protected $crud;
    protected $user;
    
    public function __construct() {
        $this->crud = new CRUD();
        $this->user = new usersClass();
    }
    
    public function displayComments(){
        
        $query = "select * from wiit_comments ORDER BY dateCreated DESC";
        $result = mysql_query($query);
        while($row = mysql_fetch_assoc($result))
        {   
            $comments = stripslashes($row['comment']);
            
            echo "<div class='commentsRow'>";
            echo "<div class='col-lg-10 col-md-10 col-sm-10 commentbox'>";
            echo "<div class='userName'>".$this->user->displayUsersName($row['user_id'])." had to say:</div>";
            echo "<div class='comment'>".$comments."</div>";
            echo "<div id='likeBox' class='likeBox' data-like-id='".$row['id']."'></div>";
            echo "<div class='likeCount' id='likeCount' data-like-count='".$row['id']."'>".$this->commmentCount($row['id'])."</div>" ;
            echo "<script>likes(".$row['id'].")</script>";
            echo "</div>";
            
            echo "</div>";
        }
    }
    
    public function createComment($data,$table){
        $this->crud->insert($data, $table);
    }
    
    public function deleteComment($table, $where){
        $this->crud->delete($table, $where);
    }
    
    public function commmentCount($id){
        $i = 0;
        $query = mysql_query('SELECT * FROM wiit_likes WHERE comment_id = "'.$id.'" AND active = "yes" ');
        
        while($row = mysql_fetch_assoc($query)){$i++;
        if(!empty($row['like_id'])){
            
            $result = $i;
            $html =  "(".$result.")";
            }
        }
       
        return $html;
        
    }
    

}


