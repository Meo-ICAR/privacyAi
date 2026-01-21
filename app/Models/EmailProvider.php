<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EmailProvider extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'email_providers';

    protected $fillable = [
        'name',
        'display_name',
        'type',
        'icon',
        'color',
        'imap_host',
        'imap_port',
        'imap_encryption',
        'pop3_host',
        'pop3_port',
        'pop3_encryption',
        'smtp_host',
        'smtp_port',
        'smtp_encryption',
        'smtp_auth_required',
        'api_endpoint',
        'api_version',
        'oauth_client_id',
        'oauth_client_secret',
        'oauth_redirect_uri',
        'oauth_scopes',
        'timeout',
        'verify_ssl',
        'auth_type',
        'settings',
        'is_active',
        'description',
        'setup_instructions',
    ];

    protected $casts = [];
}
