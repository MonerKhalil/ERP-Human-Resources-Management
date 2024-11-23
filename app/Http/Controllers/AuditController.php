<?php

namespace App\Http\Controllers;

use App\HelpersClasses\MyApp;
use App\Models\WorkSetting;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuditController extends Controller
{
    public function showAudit($audit){
        $user = auth()->user();
        $audit = $user->notifications()
            ->where("data->type","audit")
            ->where("data->data->audit_id",$audit)
            ->findOrFail();
        return $this->responseSuccess("...",compact("$audit"));
    }

    /**
     * @param Request $request
     * @return Response|RedirectResponse|null
     * @author moner khalil
     */
    public function AllNotificationsAuditUserShow(Request $request): Response|RedirectResponse|null
    {
        $dataFilter = $request->filter;
        $user = auth()->user();
        $queryAudit = $user->notifications()->where("data->type","audit");
        if (!is_null($dataFilter)){
            $idsNotificationsFilter = $queryAudit->get()->map(function ($item) {
                return $this->resolveDataItem($item);
            });
            $idsNotificationsFilter = $idsNotificationsFilter->filter(function ($item) use ($dataFilter) {
                $check = true;
                if (isset($dataFilter['user_name'])) {
                    $check = str_contains($item->data['data']['user_name'], $dataFilter['user_name']);
                }
                if (isset($dataFilter['table_name'])) {
                    $check = $check && str_contains($item->data['data']['table_name'], $dataFilter['table_name']);
                }
                if (isset($dataFilter['event'])) {
                    $check = $check && str_contains($item->data['data']['event'], $dataFilter['event']);
                }
                if (isset($dataFilter['date'])) {
                    $check = $check && str_contains($item->data['data']['date'], $dataFilter['date']);
                }
                return $check;
            })->pluck('id');
            $data = $queryAudit->whereIn("id", $idsNotificationsFilter);
            $data = (isset($dataFilter['start_date']) && !is_null($dataFilter['start_date']) &&
                isset($dataFilter['end_date']) && !is_null($dataFilter['end_date']))
            && ($dataFilter['start_date'] <= $dataFilter['end_date'])
                ? $data->whereBetween('created_at',[$dataFilter['start_date'],$dataFilter['end_date']]) : $data;
        }else{
            $data = $queryAudit;
        }
        $data = MyApp::Classes()->Search->dataPaginate($data);
        if ($data instanceof LengthAwarePaginator){
            $data = $data->through(function ($item) {
                return $this->resolveDataItem($item);
            });
        }else{
           $data = $data->map(function ($item) {
                return $this->resolveDataItem($item);
            });
        }
        return $this->responseSuccess("System.Pages.Actors.Admin.auditing",compact("data"));
    }

    private function resolveDataItem($item){
        $data = $item->data;
        $data['data']['event'] = __($item->data['data']['event']);
        $data['data']['table_name'] = __($item->data['data']['table_name']);
        $data['data']['date'] = Carbon::parse($item->created_at)->diffForHumans();
        $item->data = $data;
        return $item;
    }
}
