<?php

namespace TaskTrackerCli;

class Task
{
   private int $id;
   private string $description;
   private string $status;
   private string $createdAt;
   private string $updatedAt;

   public function __construct(int $id, string $description, string $status = 'todo', ?string $createdAt = null, ?string $updatedAt = null)
   {
      $this->id = $id;
      $this->description = $description;
      $this->status = $status;
      $this->createdAt = $createdAt ?? date("Y-m-d H:i:s");
      $this->updatedAt = $updatedAt ?? date("Y-m-d H:i:s");
   }

   public function getId(): int
   {
      return $this->id;
   }

   public function getDescription(): string
   {
      return $this->description;
   }

   public function setDescription(string $description): void
   {
      $this->description = $description;
      $this->updateTimestamp();
   }

   public function getStatus(): string
   {
      return $this->status;
   }

   public function setStatus(string $status): void
   {
      $this->status = $status;
      $this->updateTimestamp();
   }

   public function getCreatedAt(): string
   {
      return $this->createdAt;
   }

   public function getUpdatedAt(): string
   {
      return $this->updatedAt;
   }

   private function updateTimestamp(): void
   {
      $this->updatedAt = date("Y-m-d H:i:s");
   }

   public function toArray(): array
   {
      return [
         'id' => $this->id,
         'description' => $this->description,
         'status' => $this->status,
         'createdAt' => $this->createdAt,
         'updatedAt' => $this->updatedAt,
      ];
   }
}
