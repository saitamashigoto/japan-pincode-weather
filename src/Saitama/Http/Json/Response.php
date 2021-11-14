<?php

namespace Saitama\Http\Json;

class Response
{
   private bool $isError;
   
   private array $content;

   private $errorMessage;

   public function __construct(
       bool $isError = false,
       string $errorMessage = "",
       array $content = []
   ) {
        $this->content = $content;
        $this->isError = $isError;
        $this->errorMessage = $errorMessage;
   }

   public function getIsError(): bool
   {
       return $this->isError;
   }

   public function getErrorMessage(): string
   {
       return $this->errorMessage;
   }

   public function getContent(): array   
   {
       return $this->content;
   }
}