<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:todo-list|todo-create|todo-edit|todo-delete', ['only' => ['index','show']]);
        $this->middleware('permission:todo-create', ['only' => ['create','store']]);
        $this->middleware('permission:todo-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:todo-delete', ['only' => ['destroy']]);
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $todos = Todo::latest()->paginate(5);
        return view('todo.index',compact('todos'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        Todo::create($request->all());

        return redirect()->route('todos.index')
            ->with('success','Todo created successfully.');
    }

    /**
     * @param Todo $todo
     * @return Application|Factory|View
     */
    public function show(Todo $todo)
    {
        return view('todos.show',compact('todo'));
    }

    /**
     * @param Todo $todo
     * @return Application|Factory|View
     */
    public function edit(Todo $todo)
    {
        return view('todos.edit',compact('todo'));
    }

    /**
     * @param Request $request
     * @param Todo $todo
     * @return RedirectResponse
     */
    public function update(Request $request, Todo $todo)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $todo->update($request->all());

        return redirect()->route('todos.index')
            ->with('success','Todo updated successfully');
    }

    /**
     * @param Todo $todo
     * @return RedirectResponse
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()->route('todos.index')
            ->with('success','Todo deleted successfully');
    }
}
