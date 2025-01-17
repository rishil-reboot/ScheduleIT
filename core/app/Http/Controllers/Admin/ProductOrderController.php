<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductOrder;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Mail;
use App\BasicExtended;

use App\User;
use Session;

class ProductOrderController extends Controller
{
    public function all(Request $request)
    {
        $search = $request->search;
        $data['orders'] =
        ProductOrder::when($search, function ($query, $search) {
            return $query->where('order_number', $search);
        })
        ->orderBy('id', 'DESC')->paginate(10);

        return view('admin.product.order.index', $data);
    }

    public function pending(Request $request)
    {
        $search = $request->search;
        $data['orders'] = ProductOrder::
        when($search, function ($query, $search) {
            return $query->where('order_number', $search);
        })
        ->where('order_status', 'pending')->orderBy('id', 'DESC')->paginate(10);
        return view('admin.product.order.index', $data);
    }

    public function processing(Request $request)
    {
        $search = $request->search;
        $data['orders'] = ProductOrder::where('order_status', 'processing')
        ->when($search, function ($query, $search) {
            return $query->where('order_number', $search);
        })
        ->orderBy('id', 'DESC')->paginate(10);
        return view('admin.product.order.index', $data);
    }

    public function completed(Request $request)
    {
        $search = $request->search;
        $data['orders'] = ProductOrder::where('order_status', 'completed')->
        when($search, function ($query, $search) {
            return $query->where('order_number', $search);
        })
        ->orderBy('id', 'DESC')->paginate(10);
        return view('admin.product.order.index', $data);
    }

    public function rejected(Request $request)
    {
        $search = $request->search;
        $data['orders'] = ProductOrder::where('order_status', 'rejected')->
        when($search, function ($query, $search) {
            return $query->where('order_number', $search);
        })
        ->orderBy('id', 'DESC')->paginate(10);
        return view('admin.product.order.index', $data);
    }

    public function status(Request $request)
    {

        $po = ProductOrder::find($request->order_id);
        $po->order_status = $request->order_status;
        $po->save();

        $user = User::findOrFail($po->user_id);
        $be = BasicExtended::first();
        $sub = 'Order Status Update';

        $to = $user->email;
         // Send Mail to Buyer
         $mail = new PHPMailer(true);
         if ($be->is_smtp == 1) {

            $emailTemplate = \App\EmailTemplate::where('id',\App\EmailTemplate::ORDER_STATUS_UPDATED_MAIL_TO_BUYER)
                                    ->where('status',1)
                                    ->first();

            if (isset($emailTemplate) && !empty($emailTemplate)) {

                try {
                    if($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_SMTP){

                        $mail->isSMTP();
                    
                    }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_MAIL){
                    
                        $mail->isMail();
                    
                    }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_IS_SEND_MAIL){
                    
                        $mail->isSendMail();
                    }
                     $mail->Host       = $be->smtp_host;
                     $mail->SMTPAuth   = ($be->is_smtp_auth == 1) ? true : false;
                     $mail->Username   = $be->smtp_username;
                     $mail->Password   = \Crypt::decryptString($be->smtp_password);
                     $mail->SMTPSecure = $be->encryption;
                     $mail->Port       = $be->smtp_port;

                     //Recipients
                     $mail->setFrom($be->from_mail, $be->from_name);
                     $mail->addAddress($user->email, $user->fname);

                     // Content
                    $mail->isHTML(true);

                    $mail->Subject = $emailTemplate->subject;
                    $emailTemplate->body_content = str_replace(array('###NAME###','###STATUS###'), array($user->fname,strtoupper($request->order_status)), $emailTemplate->body_content);
                    $mail->Body = view('email_template.transactional.common_email_template',compact('emailTemplate'));   
                    $mail->send();

                } catch (Exception $e) {
                     // die($e->getMessage());
                }
            }
        }

        Session::flash('success', 'Order status changed successfully!');
        return back();
    }

    public function details($id)
    {
        $order = ProductOrder::findOrFail($id);
        return view('admin.product.order.details',compact('order'));
    }


    public function bulkOrderDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $order = ProductOrder::findOrFail($id);
            @unlink('assets/front/invoices/product/'.$order->invoice_number);
            @unlink('assets/front/receipt/'.$order->receipt);
            foreach($order->orderitems as $item){
                $item->delete();
            }
            $order->delete();
        }

        Session::flash('success', 'Orders deleted successfully!');
        return "success";
    }

    public function orderDelete(Request $request)
    {
        $order = ProductOrder::findOrFail($request->order_id);
        @unlink('assets/front/invoices/product/'.$order->invoice_number);
        @unlink('assets/front/receipt/'.$order->receipt);
        foreach($order->orderitems as $item){
            $item->delete();
        }
        $order->delete();

        Session::flash('success', 'product order deleted successfully!');
        return back();
    }

}
