<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        "expense_type_id",
        "vehicle_id",
        "employee_id",
        "amount",
        "paid_date",
        "remark",
        "file",
        "created_by",
        "updated_by",
    ];

    protected $casts = [
        "paid_date" => "date",
        "amount" => "decimal:2",
    ];

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
