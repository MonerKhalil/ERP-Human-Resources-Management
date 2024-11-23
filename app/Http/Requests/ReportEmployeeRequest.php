<?php

namespace App\Http\Requests;

use App\Models\EvaluationMember;
use Illuminate\Validation\Rule;

class ReportEmployeeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "section_id" => ["nullable","array"],
            "section_id.*" => [Rule::exists("sections","id")],
            "education_level_id" => ["nullable","array"],
            "education_level_id.*" => [Rule::exists("education_levels","id")],
            "membership_type_id" => ["nullable","array"],
            "membership_type_id.*" => [Rule::exists("membership_types","id")],
            "position_id" => ["nullable","array"],
            "position_id.*" => [Rule::exists("positions","id")],
            "type_decision_id" => ["nullable","array"],
            "type_decision_id.*" => [Rule::exists("type_decisions","id")],
            "languages" => ["nullable","array"],
            "languages.*" => [Rule::requiredIf(function (){
                return !is_null($this->input("languages"));
            }),"array"],
            "languages.*.language_id" => [Rule::requiredIf(function (){
                return !is_null($this->input("languages"));
            }),Rule::exists("languages","id")],
            "languages.*.language_read" => ["nullable",Rule::in(["Beginner","Intermediate","Advanced"])],
            "languages.*.language_write" => ["nullable",Rule::in(["Beginner","Intermediate","Advanced"])],

            "evaluations" => ["nullable","array"],
            "evaluations.*" => [Rule::requiredIf(function (){
                return !is_null($this->input("evaluations"));
            }),"array"],
            "evaluations.*.evaluation" => [Rule::requiredIf(function (){
                return !is_null($this->input("evaluations"));
            }),Rule::in(EvaluationMember::typeEvaluation())],
            "evaluations.*.value" => [Rule::requiredIf(function (){
                return !is_null($this->input("evaluations"));
            }),"integer","min:1","max:10"],

            "family_status" => ["nullable","array"],
            "family_status.*" => [Rule::in(["married","divorced","single"])],
            "contract_type" => ['nullable', Rule::in(["permanent", "temporary","all"])],
            "gender" => ["nullable",Rule::in(["male","female"])],
            "current_job" => ["nullable","string"],
            "from_end_break_date" => $this->dateRules(false),
            "to_end_break_date" => $this->afterDateOrNowRules(false,"from_end_break_date"),
            "from_birth_date" => $this->dateRules(false),
            "to_birth_date" => $this->afterDateOrNowRules(false,"from_birth_date"),
            "from_contract_direct_date" => $this->dateRules(false),
            "to_contract_direct_date" => $this->afterDateOrNowRules(false,"from_contract_direct_date"),
            "from_conference_date" => $this->dateRules(false),
            "to_conference_date" => $this->afterDateOrNowRules(false,"from_conference_date"),
            "from_decision_date" => $this->dateRules(false),
            "to_decision_date" => $this->afterDateOrNowRules(false,"from_decision_date"),
            'from_salary' => ['nullable','numeric','min:1'],
            'to_salary' => ['nullable','numeric','min:'.$this->input('from_salary')],
            'salary' => ['nullable','numeric'],
        ];
    }
}
