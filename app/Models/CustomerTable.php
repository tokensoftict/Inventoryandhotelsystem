<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\CustomerTableStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerTable
 *
 * @property int $id
 * @property string $name
 * @property string $department
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|InvoiceItemBatch[] $invoice_item_batches
 * @property Collection|InvoiceItem[] $invoice_items
 * @property Collection|Invoice[] $invoices
 * @property Collection|PaymentMethodTable[] $payment_method_tables
 * @property Collection|Payment[] $payments
 *
 * @package App\Models
 */
class CustomerTable extends Model
{
    protected $table = 'customer_tables';

    protected $fillable = [
        'name',
        'department',
        'status'
    ];


    protected $casts = [
        'status' => CustomerTableStatus::class
    ];

    public static $fields = [
        'name',
        'department'
    ];

    public static $validate = [
        'name'=>'required',
        'department' => 'required'
    ];

    public static function getAvailableTable($invoice = null)
    {
        $user = auth()->user();

        if(in_array($user->group_id, [1,2])) {
            $tables =self::where(function($query){
                $query->orWhere('status', CustomerTableStatus::Available)
                    ->orWhere('status', CustomerTableStatus::Occupied);
            });
        }else{
            $tables =  self::where('department', $user->department)->where(function($query){
                $query->orWhere('status', CustomerTableStatus::Available)
                    ->orWhere('status', CustomerTableStatus::Occupied);
            });
        }

        return $tables->get();
    }


    public static function setTableStatus($id, $status)
    {
        $table = self::find($id);
        $table->status = $status;
        $table->update();
    }

    public function invoice_item_batches()
    {
        return $this->hasMany(InvoiceItemBatch::class);
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payment_method_tables()
    {
        return $this->hasMany(PaymentMethodTable::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


}
