<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $tasks = Task::orderByRaw('priority');
        if ($request->project_id !== null) {
            $tasks = $tasks->where('project_id', $request->project_id);
        }
        $tasks = $tasks->orderBy('updated_at', 'DESC')
        ->get();

        $projects = Project::all();

        return view('tasks.index', compact('tasks', 'projects'));
    }

    public function store(Request $request): RedirectResponse
    {
        $lastInsertedTask = Task::orderBy('priority', 'DESC')->first();
        $newPriorityNumber = ($lastInsertedTask !== null) ? $lastInsertedTask->priority+1 : 1 ;

        $task = new Task();
        $task->project_id = $request->project_id;
        $task->name = $request->name;
        $task->priority = $newPriorityNumber;
        $task->save();

        return redirect()->route('taskIndex')->with('status', 'Task created!');
    }

    public function update(Request $request): RedirectResponse
    {
        Task::where('id', $request->id)
        ->update([
            'project_id' => $request->project_id,
            'name' => $request->name
        ]);

        return redirect()->route('taskIndex')->with('status', 'Task updated!');
    }

    public function destroy(string $id): RedirectResponse
    {
        Task::where('id', $id)
        ->delete();

        return redirect()->route('taskIndex')->with('statusDelete', 'Task deleted!');
    }

    public function ajaxSetNewPriority(Request $request): JsonResponse
    {
        $id = $request->id;
        $newPriority = $request->priority;

        $currentTask = Task::find($id);

        $oldPriority = $currentTask->priority;

        $currentTask->priority = $newPriority;
        $currentTask->save();

        $tasks = Task::where('priority', '>=', $newPriority)
            ->where('id', '<>', $id)
        ->get();

        foreach ($tasks as $ind => $task) {
            if ($oldPriority > $newPriority) {
                if ($task->priority < $oldPriority) {
                    $task->priority++;
                    $task->save();
                }
            } else {
                if ($task->priority === $newPriority) {
                    $task->priority = $oldPriority;
                    $task->save();

                    continue;
                }
            }
        }

        return response()
                    ->json([
                        'message' => 'Priority Set!'
                    ]);
    }
}
