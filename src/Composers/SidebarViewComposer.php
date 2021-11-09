<?php

namespace TypiCMS\Modules\Taxonomies\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('read taxonomies')) {
            return;
        }
        $view->sidebar->group(__('Content'), function (SidebarGroup $group) {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__('Taxonomies'), function (SidebarItem $item) {
                $item->id = 'taxonomies';
                $item->icon = config('typicms.taxonomies.sidebar.icon');
                $item->weight = config('typicms.taxonomies.sidebar.weight');
                $item->route('admin::index-taxonomies');
                $item->append('admin::create-taxonomy');
            });
        });
    }
}
