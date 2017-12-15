<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalEntryDetail extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'journalentrydetail';
    protected $fillable = array(
        'id',
        'amount',
        'projectId',
        'journalEntryId',
		'description',
		'accHeadId',
		'isDebit',
        );
}
