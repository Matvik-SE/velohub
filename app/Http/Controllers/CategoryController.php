<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use App\Models\Category;
use App\Services\CategoryFilters;
use App\Services\Filters\Filter;
use App\Services\Filters\SliderFilter;

class CategoryController extends Controller
{
    public function __invoke(Request $request, string $slug, int $id, string $path = ''): View
    {
        $category = Category::whereId($id)->isActive()->firstOrFail();

        $query = $category
            ->products()
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->isActive();

        $filters = $this
            ->initFilters($category, $query, $request)
            ->each(function ($element) use ($query) {
                $element->applyFilter($query);
            });

        $products = $query->select('variants.*', 'products.*')
            ->orderBy('products.' . $request->sortCol, $request->sortOrd)
            ->simplePaginate();

        $meta = (object)[
            'title' => $category->name,
            'description' => $category->description,
            'keywords' => $category->keywords,
        ];

        return view('category', compact(['category', 'filters', 'products', 'meta']));
    }

    private function initFilters($category, $query, $request): Collection
    {
        return collect([
            'price' => SliderFilter::init('products.price', 'price', 'Price')
                ->fetchValues($query)
                ->fetchParams($request->filter),
            'brand' => Filter::init('products.brand', 'brand', 'Brand')
                ->fetchValues($query)
                ->fetchParams($request->filter),
            'features' => CategoryFilters::init($category, 'features', 'products')
                ->fetchFilters($query, $request->filter),
            'parameters' => CategoryFilters::init($category, 'parameters', 'variants')
                ->fetchFilters($query, $request->filter),
        ]);
    }
}
