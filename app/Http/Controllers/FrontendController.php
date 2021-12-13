<?php

namespace App\Http\Controllers;

use App\Models\assign_practice;
use App\Models\contract_status;
use App\Models\Provider;
use App\Models\provider_contract;
use App\Models\provider_contract_note;
use App\Models\provider_document;
use App\Models\provider_document_type;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function test_update_data()
    {


        $all_povider = Provider::all();
        foreach ($all_povider as $pro) {
            provider_contract::where('provider_id', $pro->id)->update(['facility_id' => $pro->practice_id]);
            provider_contract_note::where('provider_id', $pro->id)->update(['facility_id' => $pro->practice_id]);
        }

        return 'done';
        exit();
//        $all_docs = provider_document::all();
//
//        foreach ($all_docs as $docs){

//            $check_doc_type = provider_document_type::where('admin_id',$docs->admin_id)
//                ->where('doc_type_name',$docs->doc_type)->first();
//            if (!$check_doc_type) {
//                $new_doc_type = new provider_document_type();
//                $new_doc_type->admin_id = $check_doc_type->admin_id;
//                $new_doc_type->doc_type_name = $check_doc_type->doc_type;
//                $new_doc_type->save();
//            }


//        }


//        $all_docs = provider_document::all();
//        foreach ($all_docs as $docs){
//            $doc_check = provider_document::where('id',$docs->id)->first();
//            $type_check = provider_document_type::where('doc_type_name',$doc_check->doc_type)->first();
//
//            if ($type_check) {
//                if ($doc_check->doc_type == $type_check->doc_type_name) {
//                    $doc_check->doc_type_id = $type_check->id;
//                    $doc_check->save();
//                }
//            }
//
//
//
//        }


        return 'done';
        exit();

    }
}
