<?php
include 'config.php';

// Query to fetch the updated unpaid orders count
$unpaidOrdersCountQuery = "SELECT COUNT(*) as count FROM borrowedbooks WHERE status = 'unpaid'";
$unpaidOrdersCountResult = $conn->query($unpaidOrdersCountQuery);
$unpaidOrdersCount = 0;

if ($unpaidOrdersCountResult->num_rows > 0) {
    $row = $unpaidOrdersCountResult->fetch_assoc();
    $unpaidOrdersCount = $row['count'];
}

// Query to fetch details of unpaid orders
$unpaidOrdersDetailsQuery = "SELECT * FROM borrowedbooks WHERE status = 'unpaid'";
$unpaidOrdersDetailsResult = $conn->query($unpaidOrdersDetailsQuery);
$unpaidOrdersDetails = [];

if ($unpaidOrdersDetailsResult->num_rows > 0) {
    while ($row = $unpaidOrdersDetailsResult->fetch_assoc()) {
        $unpaidOrdersDetails[] = $row;
    }
}

$response = [
    'count' => $unpaidOrdersCount,
    'details' => $unpaidOrdersDetails
];

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
