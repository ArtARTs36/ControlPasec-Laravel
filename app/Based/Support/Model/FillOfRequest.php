<?php

namespace App\Based\Support\Model;

use Illuminate\Http\Request;

trait FillOfRequest
{
    public function fillOfRequest(Request $request): self
    {
        $this->fill($request->toArray());

        return $this;
    }
}
