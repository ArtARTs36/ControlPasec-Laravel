<?php

namespace App\Based\ModelSupport;

use Illuminate\Http\Request;

trait WithFillOfRequest
{
    public function fillOfRequest(Request $request): self
    {
        return $this->fill($request->only($this->getFillable()));
    }
}
