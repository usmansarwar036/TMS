<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::orderBy('id', 'desc')->get();
    }

    public function create()
    {
    }
    /**
     * Show the form for creating a new resource.
     */
    public function editStatus(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'completed' => 'required|integer',
        ]);

        try {
            $task = Task::find($request->id);
            if (!$task) {
                return response()->json(['error' => 'Task not found'], 404);
            }
            $task->update([
                'completed' => $request['completed']
            ]);

            return response()->json(['message' => 'Task status successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'user_id' => 'required|integer'
        ]);
        try {
            Task::create($validatedData);
            return response()->json(['message' => 'Task Added Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'user_id' => 'required|integer'
        ]);

        try {
            $task = Task::find($id);
            if (!$task) {
                return response()->json(['error' => 'Task not found'], 404);
            }
            $task->update([
                'title' => $validatedData['title'],
                'desc' => $validatedData['desc'],
                'user_id' => $validatedData['user_id']
            ]);

            return response()->json(['message' => 'Task updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $task = Task::find($id);
            if (!$task) {
                return response()->json(['error' => 'Task not found'], 404);
            }
            $task->delete();
            return response()->json(['message' => 'Task Deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function deleteAll()
    {
        try {
            Task::truncate();
            return response()->json(['message' => 'All records deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
