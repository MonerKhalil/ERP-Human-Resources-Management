<?php

namespace App\Http\Controllers;

use App\Exports\TableCustomExport;
use App\HelpersClasses\MyApp;
use App\Http\Requests\ReportEmployeeRequest;
use App\Models\Education_level;
use App\Models\Employee;
use App\Models\Language;
use App\Models\Membership_type;
use App\Models\Position;
use App\Models\Sections;
use App\Models\TypeDecision;
use Maatwebsite\Excel\Facades\Excel;

class ReportEmployeeController extends Controller
{
    private $finalQueryFilter;

    public function __construct()
    {
        $table = app(Employee::class)->getTable();
        $this->middleware(["permission:read_".$table."|all_".$table])->only(["showCreateReport","Report"]);
        $this->middleware(["permission:export_".$table."|all_".$table])->only(["ReportXlsx","ReportPdf"]);
        $this->finalQueryFilter = Employee::query();
    }

    public function showCreateReport(){
        $sections = Sections::query()->pluck("name","id")->toArray();
        $gender = ["male","female"];
        $family_status = ["married","divorced","single"];
        $contract_type = ["permanent", "temporary","all"];
        $education_level = Education_level::query()->pluck("name","id")->toArray();
        $language_skills_read_write = ["Beginner","Intermediate","Advanced"];
        $language = Language::query()->pluck("name","id")->toArray();
        $membership_type = Membership_type::query()->pluck("name","id")->toArray();
        $position = Position::query()->pluck("name","id")->toArray();
        $type_decision = TypeDecision::query()->pluck("name","id")->toArray();
        return $this->responseSuccess("System/Pages/Actors/Reports/reportEmployeesForm"
            ,compact("sections","gender",
            "contract_type","education_level","language","language_skills_read_write","membership_type"
            ,"position","type_decision","family_status"
        ));
    }

    public function Report(ReportEmployeeRequest $request){
        $dataSelected = array_filter($request->validated(),function($var){return !is_null($var);});
        $finalData = MyApp::Classes()->Search->dataPaginate($this->MainQueryReport($request));
        return $this->responseSuccess("System/Pages/Actors/Reports/reportEmployeesView"
            ,compact("finalData","dataSelected"));
    }

    public function ReportPdf(ReportEmployeeRequest $request){
        $dataSelected = array_filter($request->validated(),function($var){return !is_null($var);});
        $query = $this->MainQueryReport($request);
        $finalData = isset($request->ids) && is_array($request->ids) ?
            $query->whereIn("id",$request->ids) : $query;
        $finalData = $finalData->get();
        return $this->responseSuccess("System/Pages/Docs/reportPrint"
            ,compact("finalData","dataSelected"));
    }

    public function ReportXlsx(ReportEmployeeRequest $request){
        $data = $this->ExportXlsxData($request);
        $dataSelected = array_filter($request->validated(),function($var){return !is_null($var);});
        return Excel::download(new TableCustomExport($data['head'],$data['body'],"ReportEmployeeFinal",["dataSelected"=>$dataSelected]),"ReportEmployee.xlsx");
    }

