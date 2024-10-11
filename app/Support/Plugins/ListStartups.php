<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class ListStartups extends Plugin
{
    public function sidebar(): Item
    {
        return Item::create(__('List of Startups')) // Update the label to reflect the correct functionality
            ->route('list-startups.index') // Update the route to point to the student registration index
            ->icon('fa fa-user-plus') // You can change the icon to something more appropriate
            ->active("list-startups*") // Update the active route pattern
            ->permissions('users.manage') // Uncomment and set permissions if needed
        ;
    }
}
