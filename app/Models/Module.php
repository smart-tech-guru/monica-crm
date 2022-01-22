<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;

    /**
     * Possible module types.
     */
    const TYPE_NOTES = 'notes';
    const TYPE_CONTACT_NAMES = 'contact_names';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'name',
        'type',
        'can_be_deleted',
    ];

    /**
     * Get the account associated with the template.
     *
     * @return BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the template pages associated with the module.
     *
     * @return BelongsToMany
     */
    public function templatePages()
    {
        return $this->belongsToMany(TemplatePage::class, 'module_template_page')->withTimestamps();
    }
}