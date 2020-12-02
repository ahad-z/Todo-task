<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
    	$tasks = Todo::orderBy('status')->get();
    	return response([
    		'status' => true,
    		'tasks'  => $tasks

    	]);

    }

    public function store(Request $request)
    {
    	try {
    		Todo::create([
    			'task' => $request->task
    		]);

    		return response([
				'status'  => true,
				'message' => "Task added"

    		]);
    		
    	} catch (Exception $e) {
    		return response([
				'status'  => false,
				'messahe' => 'Something went Wrong'

    		]);
    	}

    }
     public function show($id)
     {
     	$task = Todo::where('id', $id)->first();
     	return response([
     		'status' => true,
     		'task'   => $task
     	]);

     }

     public function update(Request $request)
     {
     	$task = Todo::where('id', $request->id)->first();
     	$task->task = $request->task;
     	$task->update();
     	return response([
     		'status' => true,
     		'message' => 'Task Update Successfully'

     	]);

     }

     public function status($id)
     { 
     	$status = Todo::where('id', $id)->first();

     	if($status->status == 0){
     		$changestatus = 1;
     	}else{
     		$changestatus = 0;
     	}
     	$status->status = $changestatus;
     	$status->update();
     	return response([
     		'status'  => true,
     		'message' => 'Hurrah! U done your task!' 

     	]);
     }

     public function completeTask()
     {
     	$completeTask = Todo::where('status', '1')->get();
     	return response([
			'status'       => true,
			'completeTask' => $completeTask

     	]);

     }

    public function destroy($id)
    {
    	try {
    		Todo::destroy($id);
    		return response([
				'status'  => true,
				'message' => "Task Delete Successfully"

    		]);
    		
    	} catch (Exception $e) {
    		return response([
				'status'  => false,
				'messahe' => 'Something went Wrong'

    		]);
    	}

    }
}
