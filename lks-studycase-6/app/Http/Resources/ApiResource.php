<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    public $status;
    public $message;
    public $resource;
    public function __construct($status, $message, $resource)
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
    }
    public function toArray(Request $request): array
    {
        return [
            "status" => $this->status,
            "message" => $this->message,
            "data" => $this->resource
        ];
    }
}
