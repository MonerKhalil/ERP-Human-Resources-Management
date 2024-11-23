<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;


class Contract extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes#",
        "employee_id", "contract_type", "contract_number", "contract_date", "contract_finish_date",
        "contract_direct_date", "section_id", "salary",
        "created_by", "updated_by", "is_active",
    ];

    // Add relationships between tables section

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    public function section()
    {
        return $this->belongsTo(Sections::class, 'section_id', 'id');
    }

    public function scopeFilter(Builder $builder, $filters)
    {

        $builder->when($filters['first_name'] ?? false, function ($builder, $value) {
            $builder->whereExists(function ($query) use ($value) {
                $query->select("employees.first_name")
                    ->from('employees')
                    ->whereRaw('employees.id = contracts.employee_id')
                    ->where('first_name', $value);
            });
        });

        $builder->when($filters['contract_number'] ?? false, function ($builder, $value) {
            $builder->where('contract_number', '=', $value);
        });
        $builder->when($filters['contract_type'] ?? false, function ($builder, $value) {
            $builder->where('contract_type', '=', "$value");
        });
        $builder->when($filters['contract_date'] ?? false, function ($builder, $value) {
            ////0+1
            $builder->whereBetween('contract_date', [$value[0], $value[1]]);
        });

    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */


    public function validationRules()
    {
        return function (BaseRequest $validator) {
            $contactID = $validator->route('contract') ?? 0;
            return [
                "employee_id" => ['required', Rule::exists('employees', 'id')],
                "section_id" => ['required', Rule::exists('sections', 'id')],
                "contract_type" => ['required',Rule::in(["permanent", "temporary"])],
                "contract_date" =>$validator->dateRules(true),
                "contract_direct_date" => $validator->afterDateOrNowRules(true,"contract_date"),
                "contract_finish_date" => $validator->afterDateOrNowRules(true,"contract_finish_date"),
                "contract_number" => ['required', 'min:0',
                    'max:1000000', Rule::unique('contracts', 'contract_number')->ignore($contactID)],
                "salary" => ['required', 'numeric',"min:1"],
            ];
        };
    }
}
