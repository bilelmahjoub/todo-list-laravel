<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\TodoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index ()
    {
        $todos = TodoModel::all();
        return view('todo\to-do-homepage' , compact ('todos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:8|alpha:ascii'
        ]);
        if($validator->fails()){
            return  redirect()->route('todo.index')->withErrors($validator);
        }
        $todo = new TodoModel();
        $todo->title = $request->get('title');
        $todo->user()->associate(Auth::user());
        $todo->save();


         return redirect()->route('todo.index')->with('success' , 'Todo added successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $todo = TodoModel::where('id', $id)->first();
        return view('todo/todo-edit', compact('todo'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)

    {
        $todo = TodoModel::where('id', $id)->first();
        return view ('todo/todo-edit', compact("todo"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:8|alpha:ascii'
        ]);

        if($validator->fails()) {
            return redirect()->route('todo.edit', ['id' => $id])->withErrors($validator);
        }

        $todo = TodoModel::where('id', $id)->first();

        $todo->title = $request->get('title');
        $todo->is_completed = $request->get('is_completed');
        $todo->save();

        return redirect()->route('todo.index')->with('success', 'Todo modified successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Todomodel::where('id', $id)->delete();
        return redirect()->route('todo.index')->with('success', 'todo deleted');
        }
}
