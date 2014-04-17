
<html>
<head>

<!--All the css is generated online!-->
 <link rel="stylesheet" type="text/css" href="style.css">
</head>

<?php
session_start();

//User_defined function definitions

//Display The sorted values one by one!
function display($val,$ot){


//$ot is to check if display is called from main or search result ,since when display is called form main $val is a multi-dimensional Array and when display is called form search box,$val is a single dimensional array


echo "<center>";

echo '<table>';
echo "<tr>";
echo '<th>Name</th>';
echo '<th>Rollno</th>';
echo '<th>City</th>';
echo '<th>Subject</th>';
echo "</tr>";

if($ot==1){
    echo str_repeat('<br>', 10);
	echo "Roll No Found!!<br><tr>";
    foreach($val as $k=>$vf){
	 echo "<td>".$vf."</td>";
    }
   echo "</tr>";
	
echo '</table>';
echo "</center>";
}


if($ot==2){
//2 loops since val is a Multi-Dimensional Array!
foreach($val as $key=>$v){
	echo "<tr>";
    foreach($v as $k=>$vf){
	 echo "<td>".$vf."</td>";
    }
   echo "</tr>";
	}
echo '</table>';
echo "</center>";
}
}
//Callback Function logic to sort the array by name,called by usort fucntion which passes 2 values at a time and return the greater one
function compareArrayByName($a, $b)
{
  return strcasecmp($a[0],$b[0]);
}

//Handle incoming search request in GET array 
if(isset($_POST['query'])){
 if(isset($_SESSION['val'])){
  $flag=0;
  
  foreach($_SESSION['val'] as $key=>$v){
    
	if(!strcmp($v[1],$_POST['query'])){
	   $flag=1;
	   display($v,1);
	   break;
	   }

 }
  
  if($flag==1){
  
    
  }
   
  else if($flag==0)
    echo "No Such Roll no Found, Please Check Your Roll no!";
 }
echo '<br><br><br><a href="index.php" class="home">Take Me back to home!</a>';

 }
//If not a POST request , do normal File handling and display all records in a file
else{


//Handle or object after file is opened.Input file is open in read mode.
$file_handle = fopen("input.txt", "r");

//Check if file don't have any errors
if ($file_handle) {
    
	
	//Initialize for array index
	$i=0; 
	
	//Multi-dimensional array for storing records ex.. val ={0=>'name','Rollno','city','Subject',1=>'name','Rollno','city','Subject'....}
	$val = array(array()); 
    
	//Process File line by line until end of File..!
	while (($line = fgets($file_handle)) !== false) {
       
	   //Sepearate values delimted by '|' in an array
	   $fields = explode("|",$line);
	   //$field[0]="name",$field[1]="Rollno",$field[2]="city",$field[4]="Subject",
	       
	   //Store the $fields in a Multi-Dimensoinal Array.
       $val[$i]=$fields;
	
       //Increment the index
	   $i++;
    }
} 

else {
    // error opening the file.
	die("Error Opening File,try Again with new input file");
} 
//Close The file handle
fclose($file_handle);

//Sort the values by name,compareArrayByName is the Callback function bunded at run time which is defined above,usort is the predefined function in PHP which takes 2 values,Multi-Dimensional array to be sorted and callback function which contains logic of sorting.
usort($val, 'compareArrayByName');

echo "<b><center>All fields extracted from input file and sorted by name</b><br>-------------------------------------------------------------<br></center>";
    echo '<div id="search5back">';
	echo '<form method="post" action="index.php" id="searchbox5">';
	echo '<input id="search51" name="query" type="text" size="60" placeholder="RollNo_Search..." />';
	$_SESSION['val']=$val;
	echo '</form></div>';

//User defined display function to display values!
display($val,2);

}
?>
</html>