<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse as BasePaginatedResourceResponse;
use Illuminate\Support\Arr;
use JetBrains\PhpStorm\ArrayShape;

class PaginatedResourceResponse extends BasePaginatedResourceResponse
{
    /**
     * Add the pagination information to the response.
     *
     * @param  Request  $request
     *
     * @return array
     */
    #[ArrayShape([
        'meta' => "array",
    ])]
    protected function paginationInformation($request): array
    {
        $paginated = $this->resource->resource->toArray();

        return [
            'meta' => $this->meta($paginated),
        ];
    }

    /**
     * Get the pagination links for the response.
     *
     * @param  array  $paginated
     *
     * @return array
     */
    #[ArrayShape([
        'first' => "mixed|null",
        'last'  => "mixed|null",
        'prev'  => "mixed|null",
        'next'  => "mixed|null",
    ])]
    protected function paginationLinks($paginated): array
    {
        return [
            'first' => $paginated['first_page_url'] ?? null,
            'last'  => $paginated['last_page_url'] ?? null,
            'prev'  => $paginated['prev_page_url'] ?? null,
            'next'  => $paginated['next_page_url'] ?? null,
        ];
    }

    /**
     * Gather the metadata for the response.
     *
     * @param  array  $paginated
     *
     * @return array
     */
    #[ArrayShape([
        'pages'   => "array",
        'records' => "array",
        'links'   => "array",
    ])]
    protected function meta($paginated): array
    {
        return [
            'records' => [
                'count' => $this->resource->count(),
                'total' => $paginated['total'],
            ],
            'pages'   => [
                'per'     => $paginated['per_page'],
                'current' => $paginated['current_page'],
                'total'   => $paginated['last_page'],
            ],
            'links'   => [
                'first' => $paginated['first_page_url'] ?? null,
                'last'  => $paginated['last_page_url'] ?? null,
                'prev'  => $paginated['prev_page_url'] ?? null,
                'next'  => $paginated['next_page_url'] ?? null,
            ],
        ];
    }
}