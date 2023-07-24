<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTable extends Model
{
    use HasFactory;

    protected $table = 'customer_table';
    
	protected $fillable = [
		'name',
		'department'
	];

    public static $fields = [
        'name',
        'department'
    ];

    public static $validate = [
        'name'=>'required',
        'department' => 'required'
    ];
}
