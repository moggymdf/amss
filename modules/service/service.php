<?php
class amss {
    function getLogin($username,$pw) {
        $connect = $this->connect();
        $sql = "select person_id,username,userpass from system_user where (username=?) and (userpass=md5(?))";
        $query = $connect->prepare($sql);
        $query->bind_param("ss",$username,$pw);
        $query->execute();
        $results = $query->get_result();
        $arr = array();
        while($result = $results->fetch_array())
             {
            $arr['id']=$result['person_id'];
            $arr['user']=$result['username'];
            $arr['result']="OK";
        }
        return json_encode($arr);
    }

    function connect(){
        include('../../database_connect.php');
        return $connect;
    }
}
?>
