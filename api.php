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

$query = "SELECT * FROM `bposts` ORDER BY id ASC LIMIT ".$vlimit." OFFSET 2";
$result = $link-> query($query);

while ($row = $result->fetch_array()){
    $myRow[] = array(
        "id" => $row['id'],
        "content" => $row['content'],
        "date" => $row['date']
    );
}

$myArray['content'] = $myRow;  //to ensure vallues are passed propely : console check
$myArray['vlimit'] = $vlimit;
echo json_encode($myArray);