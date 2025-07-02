<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Page;

class TestPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.teacher.pages.test-page';
    protected static ?string $title = 'Test Page';
    protected static ?string $navigationLabel = 'Test';
} 