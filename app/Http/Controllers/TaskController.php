<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;
use File;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(auth()->user()->id);
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            "title" => ["required",'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',"max:50"],
            "description" => "required|string|max:255",
            "start_date" => "required|date|after:yesterday",
            "end_date" => "required|date|after:start_date",
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'

        ]);
        $data['user_id'] = auth()->user()->id;

        if($request->isMethod('post')){
           
            $newImageName = md5(uniqid().'_'.time()).'.'.$request->image->extension();
            // move image to public folder named images
            $request->image->move(public_path('images'),$newImageName);
            $data['image']    = $newImageName;
            $op = Task::create($data);
            if($op){$message = "01 Task Inserted";}
            else{$message ="Error, Please Try Again!";}
            session()->flash('Message',$message);
            return redirect(url('/users'));
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
        $data = Task::where('user_id','=',auth()->user()->id)->where('id','=',$id)->get();
        if(count($data)){
            $end_date =  Task::where('id',$id)->value('end_date');
            if($end_date > date('Y-m-d')){
                return view('tasks.edit',['data' => $data[0]]);
            }else{
                return back();
            }
        }else{
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
            "title" => ["required",'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',"max:50"],
            "description" => "required|string|max:255",
            "start_date" => "required|date|after:yesterday",
            "end_date" => "required|date|after:start_date",
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'

        ]);
        if($request->isMethod('put')){
           
            $newImageName = md5(uniqid().'_'.time()).'.'.$request->image->extension();
            // move image to public folder named images
            $request->image->move(public_path('images'),$newImageName);
            $data['image']    = $newImageName;

            $oldImage =  Task::where('id',$id)->value('image');
            if(File::exists(public_path('images/'.$oldImage))){
                File::delete(public_path('images/'.$oldImage));
            }

            $op = Task::where('id',$id)->update($data);
            if($op){$message = "01 Row Updated";}
            else{$message ="Error, Please Try Again!";}
            session()->flash('Message',$message);
            return redirect(url('/users'));
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

        $data = Task::where('user_id','=',auth()->user()->id)->where('id','=',$id)->get();
        if(count($data)){
            $end_date =  Task::where('id',$id)->value('end_date');
            if($end_date > date('Y-m-d')){
                    $image =  Task::where('id',$id)->value('image');
        
                    if(File::exists(public_path('images/'.$image))){
                        File::delete(public_path('images/'.$image));
                    }

                    $op = Task::where('id',$id)->delete();
                    if($op){$message = "row Deleted";}
                    else{$message = "error";}
                    session()->flash('Message',$message);
                    return redirect(url('/users'));
            }else{
                return back();
            }
           
        }else{
            return back();
        }
       
    }
}
