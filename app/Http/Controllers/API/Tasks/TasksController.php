<?php

namespace App\Http\Controllers\API\Tasks;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tasks;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class TasksController extends Controller
{
    // new task 
    public function newTask(Request $request) {
        $title = $request->input('title');
        $description = $request->input('description');
        $userOnline = $request->input('userOnline');
        
        $userModel = User::where('username', $userOnline)->first();
        
        if(!$userModel) {
            return response()->json(['error' => 'unknown account, contact admin'])
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*');
        }
        
        try {
            $newPro = Tasks::create([
                'title' => $title,
                'description' => $description,
                'created_by' => $userOnline,
                'status' => 'active',
            ]);
            if($newPro) {
                return response()->json([
                    'success' => true,
                ])
                    ->header('Content-Type', 'application/json')
                    ->header('Access-Control-Allow-Origin', '*');
            } else {
                return response()->json(['error' => 'Creation failed'])
                    ->header('Content-Type', 'application/json')
                    ->header('Access-Control-Allow-Origin', '*');
            }
            
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'not found'], 404)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*');
        }
    }
    
    // get tasks 
    public function getTasks($username) {
        try {
            $TasksModel = Tasks::where('created_by', $username)->orderby('id', 'desc')->get();
            if ($TasksModel->isEmpty()) {
                return response()->json(['error' => 'No task found'], 404)
                    ->header('Content-Type', 'application/json')
                    ->header('Access-Control-Allow-Origin', '*');
            }
            
            return response()->json($TasksModel)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*');
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'not found'], 404)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*');
        }
    }
    
    public function updateTask(Request $request) {
        $id = $request->input('id');
        $status = $request->input('status');
        try {
            $update = Tasks::where('id', $id)
                            ->update(['status' => $status]);
            if($update) {
                return response()->json([
                    'success' => true,
                ])
                    ->header('Content-Type', 'application/json')
                    ->header('Access-Control-Allow-Origin', '*');
            }
            return response()->json(['error' => 'Update failed'])
                    ->header('Content-Type', 'application/json')
                    ->header('Access-Control-Allow-Origin', '*');
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'not found'], 404)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*');
        }
    }
}
