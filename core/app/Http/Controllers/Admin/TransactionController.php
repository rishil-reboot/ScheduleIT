<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Datatable\SSP;
use App\Helpers\Common;
use App\User;
use App\BookingTransaction;
use Validator;
use DB;

class TransactionController extends Controller {

    /**
     * Transaction Model
     * @var Transaction
     */
    protected $transaction;
    protected $basicSetting;
    protected $pageLimit;

    /**
     * Inject the models.
     * @param Transaction $transaction
     */
    public function __construct(BookingTransaction $transaction) {
            
        $this->basicSetting = \App\BasicSetting::first();
        $this->transaction = $transaction;
        $this->pageLimit = config('settings.pageLimit');
        $this->userList = ['' => trans('admin/transaction.select_user')] + User::select('username','id')->pluck('username', 'id')->toArray();
    }

    /**
     * Display a listing of transactions
     *
     * @return Response
     */
    public function index(Request $request) {

        $bs = $this->basicSetting;

        if ($bs->booking_payment == 2) {

            return redirect()->back();
        }

        //reset search
        if ($request->isMethod('post')) {
            $request->session()->forget('SEARCH');
        }
        if ($request->has('reset')) {
            $request->session()->forget('SEARCH');
            return redirect()->back();
        }
        //end code
        
        if ($request->get('search_by') != ''){
            session(['SEARCH.SEARCH_BY' => trim($request->get('search_by'))]);
        }
        
        if ($request->get('search_txt') != '') {
            session(['SEARCH.SEARCH_TXT' => trim($request->get('search_txt'))]);
        }
        
        if ($request->get('user_id') != '') {
            session(['SEARCH.USER_ID' => trim($request->get('user_id'))]);
        }
        
        if ($request->get('search_date') != '') {
            session(['SEARCH.SEARCH_DATE' => trim($request->get('search_date'))]);
        }
        
        $query = BookingTransaction::select('*');
        if ($request->session()->get('SEARCH.SEARCH_BY') != '') {
            if ($request->session()->get('SEARCH.SEARCH_BY') == 'user') {
                $query->where('user_id', $request->session()->get('SEARCH.USER_ID'));
            }
            
            if ($request->session()->get('SEARCH.SEARCH_BY') == 'trans_id') {
                $query->where('trans_id', $request->session()->get('SEARCH.SEARCH_TXT'));
            }
            
            if ($request->session()->get('SEARCH.SEARCH_BY') == 'transaction_date') {
                $date = date('Y-m-d',strtotime($request->session()->get('SEARCH.SEARCH_DATE')));
                $query->where(DB::raw("date(created_at)"),'=',$date);
            }
            $transactions = $query->orderBy('created_at', 'desc')->paginate($this->pageLimit);
        }else{
            $userId = request()->segment(3);
            if($userId){
                $transactions = $query->userBy($userId)->orderBy('created_at','DESC')->paginate($this->pageLimit);
            }else{
                $transactions = $query->orderBy('created_at', 'desc')->paginate($this->pageLimit);
            }
        }
//        $transactions = $query->orderBy('created_at', 'DESC')->toSql();
//        echo $transactions;
//        $bindings = $query->getBindings();
//        dd($bindings);
        $userList = $this->userList;
        return view('admin/booking/transaction/transactionList', compact('transactions','userList'));
    }
    
    /**
     * Display the specified transaction.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        
        $bs = $this->basicSetting;

        if ($bs->booking_payment == 2) {

            return redirect()->back();
        }

        $transaction = BookingTransaction::findOrFail($id);
        return view('admin/booking/transaction/transactionDetails', compact('transaction'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
        $bs = $this->basicSetting;

        if ($bs->booking_payment == 2) {

            return redirect()->back();
        }

        BookingTransaction::destroy($id);
        
        session()->flash('success_message', trans('admin/transaction.transaction_delete_message'));
        $array = array();
        $array['success'] = true;
        //$array['message'] = 'Transaction deleted successfully!';
        echo json_encode($array);
    }
    
    /**
     *  export transactions-list.csv
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request) {
        
        $bs = $this->basicSetting;

        if ($bs->booking_payment == 2) {

            return redirect()->back();
        }
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=transactions-list.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Transaction ID', 'User Name', 'Payment Method', 'Credit', 'Amount', 'Transaction Date','Transaction Status'));
        $transactions = BookingTransaction::orderBy('created_at', 'DESC')->get();
        foreach ($transactions as $data) {
            $amt = $data->amount.' '.$data->currency;
            $user = $data->username;
            $date = date('d-m-Y h:i:s A', strtotime($data->created_at));
            fputcsv($output, array(
                $data->trans_id,
                $user,
                $data->payment_method,
                $data->credit,
                $amt,
                $date,
                $data->status
                    )
            );
        }
        fclose($output);
        exit;
    }
}