<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tableinvoicelog
 * 
 * @property int $id
 * @property int $customer_table_id
 * @property Carbon $sales_date
 * @property array|null $invoice_id
 * @property int|null $user_id
 * @property float|null $total_table_invoice
 * @property float|null $total_paid
 * @property int|null $payment_method_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property CustomerTable $customer_table
 * @property PaymentMethod|null $payment_method
 * @property User|null $user
 *
 * @package App\Models
 */
class Tableinvoicelog extends Model
{
	protected $table = 'tableinvoicelogs';

	protected $casts = [
		'customer_table_id' => 'int',
		'invoice_id' => 'json',
		'user_id' => 'int',
		'total_table_invoice' => 'float',
		'total_paid' => 'float',
		'payment_method_id' => 'int'
	];

	protected $dates = [
		'sales_date'
	];

	protected $fillable = [
		'customer_table_id',
		'sales_date',
		'invoice_id',
		'user_id',
		'total_table_invoice',
		'total_paid',
		'payment_method_id'
	];

	public function customer_table()
	{
		return $this->belongsTo(CustomerTable::class);
	}

	public function payment_method()
	{
		return $this->belongsTo(PaymentMethod::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
