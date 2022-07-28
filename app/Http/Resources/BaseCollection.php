<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

class BaseCollection extends AnonymousResourceCollection
{

    public function __construct($resource, $collects)
    {
        parent::__construct($resource, $collects);
    }

    #[ArrayShape([
        'success' => "bool",
        'data'    => "\Illuminate\Support\Collection",
    ])]
    public function toArray($request): array
    {
        return [
            'success' => true,
            'data'    => $this->collection,
        ];
    }

    /**
     * Create a paginate-aware HTTP response.
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    protected function preparePaginatedResponse($request): JsonResponse
    {
        if ($this->preserveAllQueryParameters) {
            $this->resource->appends($request->query());
        } elseif (!is_null($this->queryParameters)) {
            $this->resource->appends($this->queryParameters);
        }

        return (new PaginatedResourceResponse($this))->toResponse($request);
    }

}