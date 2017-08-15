<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * The landing page with list of Todos.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $active = [];
        $completed = [];

        $todos = Auth::user()->todos()->orderBy('updated_at','desc')->get();
        /** @var Collection $groups */
        // Split the collection of todos into active and completed.
        // @todo if possible with Laravel templating use a filter on output loops instead.
        $groups = $todos->groupBy('completed');
        if ($groups->get(0)) {
            $active = $groups->get(0);
        }
        if ($groups->get(1)) {
            $completed = $groups->get(1);
        }

        return view('home', ['active' => $active, 'completed' => $completed]);
    }

    /**
     * Create the Todo.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(Request $request)
    {
        // The todos must have a name and at least 3 characters to make sense.
        $validator = Validator::make($request->all(),
          ['name' => 'required|min:3']
        );

        if ($validator->fails()) {
            $redirect = redirect()->back()->withErrors($validator->errors());
        } else {
            $todo = Todo::create(['name' => $request->get('name')]);
            // Relate todos to loggedin user.
            Auth::user()->todos()->save($todo);
            $redirect = redirect('/');
        }
        return $redirect;
    }

    /**
     * Toggle completed state.
     *
     * @param int $id The id of Todo.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function toggleComplete($id)
    {
        $todo = Auth::user()->todos()->where('id', $id)->first();
        $todo->setAttribute('completed', !$todo->getAttribute('completed'));
        $todo->save();
        return redirect('/');
    }

    /**
     * Delete Todos.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteCompleted()
    {
        Auth::user()->todos()->where('completed', true)->delete();
        return redirect('/');
    }
}
