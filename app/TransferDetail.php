<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferDetail extends Model
{
    public $table="transfer_details";

    protected $fillable=['product_id','transfer_notes_id','from_warehouse_quantity','to_warehouse_id','to_warehouse_quantity','warehouse_name','created_at','updated_at'];
}
