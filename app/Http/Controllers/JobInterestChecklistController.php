<?php

namespace App\Http\Controllers;

use Exception;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JobInterestChecklist;
use App\Models\JobInterestList;
use App\Models\UserDiagnosis;

class JobInterestChecklistController extends Controller
{
    public function store(Request $request)
    {
        $additional_diagnosis = str_replace('"',"",$request->additional_diagnosis);
        $additional_subcode = str_replace('"',"",$request->additional_sub_code_id);
        $sub_code_id = str_replace('"',"",$request->sub_code_id);
        if ($request->status == '0') {
            $jobinterestchecklist = [
                'added_by' => $request->added_by,
                'patient_id' => $request->patient_id,

                'interest_to_work' => $request->interest_to_work,
                'agree_if_mentari_find_job_for_you' => $request->agree_if_mentari_find_job_for_you,

                'clerk_job_interester' => $request->clerk_job_interester,
                'clerk_job_notes' => $request->clerk_job_notes,
                'factory_worker_job_interested' => $request->factory_worker_job_interested,
                'factory_worker_notes' => $request->factory_worker_notes,
                'cleaner_job_interested' => $request->cleaner_job_interested,
                'cleaner_job_notes' => $request->cleaner_job_notes,
                'security_guard_job_interested' => $request->security_guard_job_interested,
                'security_guard_notes' => $request->security_guard_notes,
                'laundry_worker_job_interested' => $request->laundry_worker_job_interested,
                'laundry_worker_notes' => $request->laundry_worker_notes,
                'car_wash_worker_job' => $request->car_wash_worker_job,
                'car_wash_worker_notes' => $request->car_wash_worker_notes,
                'kitchen_helper_job' => $request->kitchen_helper_job,
                'kitchen_helper_notes' => $request->kitchen_helper_notes,
                'waiter_job_interested' => $request->waiter_job_interested,
                'waiter_job_notes' => $request->waiter_job_notes,
                'chef_job_interested' => $request->chef_job_interested,
                'chef_job_notes' => $request->chef_job_notes,
                'others_job_specify' => $request->others_job_specify,
                'others_job_notes' => $request->others_job_notes,
                'type_of_job' => $request->type_of_job,
                'duration' => $request->duration,
                'termination_reason' => $request->termination_reason,
                'note' => $request->note,
                'planning' => $request->planning,
                'patient_consent_interested' => $request->patient_consent_interested,

                'additional_code_id' => $request->additional_code_id,
                'additional_subcode' => $additional_subcode,
                'additional_diagnosis' => $additional_diagnosis,
                'location_services' => $request->location_services,
                'services_id' => $request->services_id,
                'code_id' => $request->code_id,
                'sub_code_id' => $sub_code_id,
                'type_diagnosis_id' => $request->type_diagnosis_id,
                'category_services' => $request->category_services,
                'complexity_services' => $request->complexity_of_services,
                'outcome' => $request->outcome,
                'medication_des' => $request->medication_prescription,
                'status' => "0",
                'appointment_details_id' => $request->appId,
                'created_at' =>  date('Y-m-d H:i:s'),
                'updated_at' =>  date('Y-m-d H:i:s'),
            ];
            $validateJobInterestChecklist = [];

            if ($request->category_services == 'assisstance' || $request->category_services == 'external') {
                $validateJobInterestChecklist['services_id'] = 'required';
                $jobinterestchecklist['services_id'] =  $request->services_id;
            } elseif ($request->category_services == 'clinical-work') {
                $validateJobInterestChecklist['code_id'] = 'required';
                $jobinterestchecklist['code_id'] =  $request->code_id;
                $validateJobInterestChecklist['sub_code_id'] = 'required';
                $jobinterestchecklist['sub_code_id'] =  $sub_code_id;
            }
            JobInterestChecklist::where(['id' => $request->id])->update($jobinterestchecklist);
            if (!empty($request->jobs)) {
                foreach ($request->jobs as $key) {
                    if ($key['id']) {
                        $data = array('type_of_job' => $key['job'], 'patient_id' => $request->patient_id, 'duration' => $key['duration'], 'termination_reason' => $key['reason']);
                        JobInterestList::where('id', $key['id'])->update($data);
                    }
                }
                return response()->json(["message" => "Job Interest Checklist Updated Successfully!", "code" => 200]);
            } else {
                // if (!empty($request->jobs)) {
                //     foreach ($request->jobs as $key) {
                //         if ($key['job']) {
                //             $data = array('type_of_job' => $key['job'], 'patient_id' => $request->patient_id, 'duration' => $key['duration'], 'termination_reason' => $key['reason'], 'job_interest_checklist_id' => $jobInterestChecklist['id']);
                //             JobInterestList::insert($data);
                //         }
                //     }
                // }

                return response()->json(["message" => "Job Interest Checklist Updated Successfully!", "code" => 200]);
            }
        } elseif ($request->status == '1') {
            $validator = Validator::make($request->all(), [
                'added_by' => 'required|integer',
                'patient_id' => 'required|integer',
                'interest_to_work' => '',
                'agree_if_mentari_find_job_for_you' => '',
                'clerk_job_interester' => '',
                'clerk_job_notes' => '',
                'factory_worker_job_interested' => '',
                'factory_worker_notes' => '',
                'cleaner_job_interested' => '',
                'cleaner_job_notes' => '',
                'security_guard_job_interested' => '',
                'security_guard_notes' => '',
                'laundry_worker_job_interested' => '',
                'laundry_worker_notes' => '',
                'car_wash_worker_job' => '',
                'car_wash_worker_notes' => '',
                'kitchen_helper_job' => '',
                'kitchen_helper_notes' => '',
                'Waiter_job_interested' => '',
                'Waiter_job_notes' => '',
                'chef_job_interested' => '',
                'chef_job_notes' => '',
                'others_job_specify' => '',
                'others_job_notes' => '',
                'type_of_job' => '',
                'duration' => '',
                'termination_reason' => '',
                'note' => '',
                'planning' => '',
                'patient_consent_interested' => '',
                'location_services' => '',
                'services_id' => '',
                'code_id' => '',
                'sub_code_id' => '',
                'type_diagnosis_id' => '',
                'category_services' => '',
                'complexity_services' => '',
                'outcome' => '',
                'medication_prescription' => '',
                'jobs' => '',
                'id' => '',
                'appId' => '',
            ]);
            if ($validator->fails()) {
                return response()->json(["message" => $validator->errors(), "code" => 422]);
            }

            $jobinterestchecklist = [
                'added_by' => $request->added_by,
                'patient_id' => $request->patient_id,

                'interest_to_work' => $request->interest_to_work,
                'agree_if_mentari_find_job_for_you' => $request->agree_if_mentari_find_job_for_you,
                'clerk_job_interester' => $request->clerk_job_interester,
                'clerk_job_notes' => $request->clerk_job_notes,
                'factory_worker_job_interested' => $request->factory_worker_job_interested,
                'factory_worker_notes' => $request->factory_worker_notes,
                'cleaner_job_interested' => $request->cleaner_job_interested,
                'cleaner_job_notes' => $request->cleaner_job_notes,
                'security_guard_job_interested' => $request->security_guard_job_interested,
                'security_guard_notes' => $request->security_guard_notes,
                'laundry_worker_job_interested' => $request->laundry_worker_job_interested,
                'laundry_worker_notes' => $request->laundry_worker_notes,
                'car_wash_worker_job' => $request->car_wash_worker_job,
                'car_wash_worker_notes' => $request->car_wash_worker_notes,
                'kitchen_helper_job' => $request->kitchen_helper_job,
                'kitchen_helper_notes' => $request->kitchen_helper_notes,
                'waiter_job_interested' => $request->waiter_job_interested,
                'waiter_job_notes' => $request->waiter_job_notes,
                'chef_job_interested' => $request->chef_job_interested,
                'chef_job_notes' => $request->chef_job_notes,
                'others_job_specify' => $request->others_job_specify,
                'others_job_notes' => $request->others_job_notes,
                'type_of_job' => $request->type_of_job,
                'duration' => $request->duration,
                'termination_reason' => $request->termination_reason,
                'note' => $request->note,
                'planning' => $request->planning,
                'patient_consent_interested' => $request->patient_consent_interested,

                'additional_code_id' => $request->additional_code_id,
                'additional_subcode' => $additional_subcode,
                'additional_diagnosis' => $additional_diagnosis,
                'location_services' => $request->location_services,
                'services_id' => $request->services_id,
                'code_id' => $request->code_id,
                'sub_code_id' => $sub_code_id,
                'type_diagnosis_id' => $request->type_diagnosis_id,
                'category_services' => $request->category_services,
                'complexity_services' => $request->complexity_of_services,
                'outcome' => $request->outcome,
                'medication_des' => $request->medication_prescription,
                'status' => "1",
                'appointment_details_id' => $request->appId,
                'created_at' =>  date('Y-m-d H:i:s'),
                'updated_at' =>  date('Y-m-d H:i:s'),
            ];
            $validateJobInterestChecklist = [];

            if ($request->category_services == 'assisstance' || $request->category_services == 'external') {
                $validateJobInterestChecklist['services_id'] = 'required';
                $jobinterestchecklist['services_id'] =  $request->services_id;
            } else if ($request->category_services == 'clinical-work') {
                $validateJobInterestChecklist['code_id'] = 'required';
                $jobinterestchecklist['code_id'] =  $request->code_id;
                $validateJobInterestChecklist['sub_code_id'] = 'required';
                $jobinterestchecklist['sub_code_id'] =  $sub_code_id;
            }
            $validator = Validator::make($request->all(), $validateJobInterestChecklist);
            if ($validator->fails()) {
                return response()->json(["message" => $validator->errors(), "code" => 422]);
            }
            $user_diagnosis = [
                'app_id' => $request->appId,
                'patient_id' =>  $request->patient_id,
                'diagnosis_id' =>  $request->type_diagnosis_id,
                'add_diagnosis_id' => $additional_diagnosis,
                'code_id' =>  $request->code_id,
                'sub_code_id' =>  $sub_code_id,
                'add_code_id'=> $request->additional_code_id,
                'add_sub_code_id' => $additional_subcode,
                'outcome_id' =>  $request->outcome,
                'category_services' =>  $request->category_services,
                'remarks' => 'job_interest_checklist',
                'created_at' => date('Y-m-d H:i:s'),
            ];
            UserDiagnosis::create($user_diagnosis);
            if ($request->id) {
                JobInterestChecklist::where(['id' => $request->id])->update($jobinterestchecklist);
                if (!empty($request->jobs)) {
                    foreach ($request->jobs as $key) {
                        if ($key['id']) {
                            $data = array('type_of_job' => $key['job'], 'patient_id' => $request->patient_id, 'duration' => $key['duration'], 'termination_reason' => $key['reason']);
                            JobInterestList::where('id', $key['id'])->update($data);
                        }
                    }
                }

                return response()->json(["message" => "Job Interest Checklist Created Successfully!", "code" => 200]);
            } else {
                $jobInterestChecklist = JobInterestChecklist::create($jobinterestchecklist);
                if (!empty($request->jobs)) {
                    foreach ($request->jobs as $key) {
                        if ($key['job']) {
                            $data = array('type_of_job' => $key['job'], 'patient_id' => $request->patient_id, 'duration' => $key['duration'], 'termination_reason' => $key['reason'], 'job_interest_checklist_id' => $jobInterestChecklist['id']);
                            JobInterestList::insert($data);
                        }
                    }
                }

                return response()->json(["message" => "Job Interest Checklist Created Successfully!", "code" => 200]);
            }
        }
    }
}
