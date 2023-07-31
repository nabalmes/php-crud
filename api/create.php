<?php
    include_once '../config/database.php';
    include_once '../class/employees.php';
    $database = new Database();
    $db = $database->getConnection();
    $item = new Employee($db);
    $data = json_decode(file_get_contents("php://input"));
    $item->name = $data->name;
    $item->email = $data->email;
    $item->age = $data->age;
    $item->designation = $data->designation;
    $currentDateTimeUTC = new DateTime('now', new DateTimeZone('UTC'));
    $targetTimeZone = new DateTimeZone('Asia/Manila'); // You can use 'Asia/Manila', 'Asia/Kuala_Lumpur', or other timezone strings.
    $currentDateTimeGMTPlus8 = $currentDateTimeUTC->setTimezone($targetTimeZone);
    $createdDateTimeFormatted = $currentDateTimeGMTPlus8->format('Y-m-d h:i:s A');
    $item->created = $createdDateTimeFormatted;

    
    if($item->createEmployee()){
        echo 'Employee created successfully.';
    } else{
        echo 'Employee could not be created.';
    }
?>