<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginationResource extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'pagination' =>[
                'total' => $this->resource->total(),
                'per_page' => $this->resource->perPage(),
                'from' => $this->resource->firstItem(),
                'to' => $this->resource->lastItem(),
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'has_next' => $this->resource->hasMorePages(),
            ]
        ];
    }
}
