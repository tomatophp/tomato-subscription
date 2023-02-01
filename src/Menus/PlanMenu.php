<?php

namespace TomatoPHP\TomatoSubscription\Menus;

use TomatoPHP\TomatoPHP\Services\Menu\Menu;
use TomatoPHP\TomatoPHP\Services\Menu\TomatoMenu;

class PlanMenu extends TomatoMenu
{
    /**
     * @var ?string
     * @example ACL
     */
    public ?string $group = "Plan";

    /**
     * @var ?string
     * @example dashboard
     */
    public ?string $menu = "dashboard";

    public function __construct()
    {
        $this->group = trans('tomato-subscription::global.plans.group');
    }

    /**
     * @return array
     */
    public static function handler(): array
    {
        return [
            Menu::make()
                ->label(trans('tomato-subscription::global.plans.title'))
                ->icon("bx bxs-bookmark")
                ->route("admin.plans.index"),
        ];
    }
}
