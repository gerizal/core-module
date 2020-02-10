<?php

namespace Modules\Core;

use Illuminate\Database\Eloquent\Model;

use Vinkla\Hashids\Facades\Hashids;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class Setting extends Model implements StaplerableInterface
{
    use EloquentTrait;

    protected $guarded  = [];
    protected $table    = 'cwa_settings';
    protected $fillable = [
        'mailchimp_api_key',
        'getresponse_api_key',
        'jvzoo_secret',
        'warriorplus_api_key',
        'warriorplus_security_key',
        'aweber_code',
        'mail_driver',
        'mail_host',
        'mail_port',
        'mail_encryption',
        'mail_username',
        'mail_password',
        'mail_from_name',
        'mail_from_email',
        'application_title',
        'support_link',
        'footer_links',
        'custom_text',
        'allow_public_signup',
        'maintenance_mode',
        'application_logo',
        'master_password',
        'allow_reset_password',
        'allow_change_password',
        'allow_change_email'
    ];

    public function __construct(array $attributes = array())
    {
        $this->hasAttachedFile('application_logo', [
            'styles' => [
                'medium'    => '300x300',
                'thumb'     => '100x100'
            ]
        ]);
        parent::__construct($attributes);
    }

    public function uniqueid()
    {
        $uniqueId   = Hashids::encode($this->id);
        return $uniqueId;
    }

    public static function originalid($value)
    {
        $originalId = Hashids::decode($value)[0];
        return $originalId;
    }

    public static function mail()
    {
        $mailConfiguration = Setting::find(1);
        return $mailConfiguration;
    }
}
