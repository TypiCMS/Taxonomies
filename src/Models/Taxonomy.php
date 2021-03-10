<?php

namespace TypiCMS\Modules\Taxonomies\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Laracasts\Presenter\PresentableTrait;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\Taxonomies\Presenters\ModulePresenter;

class Taxonomy extends Base implements Sortable
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;
    use SortableTrait;

    protected $presenter = ModulePresenter::class;

    protected $guarded = [];

    public $translatable = [
        'title',
        'slug',
    ];

    public $sortable = [
        'order_column_name' => 'position',
    ];

    public function allForSelect(): array
    {
        $items = $this->order()
            ->get()
            ->pluck('title', 'id')
            ->all();

        return ['' => ''] + $items;
    }

    public function uri($locale = null): string
    {
        return '/';
    }

    public function terms(): HasMany
    {
        return $this->hasMany(Term::class)->order();
    }
}
