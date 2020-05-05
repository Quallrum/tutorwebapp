<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\SubjectType;

class SubjectController extends Controller{

	public function index(){
		$this->authorize('subject.list');

		$subjects = Subject::all();

		return view('subject.index')->with([
			'subjects'	=> $subjects,
		]);
	}

	public function create(){
		//
	}

	public function store(Request $request){
		//
	}

	public function edit(Subject $subject){
		$this->authorize('subject.edit');

		return view('subject.form')->with([
			'action'	=> route('subject.update', ['subject' => $subject->id]),
			'method'	=> 'put',
			'subject'	=> $subject,
			'types'		=> SubjectType::all(),
			'tutors'	=> $subject->tutors,
			'allTutors'	=> $subject->otherTutors(),
		]);
	}
	
	public function update(Request $request, $id){
		//
	}

	public function attachTutor(Request $request, Subject $subject){
		$this->authorize('subject.edit');
		$data = $request->validate([
			'tutor'	=> ['required', 'integer', 'exists:tutors,user_id'],
		]);
		
		$subject->tutors()->attach($data['tutor']);
		
		if($subject->hasTutor($data['tutor']))	return response()->json(['message' => 'Attached!'], 200);
		else									return response()->json(['message' => 'Failed!'], 500);
	}

	public function detachTutor(Request $request, Subject $subject){
		$this->authorize('subject.edit');
		$data = $request->validate([
			'tutor'	=> ['required', 'integer', 'exists:tutors,user_id'],
		]);
		
		$subject->tutors()->detach($data['tutor']);
		
		if(!$subject->hasTutor($data['tutor']))	return response()->json(['message' => 'Detached!'], 200);
		else									return response()->json(['message' => 'Failed!'], 500);
	}

	public function destroy($id){
		//
	}
}
