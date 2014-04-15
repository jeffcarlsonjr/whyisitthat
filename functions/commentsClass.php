<?php


class commentsClass {
    
    protected $crud;
    protected $user;
    
    public function __construct() {
        $this->crud = new CRUD();
        $this->user = new usersClass();
    }
    
    public function commentBox(){
        
        $query = "select * from wiit_comments ORDER BY dateCreated DESC";
        $result = mysql_query($query);
        while($row = mysql_fetch_assoc($result))
        {   
            $comments = stripslashes($row['comment']);
            
            echo "<div class='commentsRow'>";
            echo "<div class='col-lg-12 col-md-12 col-sm-12'> ";
            echo "<div class='col-lg-2 col-md-2 col-sm-2' logo>";
            echo "<img src='./images/smWiitLogo.png'/>";
            echo "</div>";
            $this->displayComment($row['user_id'],$comments);
            echo "<div id='likeBox' class='likeBox' data-like-id='".$row['id']."'>Kudos</div>";
            echo "<div class='likeCount' id='likeCount' data-like-count='".$row['id']."'>".$this->commmentCount($row['id'])."</div>" ;
            echo "<script>likes(".$row['id'].")</script>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            
        }
    }
    
    public function displayComment($userId,$comments){
            echo "<div class='col-lg-10 col-md-10 col-sm-10 commentbox'>";
            echo "<div class='userName'>".$this->user->displayUsersName($userId)." had to say:</div>";
            echo "<div class='comment'>".$comments."</div>";
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
    
    public function cleanText($text)
    {
        $badWords = array(
            'ass' => 'a!@',
            'fuck' => 'f&#k',
            'shit' => 's@%t',
            'pussy' => 'p#%!y',
            'cunt' => 'c#$t',
            'cock' => 'c#@k',
            'dick' => 'd!@k',
            'twat' => 't$#t'
            );

    $text = str_replace(array_keys($badWords), array_values($badWords), $text);
    return $text;
    }
    
    public function fullCommentCount() {
        $i = 0;
        $query = mysql_query("SELECT * FROM wiit_comments");
        
        while($row = mysql_fetch_assoc($query)){
            $i++;
        }
        
        echo "<div class='commentCount'>We currently have " .$i. " comments. </div>";
        
            
    }
    
    public function mostLikes(){
        $query = mysql_query("SELECT * FROM wiit_like_count");
        $data = array();
        $idDate = array();
        while($row = mysql_fetch_assoc($query)){
            $data[] = $row['like_count'];
            $idDate[] = $row['comment_id'];
        }
        // Grabbing an array here and using max() in order to find the most likes
        // From there I take the position of array with the array_search using the max()
        // and then use that position value to get the ID of the comment

        $array = $data;
        $maxValue = max($array);
        $maxIndex = array_search(max($array), $array);
        
        $idIndex = $idDate[$maxIndex];
        

        $query1 = mysql_query("SELECT comment, user_id FROM wiit_comments WHERE id = '$idIndex' ");
        
        $row1 = mysql_fetch_assoc($query1); 
        echo "<div class='miniName'>".$this->user->displayUsersName($row1['user_id'])." had to say</div>";
        echo "<div class='miniComment'>".$row1['comment']."</div>";
    }
    
        
}


