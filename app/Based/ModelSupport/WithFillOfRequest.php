<?php

namespace App\Based\ModelSupport;

use Illuminate\Http\Request;

trait WithFillOfRequest
{
    public function fillOfRequest(Request $request): self
    {
        return $this->fill($request->only($this->getFillable()));
    }

    public function updateOfRequest(Request $request): self
    {
        $this->fillOfRequest($request);
        $this->save();

        return $this;
    }
}
