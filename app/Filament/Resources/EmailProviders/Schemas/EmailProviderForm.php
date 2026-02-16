<?php

namespace App\Filament\Resources\EmailProviders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EmailProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Slug identificativo univoco (es: gmail, office365)'),
                TextInput::make('display_name')
                    ->required()
                    ->maxLength(255)
                    ->helperText("Nome visualizzato nell'interfaccia utente"),
                TextInput::make('type')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Protocollo principale: imap, gmail_api, microsoft_graph'),
                TextInput::make('icon'),
                TextInput::make('color')
                    ->helperText('Codice esadecimale del colore brand per la UI'),
                TextInput::make('imap_host')
                    ->helperText('Indirizzo del server IMAP'),
                TextInput::make('imap_port')
                    ->numeric()
                    ->helperText('Porta IMAP (solitamente 993 per SSL)'),
                TextInput::make('imap_encryption')
                    ->helperText('Tipo di crittografia IMAP: ssl, tls o null'),
                TextInput::make('pop3_host'),
                TextInput::make('pop3_port')
                    ->numeric(),
                TextInput::make('pop3_encryption'),
                TextInput::make('smtp_host')
                    ->helperText("Indirizzo del server SMTP per l'invio"),
                TextInput::make('smtp_port')
                    ->numeric()
                    ->helperText('Porta SMTP (es: 587 per STARTTLS)'),
                TextInput::make('smtp_encryption')
                    ->helperText('Tipo di crittografia SMTP: ssl o tls'),
                Toggle::make('smtp_auth_required')
                    ->required()
                    ->helperText('Indica se il server richiede autenticazione per inviare'),
                TextInput::make('api_endpoint')
                    ->helperText('URL base per integrazioni API (es: Graph API)'),
                TextInput::make('api_version')
                    ->helperText("Versione specifica dell'API utilizzata"),
                TextInput::make('oauth_client_id')
                    ->helperText('ID cliente per autenticazione OAuth2'),
                TextInput::make('oauth_client_secret')
                    ->password()
                    ->helperText('Segreto cliente per OAuth2 (da gestire con cautela)'),
                TextInput::make('oauth_redirect_uri')
                    ->helperText('URL di callback per il ritorno dal login social'),
                TextInput::make('oauth_scopes')
                    ->helperText("Permessi richiesti all'utente (JSON array)"),
                TextInput::make('timeout')
                    ->required()
                    ->numeric()
                    ->default(30)
                    ->helperText('Secondi di attesa prima del fallimento connessione'),
                Toggle::make('verify_ssl')
                    ->required()
                    ->helperText('Verifica la validità del certificato SSL del server'),
                TextInput::make('auth_type')
                    ->required()
                    ->default('password')
                    ->helperText('Metodo di login: password, oauth, api_key'),
                TextInput::make('settings')
                    ->helperText('Configurazioni extra specifiche del provider in formato JSON'),
                Toggle::make('is_active')
                    ->required()
                    ->helperText('Disabilita il provider a livello globale se necessario'),
                Textarea::make('description')
                    ->columnSpanFull()
                    ->helperText('Breve descrizione del provider'),
                Textarea::make('setup_instructions')
                    ->columnSpanFull()
                    ->helperText("Istruzioni per l'utente per abilitare IMAP/OAuth sul proprio account"),
            ]);
    }
}
