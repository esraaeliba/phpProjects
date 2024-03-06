<?php
require_once("vendor/autoload.php");

$conn = new MainProgram;

$fields = ["id", "PRODUCT_code", "Photo", "product_name"];
$items = array();

$page = isset($_GET["page"]) ? $_GET["page"] : 0;

if (($_SERVER["REQUEST_METHOD"] == "GET") && isset($_GET["click"])) {
    
    if ($_GET["click"] == "prev") {
        if ($page > 0) {
            $page -= 5;
            if ($page < 0) $page = 0;
        }
    } else if ($_GET["click"] == "next") {
        $page += 5;
        if ($page >15) $page = 0;
    }
}


if ($conn->connect()) {
    $items = $conn->get_data($fields, $page);
}


if (($_SERVER["REQUEST_METHOD"] == "GET") && isset($_GET["name_column"]) && isset($_GET["value"])) {
    $items = $conn->search_by_column($_GET["name_column"], $_GET["value"]);
}

if (count($items) > 0) {
    echo  '<table>';
    echo   '<tr>';
    foreach ($fields as $field) {

        echo '<th>' . $field . '</th>';
    }
    echo   '</tr>';


    foreach ($items as $item) {
        echo   '<tr>';
        foreach ($fields as $field) {
            echo '<td>' . $item->$field . '</td>';
        }
        echo '<td>' . "<a href='getInfoGlasses.php/?id=$item->id'>" . "More" . "</a>" . '</td>';
        echo   '</tr>';
    }
    echo  '</table>';

    echo "<a style='margin-right:10px' href='?click=prev&page=$page'>" . "Prev" . "</a>";
    echo "<a href='?click=next&page=$page'>" . "Next" . "</a>";
}



$conn->disconnect();
