<?php
// Convert JSON string to PHP array
$jsonData = file_get_contents('cars.json');
$cars = json_decode($jsonData, true);

// Check if the input query is provided
if (isset($_GET['input']) && !empty($_GET['input'])) {
    $searchQuery = strtolower($_GET['input']);
    $searchResults = array_filter($cars, function ($car) use ($searchQuery) {
        return strpos(strtolower($car['model']), $searchQuery) !== false || strpos(strtolower($car['type']), $searchQuery) !== false;
    });
    
    // Limit results to top 5 suggestions
    $searchResults = array_slice($searchResults, 0, 5);

    // Return the search results as JSON
    echo json_encode(array_values($searchResults));
}
?>
