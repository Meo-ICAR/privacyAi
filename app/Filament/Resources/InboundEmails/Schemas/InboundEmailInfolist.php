<?php

namespace App\Filament\Resources\InboundEmails\Schemas;

use App\Models\InboundEmail;
use Filament\Schemas\Infolists;
use Filament\Schemas\Schema;

class InboundEmailInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Header della mail
                Infolists\Components\Section::make()
                    ->columns(3)
                    ->schema([
                        Infolists\Components\Group::make([
                            Infolists\Components\TextEntry::make('from_name')
                                ->label('Nome Mittente'),
                            Infolists\Components\TextEntry::make('from_email')
                                ->label('Email Mittente')
                                ->copyable()
                                ->icon('heroicon-m-at-symbol'),
                        ]),
                        Infolists\Components\Group::make([
                            Infolists\Components\TextEntry::make('canale.username')
                                ->label('Inviato a (Casella)'),
                            Infolists\Components\TextEntry::make('received_at')
                                ->label('Data Ricezione')
                                ->dateTime('d F Y, H:i:s'),
                        ]),
                        Infolists\Components\Group::make([
                            Infolists\Components\IconEntry::make('is_read')
                                ->label('Stato')
                                ->boolean()
                                ->trueIcon('heroicon-o-check-circle')
                                ->falseIcon('heroicon-o-exclamation-circle')
                                ->trueColor('success')
                                ->falseColor('warning'),
                        ]),
                    ]),
                // Corpo della mail e Oggetto
                Infolists\Components\Section::make('Contenuto Messaggio')
                    ->schema([
                        Infolists\Components\TextEntry::make('subject')
                            ->label('')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->weight('bold'),
                        // Visualizzatore HTML Sicuro
                        Infolists\Components\TextEntry::make('body_html')
                            ->label('')
                            ->html()  // Renderizza l'HTML
                            ->columnSpanFull()
                            ->prose(),  // Migliora la tipografia per la lettura
                    ]),
                // Sezione Allegati (Spatie Media Library)
                Infolists\Components\Section::make('Allegati')
                    ->collapsible()
                    ->collapsed(fn($record) => $record->getMedia('attachments')->isEmpty())
                    ->badge(fn($record) => $record->getMedia('attachments')->count())
                    ->schema([
                        // Per le immagini: anteprima diretta
                        Infolists\Components\SpatieMediaLibraryImageEntry::make('attachments')
                            ->collection('attachments')
                            ->label('Immagini')
                            ->filterMediaUsing(fn($media) => str_starts_with($media->mime_type, 'image/')),
                        // Per i documenti (PDF, Docx, ecc): Lista scaricabile
                        Infolists\Components\RepeatableEntry::make('documenti')
                            ->label('Documenti')
                            ->schema([
                                Infolists\Components\TextEntry::make('file_name')
                                    ->label('File')
                                    ->icon('heroicon-o-document')
                                    ->suffixAction(
                                        Infolists\Components\Actions\Action::make('download')
                                            ->icon('heroicon-o-arrow-down-tray')
                                            ->url(fn($record) => $record->getUrl())
                                            ->openUrlInNewTab()
                                    ),
                                Infolists\Components\TextEntry::make('size')
                                    ->label('Dimensione')
                                    ->formatStateUsing(fn($record) => round($record->size / 1024, 2) . ' KB'),
                            ])
                            // Trucco per iterare sui media che NON sono immagini
                            ->getStateUsing(fn($record) => $record->getMedia('attachments')->reject(fn($m) => str_starts_with($m->mime_type, 'image/'))),
                    ]),
            ]);
    }
}
