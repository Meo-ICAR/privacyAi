<?php

namespace App\Filament\Resources\SitiWebs\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class SitiWebForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('url')
                    ->url()
                    ->required()
                    ->maxLength(255)
                    ->helperText('URL completo del sito'),
                TextInput::make('nome_progetto')
                    ->maxLength(255)
                    ->helperText('Es: E-commerce, Blog, Portale Agenti'),
                Select::make('tipo')
                    ->options([
                        'istituzionale' => 'Istituzionale',
                        'ecommerce' => 'E-commerce',
                        'landing_page' => 'Landing Page',
                        'app_web' => 'Web App',
                    ])
                    ->default('istituzionale')
                    ->required(),
                Textarea::make('descrizione_trattamenti')
                    ->columnSpanFull()
                    ->helperText('Quali dati vengono raccolti su questo sito?'),
                Toggle::make('has_cookie_policy')
                    ->required(),
                Toggle::make('has_privacy_policy')
                    ->required(),
                TextInput::make('hosting_provider')
                    ->maxLength(255)
                    ->helperText('Dove risiedono i dati? (Es: AWS, Aruba)'),
            ]);
    }
}
