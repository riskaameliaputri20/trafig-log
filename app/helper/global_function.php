<?php


if (!function_exists("paginateCollection")) {
    function paginateCollection(\Illuminate\Support\Collection $items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
        $itemsForCurrentPage = $items->slice(($page - 1) * $perPage, $perPage)->values();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $itemsForCurrentPage,
            $items->count(),
            $perPage,
            $page,
            $options
        );
    }
}
