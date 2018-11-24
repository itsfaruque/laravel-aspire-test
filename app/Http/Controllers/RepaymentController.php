<?php

namespace App\Http\Controllers;

use App\Loan;
use App\Repayment;
use Illuminate\Http\Request;

class RepaymentController extends Controller
{

    /**
     * fetch repayments
     *
     * @param loan_id - Loan id
     *
     * @return Json response
     */
    public function getRepayments($loan_id=0){
        $repayments = Repayment::where('loan_id', $loan_id)->get();

        if(count($repayments)>0)
            return response()->json([
                'status' => 'success',
                'data' => $repayments,
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
     * Create New Repayment
     *
     * loan_id - Id of an existing loan - foreign key
     * repayment_amount - amount of money to be repaid (will be calculated)
     * repayment_number - number of repayment (will be calculated)
     *
     * @return JSON response
     */
    public function create(Request $request)
    {
        try{
            $data = $request->all();

            $loan = Loan::whereId($data['loan_id'])->where('status', '=', 'open')->first();

            if($loan){
                $repayment = $this->loan_calculator($loan);
                $data['repayment_amount'] = round($data['repayment_amount'], 2);

                if($data['repayment_amount']===$repayment){
                    $repayments = Repayment::where('loan_id', $data['loan_id'])->get();
                    $repayment_number = count($repayments)+1;
                    $data['repayment_number'] = $repayment_number;

                    $created = Repayment::create($data);

                    if(isset($created)){
                        return response()->json([
                            'status' => 'success',
                            'data' => $created,
                            'message' => 'Successfully created repayment!',
                        ]);
                    }else{
                        return response()->json([
                            'status' => 'failed',
                            'data' => [],
                            'message' => 'Repayment couldn\'t be created!',
                        ]);
                    }

                } else
                    return response()->json([
                        'status' => 'failed',
                        'data' => [],
                        'message' => 'Repayment amount doesn\'t match',
                    ]);

            }else{
                return response()->json([
                    'status' => 'failed',
                    'data' => [],
                    'message' => 'No loan found',
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
     * Calculate Loan repayment amount
     *
     * @param $loan - Loan object
     * @return rounded repayment amount
     */
    public function loan_calculator($loan){
        $repayment_amount = (($loan->amount * ($loan->interest_rate/100) * ($loan->duration/12))+$loan->amount)/$loan->duration;
        return round($repayment_amount, 2);
    }

}
