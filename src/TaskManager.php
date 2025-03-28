<?php

namespace TaskTrackerCli;

class TaskManager
{
   public function getAllTasks()
   {
      $tasks = (array) json_decode(file_get_contents(__DIR__ . '/../data.json'), true);

      $this->displayTasks($tasks);
   }

   private function displayTasks($tasks)
   {
      // Define headers
      $headers = ['id', 'description', 'status', 'createdAt', 'updatedAt'];

      // Calculate column widths
      $widths = array_map(function ($header) use ($tasks) {
         $maxLength = strlen($header);
         foreach ($tasks as $row) {
            $value = $row[$header];
            $maxLength = max($maxLength, strlen((string) $value));
         }
         return $maxLength;
      }, $headers);

      // Print the table
      $this->printSeparatorLine($widths);
      $this->printRow($headers, $widths);
      $this->printSeparatorLine($widths);

      foreach ($tasks as $row) {
         $rowData = array_map(function ($header) use ($row) {
            return $row[$header];
         }, $headers);
         $this->printRow($rowData, $widths);
      }

      $this->printSeparatorLine($widths);
   }

   // Helper function to print a separator line
   private function printSeparatorLine($widths)
   {
      echo '+';
      foreach ($widths as $width) {
         echo str_repeat('-', $width + 2) . '+';
      }
      echo PHP_EOL;
   }

   // Helper function to print a row
   private function printRow($row, $widths)
   {
      echo '|';
      foreach ($row as $key => $value) {
         printf(" %-{$widths[$key]}s |", $value);
      }
      echo PHP_EOL;
   }
}
