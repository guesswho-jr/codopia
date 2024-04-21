<?php

// declare(strict_types=1);
session_start();
require_once "../../admin/scripts/classes.php";
// use $_SERVER["REQUEST_METHOD"] DELETE OR PUT
$dataBase = new DataBase();

function add(int $id){
    global $dataBase;
    $old = $dataBase->executeSql("select liked_by from projects where id=? limit 1", [$id], TRUE);
    $old = (array)json_decode($old[0]["liked_by"]);
    if (in_array((int)$_SESSION["userid"], $old["likedBy"])){
        die(json_encode(["error"=>2]));
    }
    array_push($old["likedBy"],(int)$_SESSION["userid"]);
    $dataBase->executeSql("update projects set liked_by=? where id=?", [json_encode($old), $id]);

}
function search(array $arr, int $val){
    for ($i=0; $i < count($arr); $i++) { 
        
        if ($val == (int)$arr[$i]){
            return $i;
        }
    }
    return -1;
}
function exists(int $id, int $projectId) {
    global $dataBase;
    $old = $dataBase->executeSql("select liked_by from projects where id=? limit 1", [$projectId], TRUE);
    $old = (array)json_decode($old[0]["liked_by"]);
    if (search($old["likedBy"], $id) !== -1){
        //echo print_r($old["likedBy"]) . ' ' . (int)$_SESSION["userid"];
        return 1;
    }
    return -1;
    //return in_array((int)$_SESSION["userid"],$old["likedBy"]); // If this won't work use the array_search
}


function remove(int $id, int $projectId){
    global $dataBase;
    $old = $dataBase->executeSql("select liked_by from projects where id=? limit 1", [$projectId], TRUE);
    $old = (array)json_decode($old[0]["liked_by"]);
    // $key = array_search((int)$_SESSION["userid"], $old["likedBy"]);
    $key = (int)search($old["likedBy"], $id);
    if ($key===-1){
        die(json_encode(["error"=>4]));
    }
    
    unset($old["likedBy"][(int)$key]);
    $dataBase->executeSql("update projects set liked_by=? where id=?", [json_encode($old), $projectId]);
    //return (json_encode(["data"=>json_encode($old["likedBy"]), "and"=>(int)$_SESSION["userid"]]));
}
function validateJson($jsonData){
    foreach ($jsonData as $key => $value) {
        $ifTrue = TRUE;
        if (!preg_match("/projectId/", $key) || !preg_match("/\d{1,}/", $value)) {
            $ifTrue = false;
        }
    }
    return $ifTrue;
}


// Code is 1 for validation error

if ($_SERVER["REQUEST_METHOD"]=="PUT"){
    $_PUT = file_get_contents("php://input");
    $_PUT = (array)json_decode($_PUT);
    if (!validateJson($_PUT)){
        die(json_encode(["error"=>1]));
    }
    $dataBase->executeSql("UPDATE projects set likes = likes + 1 where id=?", [$_PUT["projectId"]]);
    add((int)$_PUT["projectId"]);
    die(json_encode(['success'=>1, 'type'=>9]));
}
else if ($_SERVER['REQUEST_METHOD']=='DELETE'){
    $_DELETE = file_get_contents("php://input");
    $_DELETE = (array)json_decode($_DELETE);
    if (!validateJson($_DELETE)){
        die(json_encode(["error"=>1]));
    }
    $dataBase->executeSql("UPDATE projects set likes = likes - 1 where id=? and likes >=0", [$_DELETE["projectId"]]);
    //die("Data|" . (int)exists((int)$_SESSION["userid"]));
    if (exists((int)$_SESSION["userid"], $_DELETE["projectId"])){
        remove((int)$_SESSION["userid"] , (int)$_DELETE["projectId"]);
    }
    die(json_encode(['success'=>1, 'type'=>10]));
}
exit;