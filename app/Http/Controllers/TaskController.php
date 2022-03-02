<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $task_data   = Task::where('user_id', Auth::user()->id)->orderBy('id','DESC');

        if (!empty($request->client_id)) {
            $task_data = $task_data->where('client_id', $request->client_id);
        }

        if (!empty($request->status)) {
            $task_data = $task_data->where('status', $request->status);
        }

        if (!empty($request->price)) {
            $task_data = $task_data->where('price', '<=', $request->price);
        }

        if (!empty($request->fromDate)) {
            $task_data = $task_data->whereDate('created_at', '>=', $request->fromDate);
        }

        if (!empty($request->endDate)) {
            $task_data = $task_data->whereDate('created_at', '<=', $request->endDate);
        }

        $tasks = $task_data->paginate(10)->withQueryString();

        $clients = Client::where('user_id', Auth::user()->id)->get();

        return view('task.index')->with([
            'tasks'   => $tasks,
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create')->with([
            'clients' => Client::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $this->taskValidation($request);

        try {
            Task::create([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'price'       => $request->price,
                'client_id'   => $request->client_id,
                'user_id'     => Auth::user()->id,
                'description' => $request->description,
            ]);

            return redirect()->route('task.index')->with('success', "Task Created!");
        } catch (\Throwable $th) {
            return redirect()->route('task.index')->with('error', $th->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show( $slug )
    {
        $task = Task::where('slug', $slug)->get()->first();
        return view('task.show')->with('task', $task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('task.edit')->with([
            'task'   => $task,
            'clients' => Client::where('user_id', Auth::user()->id)->get(),
        ]);
    }

    /**
     * Task data Validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function taskValidation(Request $request)
    {
        return $request->validate([
            'name'        => ['required', 'max:255', 'string'],
            'price'       => ['required', 'integer'],
            'client_id'   => ['required', 'max:255', 'not_in:none'],
            'description' => ['required'],
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $this->taskValidation($request);

        try {
            $task->update([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'price'       => $request->price,
                'client_id'   => $request->client_id,
                'user_id'     => Auth::user()->id,
                'description' => $request->description,
            ]);


            return redirect()->route('task.index')->with('success', "Task Updated!");
        } catch (\Throwable $th) {
            return redirect()->route('task.index')->with('error', $th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('task.index')->with('success', "Task Deleted");
    }


    public function markAsComplete(Task $task) {

        $task->update([
            'status' => 'complete'
        ]);

        return redirect()->back()->with('success', "Mark as Completed");
    }
}
