<?php
$entityBody = ((Object)$_REQUEST);

if(!isset($entityBody->jobLog) || !isset($entityBody->link)|| !isset($entityBody->taskDescription) || !isset($entityBody->user)|| !isset($entityBody->callback)){    
  die(json_encode($entityBody, JSON_PRETTY_PRINT));  
  die("error in request body");
}

$callback = $entityBody->callback;
$link = $entityBody->link;
$user = $entityBody->user;
$jobLog = $entityBody->jobLog;
$taskDescription = $entityBody->taskDescription;
?>

<html>
  <head>
    <title><?=$taskDescription ?></title>
  </head>
  <body>
      <h1> 3D Printer AG </h1>
      <h2>To-do: <?=$taskDescription ?></h2>
      <form action="final.php" method="POST">
<?php
    echo file_get_contents($link);
?>      
        <input type="hidden" value="<?=$jobLog ?>" name="jobLog"/>
        <input type="hidden" value="<?=$callback ?>" name="callback"/>
        <input type="hidden" value="<?=$user ?>" name="user"/>
      </form>
    </div>
    <div>
    <button onclick="history.back()">Back to Worklist</button>
    </div>
  </body>
</html>
