<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            [
                'id' => 1,
                'name' => 'gmail',
                'display_name' => 'Gmail',
                'type' => 'gmail_api',
                'icon' => 'gmail.png',
                'color' => '#EA4335',
                'imap_host' => 'imap.gmail.com',
                'imap_port' => 993,
                'imap_encryption' => 'ssl',
                'smtp_host' => 'smtp.gmail.com',
                'smtp_port' => 587,
                'smtp_encryption' => 'tls',
                'oauth_redirect_uri' => 'https://privacycall.hassisto.com/auth/google/callback',
                'oauth_scopes' => json_encode([
                    'https://www.googleapis.com/auth/gmail.readonly',
                    'https://www.googleapis.com/auth/gmail.send',
                    'https://www.googleapis.com/auth/gmail.modify'
                ]),
                'auth_type' => 'oauth',
                'description' => 'Google Gmail with OAuth2 authentication',
                'setup_instructions' => 'To use Gmail, you need to enable 2-factor authentication and create an App Password, or use OAuth2 authentication.',
            ],
            [
                'id' => 2,
                'name' => 'microsoft',
                'display_name' => 'Microsoft 365 / Outlook',
                'type' => 'microsoft_graph',
                'icon' => 'microsoft.png',
                'color' => '#0078D4',
                'imap_host' => 'outlook.office365.com',
                'imap_port' => 993,
                'imap_encryption' => 'ssl',
                'smtp_host' => 'smtp.office365.com',
                'smtp_port' => 587,
                'smtp_encryption' => 'tls',
                'oauth_redirect_uri' => 'https://privacycall.hassisto.com/auth/microsoft/callback',
                'oauth_scopes' => json_encode([
                    'https://graph.microsoft.com/Mail.Read',
                    'https://graph.microsoft.com/Mail.Send',
                    'https://graph.microsoft.com/Mail.ReadWrite'
                ]),
                'auth_type' => 'oauth',
                'description' => 'Microsoft 365 and Outlook.com with Microsoft Graph API',
                'setup_instructions' => 'To use Microsoft 365, you need to register an application in Azure AD.',
            ],
            [
                'id' => 3,
                'name' => 'ovh',
                'display_name' => 'OVH',
                'type' => 'imap',
                'icon' => 'ovh.png',
                'color' => '#123F6D',
                'imap_host' => 'ssl0.ovh.net',
                'imap_port' => 993,
                'imap_encryption' => 'ssl',
                'pop3_host' => 'ssl0.ovh.net',
                'pop3_port' => 995,
                'pop3_encryption' => 'ssl',
                'smtp_host' => 'ssl0.ovh.net',
                'smtp_port' => 587,
                'smtp_encryption' => 'tls',
                'auth_type' => 'password',
                'description' => 'OVH email hosting with IMAP/POP3/SMTP support',
                'setup_instructions' => 'Use your OVH email address and password.',
            ],
            [
                'id' => 4,
                'name' => 'aruba',
                'display_name' => 'Aruba',
                'type' => 'imap',
                'icon' => 'aruba.png',
                'color' => '#00A3E0',
                'imap_host' => 'imaps.aruba.it',
                'imap_port' => 993,
                'imap_encryption' => 'ssl',
                'pop3_host' => 'pop3.aruba.it',
                'pop3_port' => 995,
                'pop3_encryption' => 'ssl',
                'smtp_host' => 'smtps.aruba.it',
                'smtp_port' => 587,
                'smtp_encryption' => 'ssl',
                'auth_type' => 'password',
                'description' => 'Aruba email hosting with IMAP/POP3/SMTP support',
                'setup_instructions' => 'Use your Aruba email address and password.',
            ],
            [
                'id' => 7,
                'name' => 'custom',
                'display_name' => 'Custom IMAP',
                'type' => 'imap',
                'icon' => 'custom.png',
                'color' => '#6B7280',
                'auth_type' => 'password',
                'description' => 'Custom IMAP server configuration',
                'setup_instructions' => 'Enter your custom IMAP server details manually.',
            ]
        ];

        foreach ($providers as $provider) {
            DB::table('email_providers')->updateOrInsert(['id' => $provider['id']], $provider);
        }
    }
}
