<?php

function dbConnect($host,$db,$user,$pass)
{
	$conn = new mysqli($host, $user, $pass, $db);
	if ($conn->connect_error) die($conn->connect_error);
	$conn->set_charset("utf8");
	
	return $conn;
}

function dbSelect($conn, $query)
{
	$result = $conn->query($query);
	if (!$result) die ("Сбой при доступе к базе данных: " . $conn->error);
	$rows = $result->num_rows;
	$resultSet = array();
	for ($j = 0 ; $j < $rows ; ++$j)
	{
		$result->data_seek($j);    
		$resultSet[] = $result-> fetch_array(MYSQLI_ASSOC);
	}
		
	$result->close();
	
	return $resultSet;
}

function dbInsert($conn, $query)
{
	$result = $conn->query($query);
	if (!$result) die ("Сбой при доступе к базе данных: " . $conn->error);
}

?>