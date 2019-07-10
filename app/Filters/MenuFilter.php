<?php

namespace App\Filters;

use Illuminate\Support\Facades\Auth;
use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class MenuFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {
        if (\Auth::check()) {
            if (isset($item['role'])) {
                if (!Auth::user()->hasRole($item['role'])) {
                    return false;
                } else {
                    return $item;
                }
            }

            return $item;
        } else {
            return false;
        }
    }
}
