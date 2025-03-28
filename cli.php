<?php

require_once __DIR__ . '/vendor/autoload.php';

$command = $argv[1] ?? null;

$data = json_decode(file_get_contents(__DIR__ . '/data.json'), true); // Decode JSON as associative array

// Helper function to print a separator line
function printSeparatorLine($widths) {
    echo '+';
    foreach ($widths as $width) {
        echo str_repeat('-', $width + 2) . '+';
    }
    echo PHP_EOL;
}

// Helper function to print a row
function printRow($row, $widths) {
    echo '|';
    foreach ($row as $key => $value) {
        printf(" %-{$widths[$key]}s |", $value);
    }
    echo PHP_EOL;
}

// Define headers
$headers = ['id', 'description', 'status', 'createdAt', 'updatedAt'];

// Calculate column widths
$widths = array_map(function ($header) use ($data) {
    $maxLength = strlen($header);
    foreach ($data as $row) {
        $value = $row[$header];
        $maxLength = max($maxLength, strlen((string) $value));
    }
    return $maxLength;
}, $headers);

// Print the table
printSeparatorLine($widths);
printRow($headers, $widths);
printSeparatorLine($widths);

foreach ($data as $row) {
    $rowData = array_map(function ($header) use ($row) {
        return $row[$header];
    }, $headers);
    printRow($rowData, $widths);
}

printSeparatorLine($widths);
