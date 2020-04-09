<?php
include('conn.php');
//for ($x=0; $x<50; $x++){
    $file = file_get_contents('https://loripsum.net/api/3/short',true);
    $uTime = time();
    $query = "INSERT INTO `bposts` (`content`, `date`) VALUES ('".$file."', $uTime)";
    $result = mysqli_query($link, $query);
    //echo $file;
//}

$myArray = array();
$myRow = array();

if(empty($_POST['iload'])){         //receiving data sent by ajax call
    $vlimit = 1;
}else{
    $vlimit = $_POST['iload'];
}

if(isset($_POST['oset'])){         //receiving data sent by ajax call
    //$myArray['check02'] = 'fail';
    $oset = $_POST['oset'];
}else{
    //$myArray['check01'] = 'pass';
    $oset = 0;
}

$myArray['error'] = empty($_POST['oset']); //updating myArray : data to be sent to the frontend
$myArray['vlimit'] = $vlimit;
$myArray['oset'] = $oset;

$query = "SELECT * FROM `bposts` ORDER BY id ASC LIMIT ".$vlimit." OFFSET ".$oset."";
$result = $link-> query($query);

while ($row = $result->fetch_array()){
    $myRow[] = array(
        "id" => $row['id'],
        "content" => $row['content'],
        "date" => $row['date']
    );
}

$myArray['content'] = $myRow;  
echo json_encode($myArray);   //returning query+data to front end