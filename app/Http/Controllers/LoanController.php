<?php

namespace App\Http\Controllers;

use App\Loan;
use Illuminate\Http\Request;
use Psy\Util\Json;

class LoanController extends Controller
{

    /**
     * fetch loans
     *
     * @param user_id - user id
     * @param status - loan status
     *
     * @return Json response
     */
    public function getLoans($user_id=0, $status='open'){
        $loans = Loan::where('user_id', $user_id)->where('status', $status)->get();

        if(count($loans)>0)
            return response()->json([
                'status' => 'success',
                'data' => $loans,
                'message' => '',
            ]);
        else
            return response()->json([
                'status' => 'failed',
                'data' => [],
                'message' => 'No loan found',
            ]);
    }

    /**
     * Create New Loan
     *
     * user_id - Id of an existing user - foreign key
     * amount - Amount of the loan
     * duration - number of months to repay the loan
     * repayment_frequency - frequency of repayment e.g. monthly
     * interest_rate - rate of interest for the loan
     * arrangement_fee - fee for arranging the loan
     * status - status of the loan
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        try{
            $data = $request->all();

            $oldLoan = Loan::where('user_id', $data['user_id'])->where('status', '<>', 'closed')->get();

            if(count($oldLoan)==0)
                $created = Loan::create($data);
            else
                return response()->json([
                    'status' => 'failed',
                    'data' => [],
                    'message' => 'Running loan already exist',
                ]);

            if(isset($created)){
                return response()->json([
                    'status' => 'success',
                    'data' => $created,
                    'message' => '',
                ]);
            }else{
                return response()->json([
                    'status' => 'failed',
                    'data' => [],
                    'message' => 'Parameter is wrong or missing!',
                ]);
            }
        }catch (\Exception $exception) {
            return response()->json([
                'status' => 'Exception',
                'data' => [],
                'error_code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }

    }

    /**
     * Update existing Loan
     *
     * id - Id of an existing loan
     * amount - Amount of the loan
     * duration - time duration for the loan
     * repayment_frequency - frequency of repayment e.g. monthly
     * interest_rate - rate of interest for the loan
     * arrangement_fee - fee for arranging the loan
     * status - status of the loan
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        try{
            $data = $request->all();

            $oldLoan = Loan::where('id', $data['id'])->where('status', '<>', 'closed')->first();

            if(count($oldLoan)>0){
                $oldLoan->user_id = isset($data['user_id']) ? $data['user_id'] : $oldLoan->user_id;
                $oldLoan->amount = isset($data['amount']) ? $data['amount'] : $oldLoan->amount;
                $oldLoan->duration = isset($data['duration']) ? $data['duration'] : $oldLoan->duration;
                $oldLoan->repayment_frequency = isset($data['repayment_frequency']) ? $data['repayment_frequency'] : $oldLoan->repayment_frequency;;
                $oldLoan->interest_rate = isset($data['interest_rate']) ? $data['interest_rate'] : $oldLoan->interest_rate;
                $oldLoan->arrangement_fee = isset($data['arrangement_fee']) ? $data['arrangement_fee'] : $oldLoan->arrangement_fee;
                $oldLoan->status = isset($data['status']) ? $data['status'] : $oldLoan->status;
                $updated = $oldLoan->save();
            } else
                return response()->json([
                    'status' => 'failed',
                    'data' => [],
                    'message' => 'No loan found',
                ]);

            if(isset($updated)){
                return response()->json([
                    'status' => 'success',
                    'data' => $updated,
                    'message' => '',
                ]);
            }else{
                return response()->json([
                    'status' => 'failed',
                    'data' => [],
                    'message' => 'Parameter is wrong or missing!',
                ]);
            }
        }catch (\Exception $exception) {
            return response()->json([
                'status' => 'Exception',
                'data' => [],
                'error_code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }

    }
}