    private function ExportXlsxData(ReportEmployeeRequest $request): array
    {
        $query = $this->MainQueryReport($request);
        $query = isset($request->ids) && is_array($request->ids) ?
            $query->whereIn("id",$request->ids) : $query;
        $data = $query->get();
        $head = [
            [
                "head"=> "department",
                "relationFunc" => "section",
                "key" => "name",
            ],
            "name",
            [
                "head"=> "nationality",
                "relationFunc" => "nationality_country",
                "key" => "country_name",
            ],
            "NP_registration","number_national","number_self","gender","current_job","military_service", "family_status","birth_date",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }

    private function MainQueryReport($request){
        //Sections
        $this->finalQueryFilter = !is_null($request->section_id) ?
            $this->finalQueryFilter->whereIn("section_id",$request->section_id) : $this->finalQueryFilter;
        //Contract
        $this->finalQueryFilter = $this->queryContract($request);
        //Decision
        $this->finalQueryFilter = $this->queryDecision($request);
        //EducationLevel
        $this->finalQueryFilter = !is_null($request->education_level_id) ?
            $this->finalQueryFilter
                ->whereHas("education_data",function ($q)use($request){
                    $q->whereIn("id_ed_lev",$request->education_level_id);
                },"=",count($request->education_level_id)) : $this->finalQueryFilter;
        //MembershipType
        $this->finalQueryFilter = !is_null($request->membership_type_id) ?
            $this->finalQueryFilter
                ->whereHas("membership",function ($q)use($request){
                    $q->whereIn("member_type_id",$request->membership_type_id);
                },"=",count($request->membership_type_id)) : $this->finalQueryFilter;
        //Position
        $this->finalQueryFilter = !is_null($request->position_id) ?
            $this->finalQueryFilter->with("positions")
                ->whereHas("positions",function ($q)use($request){
                    $q->whereIn("position_id",$request->position_id);
                }) : $this->finalQueryFilter;
        //Conference
        $this->finalQueryFilter = $this->CompareDateStatic($request->from_conference_date,$request->to_conference_date,
            "start_date","conferences");
        //DataEndService
        $this->finalQueryFilter = $this->CompareDateStatic($request->from_end_break_date,$request->to_end_break_date
            ,"end_break_date","data_end_service");
        //BarthDate
        $this->finalQueryFilter = $this->CompareDateStatic($request->from_birth_date,$request->to_birth_date,"birth_date");
        //Gender
        $this->finalQueryFilter = !is_null($request->gender) ?
            $this->finalQueryFilter->where("gender",$request->gender) : $this->finalQueryFilter;
        //FamilyStatus
        $this->finalQueryFilter = !is_null($request->family_status) ?
            $this->finalQueryFilter->whereIn("family_status",$request->family_status) : $this->finalQueryFilter;
        //CurrentJob
        $this->finalQueryFilter = !is_null($request->current_job) ?
            $this->finalQueryFilter->where("current_job","LIKE","%".$request->current_job."%") : $this->finalQueryFilter;
        //LanguageSkill
        $this->finalQueryFilter = $this->queryLanguageSkills($request);
        //Evaluations
        $this->finalQueryFilter = $this->queryEvaluations($request);

        return $this->finalQueryFilter->orderBy("id","desc");
    }

    private function CompareDateStatic($from_date,$to_date,$name_column,$relation = null){
        if (!is_null($from_date) && !is_null($to_date)){
            $from_date = MyApp::Classes()->stringProcess->DateFormat($from_date);
            $to_date = MyApp::Classes()->stringProcess->DateFormat($to_date);
            if (is_string($from_date) && is_string($to_date) && ($from_date <= $to_date)){
                $compareTwoDate = [$from_date,$to_date];
                if (!is_null($relation)){
                    $this->finalQueryFilter = $this->finalQueryFilter->with($relation)
                        ->whereHas($relation,function ($q) use ($from_date,$to_date,$name_column,$compareTwoDate){
                            $q->whereBetween($name_column,$compareTwoDate);
                        });
                }else{
                    $this->finalQueryFilter = $this->finalQueryFilter->whereBetween($name_column,$compareTwoDate);
                }
            }
        }
        return $this->finalQueryFilter;
    }

    private function queryLanguageSkills($request){
        if (!is_null($request->languages)){
            $employees = $this->finalQueryFilter->pluck("id")->toArray();
            foreach ($request->languages as $language){
                $employees = Employee::query()->whereHas("language_skill",function ($q) use ($language){
                    $q->where("language_id",$language['language_id'])
                        ->when(isset($language['language_write']),function ($q) use($language){
                            $q->where("write",$language['language_write']);
                        })
                        ->when(!is_null($language['language_read']),function ($q) use($language){
                            $q->where("read",$language['language_read']);
                        });
                })->whereIn("id",$employees)->pluck("id")->toArray();
            }
            return $this->finalQueryFilter->with("language_skill")->whereIn("id",$employees);
        }
        return $this->finalQueryFilter;
    }

    private function queryContract($request){
        $from_date = $request->from_contract_direct_date ?? "";
        $to_date = $request->to_contract_direct_date ?? "";
        $from_date = MyApp::Classes()->stringProcess->DateFormat($from_date);
        $to_date = MyApp::Classes()->stringProcess->DateFormat($to_date);
        if ( (!is_null($request->contract_type))
            ||
            (!is_null($request->from_salary) && !is_null($request->to_salary))
            ||
            (!is_null($request->salary))
            ||
            (is_string($from_date) && is_string($to_date) && ($from_date <= $to_date))
        ){
            $this->finalQueryFilter = $this->finalQueryFilter->with("contract")
                ->whereHas("contract",function ($q) use ($request,$from_date,$to_date){
                    //ContractType
                    if (!is_null($request->contract_type)){
                        $temp = $request->contract_type;
                        $temp = $request->contract_type === "all" ? ["permanent", "temporary"] : [$temp];
                        $q = $q->whereIn("contract_type",$temp);
                    }
                    //Salary
                    if ((!is_null($request->from_salary) && !is_null($request->to_salary))){
                        $q = $q->whereBetween("salary",[$request->from_salary,$request->to_salary]);
                    }
                    if (!is_null($request->salary)){
                        $q = $q->where("salary","<=",$request->salary);
                    }
                    if ((is_string($from_date) && is_string($to_date) && ($from_date <= $to_date))){
                        $compareTwoDate = [$from_date,$to_date];
                        $q->whereBetween("contract_direct_date",$compareTwoDate);
                    }
                });
        }
        return $this->finalQueryFilter;
    }

    private function queryDecision($request){
        $from_date = $request->from_decision_date ?? "";
        $to_date = $request->to_decision_date ?? "";
        $from_date = MyApp::Classes()->stringProcess->DateFormat($from_date);
        $to_date = MyApp::Classes()->stringProcess->DateFormat($to_date);
        if (!is_null($request->type_decision_id)
            &&
            (is_string($from_date) && is_string($to_date) && ($from_date <= $to_date))
        ){
            $this->finalQueryFilter = $this->finalQueryFilter->with("decision_employees")
                ->whereHas("decision_employees",function ($q) use ($request,$from_date,$to_date){
                    $compareTwoDate = [$from_date,$to_date];
                    $q->whereBetween("date",$compareTwoDate)
                        ->whereIn("type_decision_id",$request->type_decision_id);
                },"=",count($request->type_decision_id));
        }elseif (!is_null($request->type_decision_id)){
            $this->finalQueryFilter = $this->finalQueryFilter->with("decision_employees")
                ->whereHas("decision_employees",function ($q) use ($request){
                    $q->whereIn("type_decision_id",$request->type_decision_id);
                },"=",count($request->type_decision_id));
        }elseif ((is_string($from_date) && is_string($to_date) && ($from_date <= $to_date))){
            $this->finalQueryFilter = $this->finalQueryFilter->with("decision_employees")
                ->whereHas("decision_employees",function ($q) use ($request,$from_date,$to_date){
                    $compareTwoDate = [$from_date,$to_date];
                    $q->whereBetween("date",$compareTwoDate);
                });
        }
        return $this->finalQueryFilter;
    }

    private function queryEvaluations($request){
        if (!is_null($request->evaluations)){
            $this->finalQueryFilter = $this->finalQueryFilter->with("evaluation")->whereHas("evaluation",function ($q) use ($request){
                return $q->whereHas("enter_evaluation_employee",function ($q) use ($request){
                    foreach ($request->evaluations as $evaluation) {
                        $q = $q->where($evaluation["evaluation"],">=",$evaluation["value"]);
                    }
                    return $q;
                });
            });
        }
        return $this->finalQueryFilter;
    }
}
