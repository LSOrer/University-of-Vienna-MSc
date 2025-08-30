<?php
header("Content-Type: application/json");
header('CPEE-CALLBACK: true');

$headers = apache_request_headers();
$job = array("CPEE-CALLBACK" => isset($headers["CPEE-CALLBACK"]) ? $headers["CPEE-CALLBACK"]: null);
$job = array_merge($job,$_POST);
$job = array_merge($job, array("id" => findIdleEmployee($_POST["role"])));

$jobJson = array(
    "envelope" => json_encode(
        array(
            "instance-uuid" => $headers["CPEE-INSTANCE-UUID"], 
            "content" => array(
                "label" => $headers["CPEE-LABEL"], 
                "user" => $job["id"], 
                "parameters" => array(
                    "arguments" => array(
                        array(
                            "name" => "role",
                            "value" => $_POST["role"]
                        )
                    )
                )
            
        )
    ),JSON_PRETTY_PRINT)
);

$job = array_merge($job, array("envelope" => json_decode($jobJson["envelope"])));
file_put_contents("jobs/job".rand().".json", json_encode($job, JSON_PRETTY_PRINT));
echo json_encode($job, JSON_PRETTY_PRINT);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-Type: application/x-www-form-urlencoded',
        'content' => http_build_query($jobJson)
    )
);
$context = stream_context_create($opts);

function findLatestEmployee($role){
    $robinFile = "round-robin.json";
     if(file_exists($robinFile)){
        $robinData =  json_decode(file_get_contents($robinFile));
        if(isset($robinData->$role))
            return $robinData->$role;
    }
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

?>