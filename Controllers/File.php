<?php
// Start session
session_start();

include('../Config/database.php');

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT * FROM Upload WHERE userId = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    $response['html'] = '';
    while($file = $result->fetch_assoc()){
        $response['html'] .= "<tr class='row'><td class='col-8'>".basename($file['filename'])."</td><td class='col-4'>".date('jS F Y H:i:s', strtotime($file['uploadedDate']))."</td></tr>";
    }

    $stmt->close();

    if(!empty($response)){
        echo json_encode($response);
        exit;
    }
}
?>