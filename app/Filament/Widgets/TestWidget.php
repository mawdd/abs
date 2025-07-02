<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class TestWidget extends Widget
{
    protected static string $view = 'filament.widgets.test-widget';
    
    protected static ?int $sort = 0;
    
    protected int | string | array $columnSpan = 'full';
} 