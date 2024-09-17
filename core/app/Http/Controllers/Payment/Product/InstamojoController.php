<?php

namespace App\Http\Controllers\Payment\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\Http\Helpers\Instamojo;
use App\OrderItem;
use App\PaymentGateway;
use App\Product;
use App\ProductOrder;
use App\ShippingCharge;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PDF;

class InstamojoController extends Controller
{
    public function store(Request $request)
    {
        if (!Session::has('cart')) {
            return view('errors.404');
        }



        $cart = Session::get('cart');

        $total = 0;
        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);
            if ($product->stock < $item['qty']) {
                Session::flash('stock_error', $product->title . ' stock not available');
                return back();
            }
            $total  += $product->current_price * $item['qty'];
        }

        if ($request->shipping_charge != 0) {
            $shipping = ShippingCharge::findOrFail($request->shipping_charge);
            $shippig_charge = $shipping->charge;
        } else {
            $shippig_charge = 0;
        }

        $total = round($total + $shippig_charge, 2);

        $data = PaymentGateway::whereKeyword('instamojo')->first();
        $paydata = $data->convertAutoData();

        // Validation Starts

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bex = $currentLang->basic_extra;
        $bs = $currentLang->basic_setting;


        if ($bex->base_currency_text != "INR") {
            return redirect()->back()->with('error', __('Please Select INR Currency For This Payment.'));
        }

        $rules = [
            'billing_fname' => 'required',
            'billing_lname' => 'required',
            'billing_address' => 'required',
            'billing_city' => 'required',
            'billing_country' => 'required',
            'billing_number' => 'required',
            'billing_email' => 'required',
            'shpping_fname' => 'required',
            'shpping_lname' => 'required',
            'shpping_address' => 'required',
            'shpping_city' => 'required',
            'shpping_country' => 'required',
            'shpping_number' => 'required',
            'shpping_email' => 'required'
        ];

        $request->validate($rules);
        // Validation Ends



        // saving datas in database
        $order = new ProductOrder();
        $order->user_id = Auth::user()->id;
        $order->billing_fname = $request->billing_fname;
        $order->billing_lname = $request->billing_lname;
        $order->billing_email = $request->billing_email;
        $order->billing_address = $request->billing_address;
        $order->billing_city = $request->billing_city;
        $order->billing_country = $request->billing_country;
        $order->billing_number = $request->billing_number;
        $order->shpping_fname = $request->shpping_fname;
        $order->shpping_lname = $request->shpping_lname;
        $order->shpping_email = $request->shpping_email;
        $order->shpping_address = $request->shpping_address;
        $order->shpping_city = $request->shpping_city;
        $order->shpping_country = $request->shpping_country;
        $order->shpping_number = $request->shpping_number;

        $order->total = $total;
        $order->shipping_charge = round($shippig_charge, 2);
        $order->method = "Instamojo";
        $order->currency_code = $bex->base_currency_text;
        $order->order_number = str_random(4) . time();
        $order->payment_status = 'Pending';
        $order['txnid'] = 'txn_' . str_random(8) . time();
        $order['charge_id'] = 'ch_' . str_random(9) . time();
        if ($request->hasFile('receipt')) {
            $receipt = uniqid() . '.' . $request->file('receipt')->getClientOriginalExtension();
            $request->file('receipt')->move('assets/front/receipt/', $receipt);
            $order['receipt'] = $receipt;
        }


        $order->save();
        $order_id = $order->id;

        $carts = Session::get('cart');
        $products = [];
        $qty = [];
        foreach ($carts as $id => $item) {
            $qty[] = $item['qty'];
            $products[] = Product::findOrFail($id);
        }


        foreach ($products as $key => $product) {
            if (!empty($product->category)) {
                $category = $product->category->name;
            } else {
                $category = '';
            }
            OrderItem::insert([
                'product_order_id' => $order_id,
                'product_id' => $product->id,
                'user_id' => Auth::user()->id,
                'title' => $product->title,
                'sku' => $product->sku,
                'qty' => $qty[$key],
                'category' => $category,
                'price' => $product->current_price,
                'previous_price' => $product->previous_price,
                'image' => $product->feature_image,
                'summary' => $product->summary,
                'description' => $product->description,
                'created_at' => Carbon::now()
            ]);
        }


        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);
            $stock = $product->stock - $item['qty'];
            Product::where('id', $id)->update([
                'stock' => $stock
            ]);
        }


        $fileName = str_random(4) . time() . '.pdf';
        $path = 'assets/front/invoices/product/' . $fileName;
        $data['order']  = $order;
        $pdf = PDF::loadView('pdf.product', $data)->save($path);

        ProductOrder::where('id', $order_id)->update([
            'invoice_number' => $fileName
        ]);
        // saving datas in database


        $orderData['item_name'] = $bs->website_title . " Order";
        $orderData['item_number'] = str_random(4) . time();
        $orderData['item_amount'] = $total;
        $orderData['order_id'] = $order_id;
        $orderData['invoice'] = $fileName;

        $cancel_url = route('product.payment.cancle');
        $notify_url = route('product.instamojo.notify');


        if ($paydata['sandbox_check'] == 1) {
            $api = new Instamojo(\Crypt::decryptString($paydata['key']), \Crypt::decryptString($paydata['token']), 'https://test.instamojo.com/api/1.1/');
        } else {
            $api = new Instamojo(\Crypt::decryptString($paydata['key']), \Crypt::decryptString($paydata['token']));
        }

        try {

            $response = $api->paymentRequestCreate(array(
                "purpose" => $orderData['item_name'],
                "amount" => $orderData['item_amount'],
                "send_email" => false,
                "email" =>  null,
                "redirect_url" => $notify_url
            ));



            $redirect_url = $response['longurl'];

            Session::put('order_payment_id', $response['id']);
            Session::put('order_data', $orderData);

            return redirect($redirect_url);
        } catch (Exception $e) {

            return redirect($cancel_url)->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function notify(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $be = $currentLang->basic_extended;

        $order_data = Session::get('order_data');
        $orderid = $order_data["order_id"];
        $success_url = route('product.payment.return');
        $cancel_url = route('product.payment.cancle');
        $input_data = $request->all();
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('order_payment_id');

        if ($input_data['payment_request_id'] == $payment_id) {
            $po = ProductOrder::findOrFail($orderid);
            $po->payment_status = "Completed";
            $po->save();


            // Send Mail to Buyer
            $mail = new PHPMailer(true);
            $user = Auth::user();

            if ($be->is_smtp == 1) {
                
                $emailTemplate = \App\EmailTemplate::where('id',\App\EmailTemplate::PRODUCT_ORDER_FOR_BUYER)
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

                        // Attachments
                        $mail->addAttachment('assets/front/invoices/product/' . $order_data["invoice"]);

                        // Content
                        $mail->isHTML(true);
                       
                        $mail->Subject = $emailTemplate->subject;
                        $emailTemplate->body_content = str_replace(array('###NAME###'), array($user->fname), $emailTemplate->body_content);
                        $mail->Body = view('email_template.transactional.common_email_template',compact('emailTemplate'));

                        $mail->send();
                    } catch (Exception $e) {
                        // die($e->getMessage());
                    }
                }
            }

            Session::forget('order_payment_id');
            Session::forget('order_data');
            Session::forget('cart');

            return redirect($success_url);
        }
        return redirect($cancel_url);
    }
}
