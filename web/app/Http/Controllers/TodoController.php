<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
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
    public function create(Request $request)
    {
        $todo = Todo::create(['name' => $request->get('name')]);
        // Relate todos to loggedin user.
        Auth::user()->todos()->save($todo);
        return redirect('/home');
    }
    public function toggleComplete($id)
    {
        $todo = Auth::user()->todos()->where('id', $id)->first();
        $todo->setAttribute('completed', !$todo->getAttribute('completed'));
        $todo->save();
        return redirect('/home');
    }
    public function deleteCompleted()
    {
        Auth::user()->todos()->where('completed', true)->delete();
        return redirect('/home');
    }
}
