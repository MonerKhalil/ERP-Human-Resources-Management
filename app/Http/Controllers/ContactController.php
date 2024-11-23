<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\HelpersClasses\MessagesFlash;
use App\HelpersClasses\MyApp;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\DocumentContactRequest;
use App\Models\Contact;
use App\Models\DocumentContact;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ContactController extends Controller
{
    /**
     * @param ContactRequest $request
     * @param $contact
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|null
     * @author moner khalil
     */
    public function updateContact(ContactRequest $request, $contact)
    {
        $contact = Contact::query()->findOrFail($contact);
        if (!$contact->canEdit()){
            throw UnauthorizedException::forPermissions(["update_employees"]);
        }
        $contact->update($request->validated());
        return $this->responseSuccess(null,null,"update",null,true);
    }

    /**
     * @throws \App\Exceptions\MainException
     * @author moner khalil
     */
    public function addContactDocument(DocumentContactRequest $request, $contact){
        try {
            $contact = Contact::query()->findOrFail($contact);
            if (!$contact->canEdit()){
                throw UnauthorizedException::forPermissions(["update_employees"]);
            }
            DB::beginTransaction();
            if (!is_null($request->document_contact)){
                foreach ($request->document_contact as $item){
                    $temp = $item;
                    if (isset($temp['document_path'])){
                        $temp['document_path'] = MyApp::Classes()->storageFiles
                            ->Upload($temp['document_path'],"employees/document_contact");
                    }
                    $contact->document_contact()->create($temp);
                }
            }
            DB::commit();
            return $this->responseSuccess(null,null,"create",null,true);
        }catch (\Exception $exception){
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }

    public function updateContactDocument(DocumentContactRequest $request ,$contact_document){
        $contact_document = DocumentContact::query()->findOrFail($contact_document);
        if (!($contact_document->contact()->canEdit()?? true)){
            throw UnauthorizedException::forPermissions(["update_employees"]);
        }
        $data = $request->validated();
        if (isset($data['document_path'])){
            $document_path = MyApp::Classes()->storageFiles->Upload($data['document_path']);
            if (is_bool($document_path)){
                MessagesFlash::Errors(__("err_image_upload"));
                return redirect()->back();
            }
            $data['document_path'] = $document_path;
            MyApp::Classes()->storageFiles->deleteFile($contact_document->document_path);
        }
        $contact_document->update($data);
        return $this->responseSuccess(null,null,"update",null,true);
    }

    public function destroy()
    {
    }

}
