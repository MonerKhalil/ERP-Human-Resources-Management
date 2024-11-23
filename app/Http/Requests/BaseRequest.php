<?php

namespace App\Http\Requests;

use App\Rules\TextRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public $rule = "required";

    /**
     * @return bool
     */
    public function isUpdatedRequest(): bool
    {
        $Final = false;
        $routeName = is_null($this->route()) ? "" : $this->route()->getName();
        if (!is_null($routeName)){
            $Final = is_numeric(strpos($routeName, "update")) || is_numeric(strpos($routeName, "edit"));
        }
        return request()->isMethod("PUT") || $Final;
    }

    /**
     * @param bool|null $isReq
     * @return string
     */
    public function imageRule(bool $isReq = null): string
    {
        if (!is_null($isReq)) {
            $this->rule = $isReq ? 'required' : 'sometimes';
        }

        if ($this->isUpdatedRequest()) {
            $this->rule = 'sometimes';
        }
        return "$this->rule|mimes:jpeg,png,jpg,gif,svg|max:256";
    }

    /**
     * @param bool|null $isReq
     * @return string
     */
    public function dateRules(bool $isReq = null): string
    {
        if (!is_null($isReq)) {
            $this->rule = $isReq ? 'required' : 'nullable';
        }

        return "$this->rule|date";
    }

    /**
     * @param bool|null $isReq
     * @param string|null $afterDateKey
     * @return string
     */
    public function afterDateOrNowRules(bool $isReq = null, string $afterDateKey = null): string
    {
        $rule = $this->dateRules($isReq);
        return is_null($afterDateKey) ?
            $rule . "|after_or_equal:now" : $rule . "|after_or_equal:" . $afterDateKey;
    }

    /**
     * @param bool|null $isReq
     * @return string
     */
    public function fileRules(bool $isReq = null): string
    {
        if (!is_null($isReq)) {
            $this->rule = $isReq ? 'required' : 'sometimes';
        }

        if ($this->isUpdatedRequest()) {
            $this->rule = 'sometimes';
        }

        return "$this->rule|mimes:pdf,docx|max:10000";
    }

    /**
     * @description string without in TextRule Class
     * add char.. /-
     * @param bool|null $isRequired
     * @param bool|null $isNullable
     * @param null $min
     * @param null $max
     * @return array
     * @author moner khalil
     */
    public function textRule(bool $isRequired = null, bool $isNullable = null, $min = null, $max = null)
    {
        $temp_rules = [];
        if (!is_null($isRequired)) {
            $temp_rules[] = $isRequired ? "required" : "nullable";
        }
        $temp_rules[] = "string";
        $temp_rules[] = new TextRule();
        return $this->min_max_Rule($temp_rules, $min, $max);
    }

    /**
     * @param $tempRule
     * @param $min
     * @param $max
     * @return mixed
     * @author moner khalil
     */
    private function min_max_Rule($tempRule, $min, $max): mixed
    {
        if ($min !== null && $max === null) {
            $tempRule[] = "min:" . $min;
        } elseif ($max !== null && $min === null) {
            $tempRule[] = "max:" . $max;
        } elseif ($max !== null && $min !== null) {
            $tempRule[] = "min:" . $min;
            $tempRule[] = "max:" . $max;
        }else{
            $tempRule[]="min:1";
            $tempRule[]="max:255";
        }
        return $tempRule;
    }

    public function rules()
    {
        return [];
    }
}
