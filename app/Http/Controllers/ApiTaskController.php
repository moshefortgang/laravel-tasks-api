<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class ApiTaskController extends Controller
{

	public function getAllTasks()
	{
		$tasks = array_values(Task::get()->sortBy('index')->toArray());
		return response($tasks, 200);
	}

	public function getTask(Request $request)
	{
		if (Task::where('id', $request->id)->exists()) {
			$task = Task::where('id', $request->id)->get()->toJson();
			return response($task, 200);
		} else {
			return response()->json([
				"message" => "task not found"
			], 404);
		}
	}

	public function createTask(Request $request)
	{
		$task = new Task;
		$task->title = $request->title;
		$task->description = $request->description;
		$task->due_date = $request->due_date;
		$task->save();

		$task->index = $task->id;
		$task->save();

		return response()->json([
			"message" => "task record created",
			"task"    => $task
		], 201);
	}


	public function updateTasksOrder(Request $request)
	{
		foreach ($request->all() as $key => $value) {
			Task::where('id', $value['id'])
				->update(['index' => $value['index']]);
		}
	}

	public function updateTask(Request $request, $id)
	{
		if (Task::where('id', $id)->exists()) {
			$task = Task::find($id);
			$task->title = is_null($request->title) ? $task->title : $request->title;
			$task->description = is_null($request->description) ? $task->description : $request->description;
			$task->due_date = is_null($request->due_date) ? $task->due_date : $request->due_date;
			$task->save();

			return response()->json([
				"message" => "records updated successfully",
				"task"    => $task
			], 200);
		} else {
			return response()->json([
				"message" => "task not found"
			], 404);
		}
	}

	public function deleteTask($id)
	{
		if (Task::where('id', $id)->exists()) {
			$task = Task::find($id);
			$task->delete();

			return response()->json([
				"message" => "records deleted"
			], 202);
		} else {
			return response()->json([
				"message" => "Task not found"
			], 404);
		}
	}
}
