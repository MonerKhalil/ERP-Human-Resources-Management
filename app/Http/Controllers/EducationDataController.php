<?php

namespace App\Http\Controllers;


use App\Exceptions\MainException;
use App\HelpersClasses\MessagesFlash;
use App\HelpersClasses\MyApp;
use App\Http\Requests\Document_educationRequest;
use App\Http\Requests\Education_dataRequest;
use App\Models\Document_education;
use App\Models\Education_data;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\UnauthorizedException;

class EducationDataController extends Controller
{
    /**
     * @param Education_dataRequest $request
     * @param $education_data
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|null
     * @author moner khalil
     */
    public function updateEducationData(Education_dataRequest $request , $education_data)
    {
        $education_data = Education_data::query()->findOrFail($education_data);
        if (!$education_data->canEdit()){
            throw UnauthorizedException::forPermissions(["update_employees"]);
        }
        $education_data->update($request->validated());
        return $this->responseSuccess(null,null,"update",null,true);
    }

    /**
     * @throws MainException
     */
    public function addEducationDocument(Document_educationRequest $request, $education_data){
        try {
            $education_data = Education_data::query()->findOrFail($education_data);
            if (!$education_data->canEdit()){
                throw UnauthorizedException::forPermissions(["update_employees"]);
            }
            DB::beginTransaction();
            if (!is_null($request->document_education_path)){
                foreach ($request->document_education_path as $item){
                    $temp = $item;
                    $temp = MyApp::Classes()->storageFiles
                        ->Upload($temp,"employees/document_contact");
                    $education_data->document_education()->create([
                        "document_education_path" => $temp,
                    ]);
                }
            }
            DB::commit();
            return $this->responseSuccess(null,null,"create",null,true);
        }catch (\Exception $exception){
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }


    /**
     * @param Document_educationRequest $request
     * @param $education_document
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|null
     * @throws MainException
     * @author moner khalil
     */
    public function updateEducationDocument(Document_educationRequest $request, $education_document){
        $education_document = Document_education::query()->findOrFail($education_document);
        if (!($education_document->document_education()->canEdit() ?? true)){
            throw UnauthorizedException::forPermissions(["update_employees"]);
        }
        if (!is_null($request->document_education_path)){
            $document_path = MyApp::Classes()->storageFiles->Upload($request->document_education_path);
            if (is_bool($document_path)){
                MessagesFlash::Errors(__("err_image_upload"));
                return redirect()->back();
            }
            MyApp::Classes()->storageFiles->deleteFile($education_document->document_education_path);
            $education_document->update([
                "document_education_path" => $document_path,
            ]);
        }
        return $this->responseSuccess(null,null,"update",null,true);
    }

    public function destroy()
    {
        //
    }
}
