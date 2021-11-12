<?php

namespace Saitama\Http\Json;

class Response
{
   private bool $isError;
   
   private array $content;

   public function __construct(
       bool $isError = false,
       array $content = []
   ) {
        $this->content = $content;
        $this->isError = $isError;
   }

   public function getIsError(): bool
   {
       return $this->getIsError;
   }

   public function getContent(): array   
   {
       return $this->content;
   }
}