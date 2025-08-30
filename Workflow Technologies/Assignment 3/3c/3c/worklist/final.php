<?php
$entityBody = ((Object)$_REQUEST);
$user = $entityBody->user;
$jobLog = $entityBody->jobLog;
$callback = $entityBody->callback;
echo json_encode($entityBody, JSON_PRETTY_PRINT); 

$opts = array('http' =>
    array(
        'method'  => 'PUT',
        'header'  => 'Content-type: application/json',
        'content' => json_encode($entityBody)
    )
);
$context = stream_context_create($opts);
$result = file_get_contents($callback.'/', false, $context);

try{
    unlink('./jobs/'.$jobLog);
    } catch(Exception $e){
        }
header("Location: worklist-ui.php?user=". $user);
?>