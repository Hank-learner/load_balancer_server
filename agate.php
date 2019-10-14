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

$sql = "SELECT ID, start_time, CPU_required, Memory_required, time_required_for_completion FROM requests WHERE allocated_node_name = 'agate' ";
$requeststable=mysqli_query($conn,$sql);
$requestsrows=mysqli_num_rows($requeststable);

echo "<br>";
echo "<br>";
echo "<br>";

echo "<p>Agate Running Processes</p>";
echo "<br>";

echo "<table>";

echo "<tr>";

echo "<th>ID</th>";
echo "<th>allocated_node_name</th>"
echo "<th>start_time</th>";
echo "<th>CPU_required</th>";
echo "<th>Memory Required</th>";
echo "<th>Time Required</th>";

echo "</tr>";

for($i=0;$i<$requestsrows;$i++){
    $requestsrowdata=mysqli_fetch_asssoc($requeststable);

    $currenttime=date('y-m-d h:i:s');
    $requeststarttime=$requestsrowdata["start_time"];
    $temp=$requeststarttime;
    $temp->add(new DateInterval('P' . $requiredtime . 'S'));
    $requestendtime=$temp->format('y-m-d h:i:s');


    if($currenttime>$requestendtime){

    	$id=$requestsrowdata['ID'];
    	$starttime=$requestsrowdata['start_time'];
    	$cpu=$requestsrowdata['CPU_required'];
    	$memory=$requestsrowdata['Memory Required'];
    	$time=$requestsrowdata['Time Required'];

    	echo "<tr>";

        echo "<td>$id</td>";
        echo "<td>agate</td>";
        echo "<td>$starttime</td>";
        echo "<td>$cpu</td>";
        echo "<td>$memory</td>";
        echo "<td>$time</td>";

        echo "</tr>";


	}
}	
echo "</table>";


echo "<br>";
echo "<br>";
echo "<br>";

echo "History";
echo "<br>";

echo "<table>";

echo "<tr>";

echo "<th>ID</th>";
echo "<th>allocated_node_name</th>"
echo "<th>start_time</th>";
echo "<th>CPU_required</th>";
echo "<th>Memory Required</th>";
echo "<th>Time Required</th>";

echo "</tr>";

for($i=0;$i<$requestsrows;$i++){
    $requestsrowdata=mysqli_fetch_asssoc($requeststable);

    $currenttime=date('y-m-d h:i:s');
    $requeststarttime=$requestsrowdata["start_time"];
    $temp=$requeststarttime;
    $temp->add(new DateInterval('P' . $requiredtime . 'S'));
    $requestendtime=$temp->format('y-m-d h:i:s');


    if($currenttime<$requestendtime){

    	$id=$requestsrowdata['ID'];
    	$starttime=$requestsrowdata['start_time'];
    	$cpu=$requestsrowdata['CPU_required'];
    	$memory=$requestsrowdata['Memory Required'];
    	$time=$requestsrowdata['Time Required'];

    	echo "<tr>";

        echo "<td>$id</td>";
        echo "<td>agate</td>";
        echo "<td>$starttime</td>";
        echo "<td>$cpu</td>";
        echo "<td>$memory</td>";
        echo "<td>$time</td>";

        echo "</tr>";


	}
}	
echo "</table>";

mysqli_close($conn);

?>