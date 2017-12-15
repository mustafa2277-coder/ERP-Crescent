<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalEntries extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'journalentries';
    protected $fillable = array(
        'id',
        'journalId',
        'projectId',
        'description',
        'date_post',
        'reference',
        'entryNum',
        );
}
