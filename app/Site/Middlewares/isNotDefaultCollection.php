<?php
namespace App\Site\Middlewares;

use App\Site\Models\Collection;

use Closure;

class isNotDefaultCollection
{
    public function handle($request, Closure $next)
    {
        $collection = Collection::findBySlugOrFail($request->collectionSlug);

        if($collection->isDefault()) {
            return redirect()->route('collection.index', [$request->user()->slug, $collection->slug])->with('alert', 'info|Coleção é padrão');
        }

        return $next($request);
    }
}