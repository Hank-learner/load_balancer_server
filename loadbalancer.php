<?php

$servername="localhost";
$username="root";
$password="";
$dbname="CERNrequests";
$conn=mysqli_connect($servername,$username,$password,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";



$id=$_POST['id'];
$cpu=$_POST['cpu'];
$memory=$_POST['memory'];
$time=$_POST['time'];
$starttime=date('y-m-d h:i:s');
$allocatednode ="none";
$nodesname=array();
$cpuinnode=array();
$memoryinnode=array();



$sql="SELECT Name,Available_CPU,Available_memory FROM nodes;";
$nodestable=mysqli_query($conn,$sql);
$nodesrows=mysqli_num_rows($nodestable);
for($i=0;$i<$nodesrows;$i++){
	$nodesrowdata=mysqli_fetch_asssoc($nodestable);
	$nodesname[$i]=$nodesrowdata['Name'];
	$cpuinnode[$i]=$nodesrowdata['Available_CPU'];
	$memoryinnode[$i]=$nodesrowdata['Available_memory'];
}



$cpuinnodefree=$cpuinnode;
$memoryinnodefree=$memoryinnode;

$sql="SELECT allocated_node_name,start_time,CPU_required,Memory_required,time_required_for_completion FROM requests;";
$requeststable=mysqli_query($conn,$sql);
$requestsrows=mysqli_num_rows($requeststable);
if($requeststable){
	for($i=0;$i<$requestsrows;$i++){
		$requestsrowdata=mysqli_fetch_asssoc($requeststable);
		$requiredtime=$requestsrowdata["time_required_for_completion"];
		$node=$requestsrowdata["allocated_node_name"];
		$currenttime=date('y-m-d h:i:s');
		$requeststarttime=$requestsrowdata["start_time"];
		$temp=$requeststarttime;
        $temp->add(new DateInterval('P' . $requiredtime . 'S'));#does the concatenation work?
        $requestendtime=$temp->format('y-m-d h:i:s');
		if($currenttime>$requestendtime){
			for($i=0;$i<$nodesrows;$i++){
              if($node == $nodesname[$i]){
                $cpuinnodefree[$i] -= $requestsrowdata["CPU_required"];
                $memoryinnodefree[$i] -= $requestsrowdata["Memory_required"];
                break;
              }
      }
		}

	}
}



for($i=0;$i<$nodesrows;$i++){
    if($cpuinnodefree[$i]>$cpu && $memoryinnodefree[$i]>$memory){
        $allocatednode = $nodesname[$i];  
        $cpuinnode[$i] += $cpu;
        $memoryinnode[$i] += $memory;
        $sql = "INSERT INTO requests VALUES ('$id', '$allocatenode', '$starttime', $cpu, $memory, $time);";
        mysqli_query($conn,$sql);
        $sql = "UPDATE nodes SET Available_CPU=$cpuinnode[$i]-$cpu, Available_memory=$memoryinnode[$i]-$memory WHERE NodeName='$allocatednode';";
        mysqli_query($conn,$sql);
    }
}


if(allocatednode == "none")
{
 die("Request couldnt be handled:servers are busy or your requirement is high");
}

mysqli_close($conn);
?>