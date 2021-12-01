<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(){
        // middleware alternative to route 
        $this->middleware('usercheck',['except'=>['login','loginProcess','create','store']]);
    }

    /**
     * Login Page    
     */
    public function login()
    {
        return view('users.login');
    }

    public function loginProcess(Request $request)
    {
        $data = $this->validate($request,[
            "email" => "required|email",
            "password" => "required"
        ]);
        // auth there is method and class it return true or false
        if(auth()->attempt($data)){
            $name = auth()->user()->name;
            $message ="Welcome $name";
            session()->flash('Message',$message);
            return redirect(url('users'));
        }else{
            $message ="Incorrect Entry, Please Try Again!";
            session()->flash('Message',$message);
            return redirect(url('login'));
        }

    }

    public function logout(){
        auth()->logout();
        $message ="Logged Out Successfully!";
        session()->flash('Message',$message);
        return redirect(url('login'));
    }




    /**
     * Main Users page which shows List of todo list   
     */
    public function index()
    {
        $data = Task::orderBy('id','desc')->where('user_id',auth()->user()->id)->get();
        
       return view('users.index',['data' => $data]);
    }

    /**
     * Register User page
     */
    public function create()
    {
        // 
        return view('users.create');
    }

    /**
     * Store a newly created Users
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            "name" => ["required",'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',"max:50"],
            "email" => "required|email|max:50",
            "password" => "required|confirmed|min:6|max:50",
        ]);
        if($request->isMethod('post')){
                     
            $data['password'] = bcrypt($data['password']);

            $op = User::create($data);
            if($op){
                $message = "Successfully Registered, Please login!";
                session()->flash('Message',$message);
                return redirect(url('/login'));
            }
            else{
                $message ="Error, Please Try Again!";
                session()->flash('Message',$message);
                return redirect(url('/users/create'));
            }
        }
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
      
        if(auth()->user()->id == $id){
            $data = User::find($id);
            return view('users.edit',['data' => $data]);
        }else{
            $message = "Access Denied!";
            session()->flash('Message',$message);
            return back();
        }
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
        $data = $this->validate($request,[
            "name" => ["required",'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',"max:50"],
            "email" => "required|email|max:50"
        ]);
      
        if($request->isMethod('put')){
           
            $op = User::where('id',$id)->update($data);
            if($op){$message = "User Info Updated!";}
            else{$message ="Error, Please Try Again!";}
            session()->flash('Message',$message);
            return redirect(url('users'));
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
}
