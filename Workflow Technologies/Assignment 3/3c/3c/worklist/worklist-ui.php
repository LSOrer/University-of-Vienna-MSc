<html>
  <body>
      <h1> 3D Printer AG </h1>

<?php  
if(isset($_GET["user"])){
    if($_GET["user"] == "*"){
        $page = "Overview";
    } 
    else {
        $page = ($_GET["user"])."'s worklist";
        }
} 
else {
$page = "You need to extend your url with '?user=*'";
    }
?>

<h2><?=$page ?></h2>   

<?php
if(isset($_GET["user"])){
    $user = $_GET["user"];
    if($user == "*"){
        foreach(allEmployees() as $user){
            echo "<h3>$user's worklist</h3>";
            $tasks = employeeJobs($user);
            if(count($tasks)!= 0){
                jobTable($tasks, $user);
            } else {
                echo "Nothing to do for now";
                }
        }
    } else {
        $tasks = employeeJobs($user);
        if(count($tasks)!= 0){
            jobTable($tasks, $user);
        } else {
            echo "Nothing to do for now, get yourself a coffee!";
            }
    }
}
?>
  </body>
</html>

<?php
function employeeJobs($username){ 
    $directory = scandir('./jobs');
    $tasks = [];
    foreach($directory as $file){
        if(strpos($file, ".json") !== false){ 
            $fileContent = json_decode(file_get_contents('./jobs/'.$file), true);
            if(isset($fileContent["id"]) && $fileContent["id"] == $username){
                array_push($tasks, $file);
            }
        }
    }
    return $tasks;
}

function allEmployees(){
    $xml = simplexml_load_file("organisation.xml") or die("couldn't load xml");
    $xml->registerXPathNamespace("wt", "http://cpee.org/ns/organisation/1.0");
    $allUsers = $xml->xpath("//wt:subject/@id");
    $allUsers = (array)$allUsers;
    return $allUsers;
}

function jobTable($tasks, $user){
?>    <table border="1">
    <tr>
            <th>Task</th>
        </tr>

<?php    
    foreach($tasks as $task){
        $fileContent = json_decode(file_get_contents('./jobs/'.$task), true);
        $link = $fileContent["link"];
        $cpeecallback = $fileContent["CPEE-CALLBACK"];
        $description = $fileContent["taskname"];

?>  
    <tr>
        <td><?=$description ?></td>
        <td>
            <form action='work.php'>
                <input type="hidden" name="link" value="<?=$link ?>" />
                <input type="hidden" value="<?=$cpeecallback ?>" name="callback"/>
                <input type="hidden" value="<?=$task ?>" name="jobLog"/>
                <input type="hidden" value="<?=$description ?>" name="taskDescription"/>
                <input type="hidden" value="<?=$user ?>" name="user"/>
                <input type="submit" value="Take">
            </form>
        </td>
        <td>
            <form action="giveback.php">
                <input type="hidden" value="<?=$task ?>" name="jobLog"/>
                <input type="submit" value="Reassign"/>
            </form>
        </td>
    </tr>
<?php
    }
    ?>    </table>

<?php  

}

?>