<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class DataAllEmployeeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     * @author moner khalil
     */
    public function rules()
    {
        $formRequests = [
            EmployeeRequest::class,
            Education_dataRequest::class,
            Document_educationRequest::class,
            ContactRequest::class,
            DocumentContactRequest::class,
        ];

        $rules = [];

        foreach ($formRequests as $source) {
            $rules = array_merge(
                $rules,
                (new $source)->rules()
            );
        }

        return $rules;
    }

    public function employeeData(){
        return [
                "work_setting_id" => $this->work_setting_id,
                "user_id" => $this->user_id,
                "section_id" => $this->section_id,
                "nationality" => $this->nationality,
                "number_national" => $this->number_national,
                "number_file" => $this->number_file,
                "number_insurance" => $this->number_insurance,
                "number_self" => $this->number_self,
                "first_name" => $this->first_name,
                "last_name" => $this->last_name,
                "father_name" => $this->father_name,
                "mother_name" => $this->mother_name,
                "NP_registration" => $this->NP_registration,
                "birth_place" => $this->birth_place,
                "current_job" => $this->current_job,
                "job_site" => $this->job_site,
                "gender" => $this->gender,
                "military_service" => $this->military_service,
                "reason_exemption" => $this->reason_exemption,
                "family_status" => $this->family_status,
                "number_wives" => $this->number_wives,
                "number_child" => $this->number_child,
                "birth_date" => $this->birth_date,
            ];
    }

    public function contactDate(){
        return [
            "address_id" => $this->address_id ,
            "work_number" => $this->work_number,
            "address_details" => $this->address_details,
            "private_number1" => $this->private_number1,
            "private_number2" => $this->private_number2,
            "email" => $this->email,
            "address_type"=> $this->address_type,
        ];
    }

    public function educationData(){
        return [
            "id_ed_lev" => $this->id_ed_lev,
            "grant_date"=> $this->grant_date,
            "college_name"=> $this->college_name,
            "amount_impact_salary"=>$this->amount_impact_salary,
        ];
    }
}
