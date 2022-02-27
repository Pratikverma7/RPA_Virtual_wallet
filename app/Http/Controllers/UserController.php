<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Auth;
use Session;

class UserController extends Controller
{
    public function index()
    {
        return view('users.register');
    }

    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email|max:150',
            'password' => 'required|string|min:8'
        ]);

            $password = $request->password;
            $user = new User();
            $user->email = $request->email;
            $user->name = $request->name;
            $user->password =bcrypt($password);
            $user->wallet_amount = '500';
            $user->save();

            $transaction = new Transaction();
            $transaction->from_user_id = 'ADMIN';
            $transaction->amount = '500';
            $transaction->to_user_id = $request->email;
            $transaction->action = 'c';
            $transaction->save();
            
                if($user)
                {
                    return redirect()->back()->with('success','User Registerd Successfully');
                }
                else
                {
                    return redirect()->back()->with('error','Some Thing Went Wrong Server 500 Error');
                }
        
       
    }

    public function login()
    {
        return view('users.login');
    }
   
    public function dashboard()
    {   
        $userid = Auth::user()->email;
        $user_wallet_amount = User::where('email','=',$userid)->sum('wallet_amount');
        $credit = Transaction::where('to_user_id','=',$userid)->sum('amount');
        $debit = Transaction::where('from_user_id','=',$userid)->sum('amount');
        $history = Transaction::where('from_user_id','=',$userid)->orwhere('to_user_id','=',$userid)->get();

        return view('users.dashboard',compact('history','user_wallet_amount','credit','debit'));
    }

   

    public function logincheck(Request $request)
    {   
        $user =Auth::user();
        $session_id = Session::getId();
         $data = $request->all();

         if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']]))
        {    
             return redirect('user/dashboard')->with('success','You Have Logged-in Successfully ! ');
        }
        else
        {
            return redirect()->back()->with('error','Invalid Username/Password ! ');
        }
    }

    public function transctioncredit(Request $request)
    {   
        $userid = Auth::user()->id;
        $data = $request->all();

        $user_wallet_amount = User::where('email','=',$userid)->sum('wallet_amount');

        $credit = Transaction::where('to_user_id','=',$userid)->sum('amount');
        $debit = Transaction::where('from_user_id','=',$userid)->sum('amount');

        $balance =  $credit - $debit;

        if($balance > $request->amount)
        {
            return redirect()->back()->with('balance','Sorry You Dont Have Insufficient Balance');
        }
        else
        {
            if (User::where('email', '=', $data['to_user_id'])->exists()) 
            {
                     $transaction = new Transaction();
                     $transaction->from_user_id = $request->from_user_id;
                     $transaction->amount = $request->amount;
                     $transaction->to_user_id = $request->to_user_id;
                     $transaction->action = 'd';
                     $transaction->save();
                    if($transaction)
                    {
                        return redirect()->back()->with('success','Amount Send Successfully');
                    }
            }
    
            else
            {
                return redirect()->back()->with('error','Failed To Send No Such User Exist');
            }
        }

    }
    

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
