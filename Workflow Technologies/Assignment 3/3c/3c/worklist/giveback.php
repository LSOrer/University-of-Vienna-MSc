<?php
$entityBody = ((Object)$_REQUEST);
if(!isset($entityBody->jobLog)){    
    die("error");
}

$path = './jobs/'.$entityBody->jobLog;
$fileContent = json_decode(file_get_contents($path), true);
$role = $fileContent["role"];
$id = $fileContent["id"];
$next = findIdleEmployee($role);

header("Location: worklist-ui.php?user=". $id);

do {
    $next = findIdleEmployee($role); 
} while ($next == $fileContent["id"]);
$fileContent["id"] = $next;
file_put_contents($path, json_encode($fileContent, JSON_PRETTY_PRINT));

exit();

function roundRobinAssign($id, $role){
    $xml = simplexml_load_file("organisation.xml") or die("xml error");
    $xml->registerXPathNamespace("wt", "http://cpee.org/ns/organisation/1.0");
    $allEmployees = $xml->xpath("//wt:subject[./wt:relation/@role='$role']/@id");
    $allEmployees = (array)$allEmployees;
    $employeeId = array_search($id,$allEmployees);
    $nextEmployee = ($employeeId + 1)%count($allEmployees);
    return (string)$allEmployees[$nextEmployee];
}

function findIdleEmployee($role){
    $xml = simplexml_load_file("organisation.xml") or die("xml error");
    $xml->registerXPathNamespace("wt", "http://cpee.org/ns/organisation/1.0");
    $allEmployees = $xml->xpath("//wt:subject[./wt:relation/@role='$role']/@id");
    $allEmployees = (array)$allEmployees;
    $employeeId = array_search(findLatestEmployee($role),$allEmployees);
    $nextEmployee = ($employeeId + 1)%count($allEmployees);
    $assignee =  (string)$allEmployees[$nextEmployee];
    updateAssignedEmployee($role,$assignee);
    return $assignee;
}

function updateAssignedEmployee($role, $user){
    $robinFile = "round-robin.json";
    if(file_exists($robinFile)){
        $robinData =  json_decode(file_get_contents($robinFile));
        $robinData->$role = $user;
    }else{
        $robinData = array($role=> $user);
    }
   file_put_contents($robinFile, json_encode($robinData, JSON_PRETTY_PRINT));
}

function findLatestEmployee($role){
    $robinFile = "round-robin.json";
     if(file_exists($robinFile)){
        $robinData =  json_decode(file_get_contents($robinFile));
        if(isset($robinData->$role))
            return $robinData->$role;
    }
}

?>