<?php

namespace VentureDrake\LaravelCrm\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use VentureDrake\LaravelCrm\Traits\BelongsToTeams;
use VentureDrake\LaravelCrm\Traits\HasCrmActivities;
use VentureDrake\LaravelCrm\Traits\HasCrmFields;
use VentureDrake\LaravelCrm\Traits\HasGlobalSettings;
use VentureDrake\LaravelCrm\Traits\SearchFilters;
//use VentureDrake\LaravelEncryptable\Traits\LaravelEncryptableTrait;

class Person extends Model
{
    use SoftDeletes;
    //use LaravelEncryptableTrait;
    use BelongsToTeams;
    use HasCrmFields;
    use SearchFilters;
    use Sortable;
    use HasCrmActivities;
    use HasGlobalSettings;

    protected $guarded = ['id'];

    protected $encryptable = [
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'maiden_name',
        'document_national',
        'document_passport' ,
        'document_driving_license', 
        'document_national_country',  
        'document_passport_country',  
        'document_driving_license_country',  
    ];

    protected $searchable = [
        'first_name',
        'middle_name',
        'last_name',
        'maiden_name',
        'document_national',
        'document_passport' ,
        'document_driving_license', 
        'document_national_country',  
        'document_passport_country',  
        'document_driving_license_country',  
        'document_national_issued' ,
        'document_passport_issued', 
        'document_driving_license_issued' ,
        'document_national_expiration' ,
        'document_passport_expiration' ,
        'document_driving_license_expiration'
    ];

    protected $filterable = [
        'user_owner_id',
        'labels.id',
    ];

    public $sortable = [
        'id',
        'first_name',
        'last_name',
        'document_national',
        'document_passport' ,
        'document_driving_license', 
        'document_national_country',  
        'document_passport_country',  
        'document_driving_license_country',  
        'document_national_issued' ,
        'document_passport_issued', 
        'document_driving_license_issued' ,
        'document_national_expiration' ,
        'document_passport_expiration' ,
        'document_driving_license_expiration',
        'created_at',
        'updated_at',
    ];

    public function getSearchable()
    {
        return $this->searchable;
    }

    public function getTable()
    {
        return config('laravel-crm.db_table_prefix').'people';
    }

    public function getNameAttribute()
    {
        return trim($this->first_name.' '.$this->last_name);
    }

    public function setBirthdayAttribute($value)
    {
       
        if ($value) {
            $this->attributes['birthday'] = Carbon::createFromFormat($this->dateFormat(), $value);
        }
    }

    public function getBirthdayAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format($this->dateFormat());
        }
    }
    //NEW FIELDS
    public function setDocumentNationalIssuedAttribute($value)
    {
        if ($value) {
            $this->attributes['document_national_issued'] = Carbon::createFromFormat($this->dateFormat(), $value);
        }
    }
    
    public function getDocumentNationalIssuedAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format($this->dateFormat());
        }
    }
    public function setDocumentPassportIssuedAttribute($value)
    {
        if ($value) {
            $this->attributes['document_passport_issued'] = Carbon::createFromFormat($this->dateFormat(), $value);
        }
    }

    public function getDocumentPassportIssuedAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format($this->dateFormat());
        }
    }
    public function setDocumentDrivingLicenseIssuedAttribute($value)
    {
        if ($value) {
            $this->attributes['document_driving_license_issued'] = Carbon::createFromFormat($this->dateFormat(), $value);
        }
    }
    public function setDocumentNationalExpirationAttribute($value)
    {
        if ($value) {
            $this->attributes['document_national_expiration'] = Carbon::createFromFormat($this->dateFormat(), $value);
        }
    }
    public function setDocumentPassportExpirationAttribute($value)
    {
        if ($value) {
            $this->attributes['document_passport_expiration'] = Carbon::createFromFormat($this->dateFormat(), $value);
        }
    }

    public function getDocumentPassportExpirationAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format($this->dateFormat());
        }
    }


    public function getDocumentNationalExpirationAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format($this->dateFormat());
        }
    }

    
    public function getDocumentDrivingLicenseIssuedAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format($this->dateFormat());
        }
    }
    public function setDocumentDrivingLicenseExpirationAttribute($value)
    {
        if ($value) {
            $this->attributes['document_driving_license_expiration'] = Carbon::createFromFormat($this->dateFormat(), $value);
        }
    }

    public function getDocumentDrivingLicenseExpirationAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format($this->dateFormat());
        }
    }


    public function getFirstNameDecryptedAttribute()
    {
        return $this->decryptField($this->first_name);
    }

    /**
     * Get all of the persons emails.
     */
    public function emails()
    {
        return $this->morphMany(\VentureDrake\LaravelCrm\Models\Email::class, 'emailable');
    }

    public function getPrimaryEmail()
    {
        return $this->emails()->where('primary', 1)->first();
    }

    public function getEmail()
    {
        return $this->emails()->first();
    }

    /**
     * Get all of the persons phone numbers.
     */
    public function phones()
    {
        return $this->morphMany(\VentureDrake\LaravelCrm\Models\Phone::class, 'phoneable');
    }

    public function getPrimaryPhone()
    {
        return $this->phones()->where('primary', 1)->first();
    }

    /**
     * Get all of the leads addresses.
     */
    public function addresses()
    {
        return $this->morphMany(\VentureDrake\LaravelCrm\Models\Address::class, 'addressable');
    }

    public function getPrimaryAddress()
    {
        return $this->addresses()->where('primary', 1)->first();
    }

    public function organisation()
    {
        return $this->belongsTo(\VentureDrake\LaravelCrm\Models\Organisation::class);
    }

    public function deals()
    {
        return $this->hasMany(\VentureDrake\LaravelCrm\Models\Deal::class);
    }

    public function createdByUser()
    {
        return $this->belongsTo(\App\User::class, 'user_created_id');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(\App\User::class, 'user_updated_id');
    }

    public function deletedByUser()
    {
        return $this->belongsTo(\App\User::class, 'user_deleted_id');
    }

    public function restoredByUser()
    {
        return $this->belongsTo(\App\User::class, 'user_restored_id');
    }

    public function ownerUser()
    {
        return $this->belongsTo(\App\User::class, 'user_owner_id');
    }

    /**
     * Get all of the labels for the person.
     */
    public function labels()
    {
        return $this->morphToMany(\VentureDrake\LaravelCrm\Models\Label::class, config('laravel-crm.db_table_prefix').'labelable');
    }

    public function contacts()
    {
        return $this->morphMany(\VentureDrake\LaravelCrm\Models\Contact::class, 'contactable');
    }

    /**
     * Get the xero person associated with the person.
     */
    public function xeroPerson()
    {
        return $this->hasOne(\VentureDrake\LaravelCrm\Models\XeroPerson::class);
    }
}
