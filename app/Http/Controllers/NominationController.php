<?php

namespace App\Http\Controllers;

use App\Mail\InvoicePaymentMail;
use App\Mail\MakePaymentMail;
use App\Mail\NominationSubmitMail;
use App\Models\Invoice;
use App\Models\Nomination;
use App\Models\Theme;
use App\Notifications\Notifications\NominationSubmit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PDF;

class NominationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice = Invoice::get()->unique('name');
        $theme = Theme::findOrFail(1);
        return view('nomination.index', [
            'form_type' =>'store',
            'invoices' => $invoice,
            'theme' => $theme,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|starts_with:+8801,01',
            'designation' => 'required',
            'organization' => 'required',
            'address' => 'required',
            // 'member_name' => 'required',
            // 'member_designation' => 'required',
            // 'member_organization' => 'required',
            // 'member_contact' => 'required',
            // 'member_email' => 'required',
            // 'g-recaptcha-response' => 'required|recaptchav3:register,0.5'
        ]);


        $members = [];
if($request->member_name){
    for ($i = 0; $i < count($request->member_name); $i++) {
        array_push($members, [
            'member_name' => $request->member_name[$i],
            'member_designation' => $request->member_designation[$i],
            'member_organization' => $request->member_organization[$i],
            'member_contact' => $request->member_contact[$i],
            'member_email' => $request->member_email[$i],
            'members' => json_encode($members),
        ]);
    }
}


        $ukey = time() . rand(100, 999);

            Nomination::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'uid' => '',
                'ukey' => $ukey,
                'designation' => $request->designation,
                'organization' => $request->organization,
                'address' => $request->address,
                'members' => json_encode($members),

            ]);
            $user_data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'ukey' => $ukey,
                'organization' => $request->organization,
                'all_members' => json_encode($members),
            ];
            // Mail::to($request->email)->send(new NominationSubmitMail($data));
            // $user_data->notify(new PaymentNotification($user_data));
            Mail::to($request->email)->send(new MakePaymentMail($user_data));

            // $mail = new MakePaymentMail($user_data);
            // $mail->replyTo('abir@bangladeshbrandforum.com', 'Abir Zaman');
            // Mail::to($request->email)->send($mail);
            return redirect()->route('form.hosted', $ukey);

    }

    public function updateinfo(Request $request, $id)
    {
        $update_date = Nomination::findOrFail($id);
        $update_date->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'designation' => $request->designation,
                'organization' => $request->organization,
                'address' => $request->address,
            ]);

            return redirect()->route('dashboard.index')->with('success', 'Nomination Updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nomination= Nomination::findOrFail($id);
        $invoice = Invoice::get()->unique('name');
        $theme = Theme::findOrFail(1);
        return view('nomination.index',[
            'form_type' =>'edit',
            'edit' => $nomination,
            'invoices' => $invoice,
            'theme' => $theme,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'invoice' => 'required|numeric',
        ]);
        $invoice = Invoice::where('invoice', $request->invoice)->first();
        if ($invoice) {
            if($invoice->trash == 1){
                return back()->with('warning', 'Your invoice is blocked. Please contact us to use this invoice again.');
            }else if($invoice->available < 1){
                return back()->with('danger', 'All Invoices are used');
            }else{
                $update_invoice = Invoice::where('invoice', $request->invoice)->first();
                $update_date = Nomination::where('ukey', $id)->first();
                $count = count(Nomination::where('invoice', $request->invoice)->get());
                $used = $count;
                $available = $update_invoice->total - $used;
                $update_invoice->update([
                    'used' => $used + 1,
                    'available' => $available - 1,
                ]);
                $update_date->update([
                    'invoice' => $request->invoice,
                ]);
                $user_data = $update_date;
                // $user_data->notify(new PaymentNotification($user_data));
                Mail::to($request->email)->send(new InvoicePaymentMail($user_data));

                // return redirect()->route('form.index')->with('success', 'Nomination Submitted');
                return back()->with('success', 'Nomination Submitted');
            }
        } else {
            return back()->with('warning', 'Invalid Invoice Number');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function hosted($ukey = null)
    {
        if ($ukey === null) {
            return redirect()->route('form.index')->with('danger', 'User Key Not Found');
        }
        if ($ukey) {
            $user_date = Nomination::where('ukey', $ukey)->first();
            $all_member= json_decode($user_date->members);
            $total_member= count($all_member)+1;
            $invoice = Invoice::where('invoice', $user_date->invoice)->first();
            $theme = Theme::first();
            $order_details = DB::table('orders')
                ->where('transaction_id', $ukey)
                ->select('transaction_id', 'tran_date', 'bank_tran_id', 'status', 'currency', 'amount', 'card_issuer')->orderBy('id', 'desc')->first();
            if ($user_date) {
                return view('nomination.checkout', [
                    'name' => $user_date->name,
                    'email' => $user_date->email,
                    'phone' => $user_date->phone,
                    'category' => $user_date->category,
                    'themeamount' => $theme->amount,
                    'payment' => $user_date->payment,
                    'invoice' => $user_date->invoice,
                    'members' => $user_date->members,
                    'total_member' => $total_member,
                    'ukey' => $user_date->ukey,
                    'card_issuer' => $order_details->card_issuer ?? '',
                    'transaction_id' => $order_details->transaction_id ?? '',
                    'tran_date' => $order_details->tran_date ?? '',
                    'bank_tran_id' => $order_details->bank_tran_id ?? '',
                    'amount' => $order_details->amount ?? '',
                    'invoice' => $invoice->invoice ?? '',
                ]);
            } else {
                return redirect()->route('form.index')->with('warning', 'User Key not matched');
            }
        }
    }
    public function thanks($ukey = null)
    {
        if ($ukey === null) {
            return redirect()->route('form.index')->with('danger', 'User Key Not Found');
        }
        if ($ukey) {
            $user_date = Nomination::where('ukey', $ukey)->first();
            $order_details = DB::table('orders')
                ->where('transaction_id', $ukey)
                ->select('transaction_id', 'tran_date', 'bank_tran_id', 'status', 'currency', 'amount', 'card_issuer')->orderBy('id', 'desc')->first();
            if ($user_date) {
                return view('dashboard.thankyou', [
                    'name' => $user_date->name,
                    'email' => $user_date->email,
                    'phone' => $user_date->phone,
                    'payment' => $user_date->payment,
                    'invoice' => $user_date->invoice,
                    'ukey' => $user_date->ukey,
                    'card_issuer' => $order_details->card_issuer ?? '',
                    'transaction_id' => $order_details->transaction_id ?? '',
                    'tran_date' => $order_details->tran_date ?? '',
                    'bank_tran_id' => $order_details->bank_tran_id ?? '',
                    'amount' => $order_details->amount ?? '',
                ]);
            } else {
                return redirect()->route('form.index')->with('warning', 'User Key not matched');
            }
        }
    }
    public function free($ukey = null)
    {
        if ($ukey === null) {
            return redirect()->route('form.index')->with('danger', 'User Key Not Found');
        }
        if ($ukey) {
            $user_date = Nomination::where('ukey', $ukey)->first();
            $theme = Theme::first();

            if ($user_date) {
                return view('dashboard.thankyoufree', [
                    'name' => $user_date->name,
                    'email' => $user_date->email,
                    'phone' => $user_date->phone,
                    'payment' => $user_date->payment,
                    'invoice' => $user_date->invoice,
                    'ukey' => $user_date->ukey,
                    'themeamount' => $theme['amount'],
                ]);
            } else {
                return redirect()->route('form.index')->with('warning', 'User Key not matched');
            }
        }
    }
    public function redirect()
    {
        return redirect()->route('form.index');
    }
}
