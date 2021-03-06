<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Subject\SubjectRequest;
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
		$this->authorize('subject.create');

		return view('subject.form')->with([
			'action'	=> route('subject.store'),
			'method'	=> 'post',
			'subject'	=> new Subject,
			'types'		=> SubjectType::all(),
			'tutors'	=> [],
			'allTutors'	=> [],
		]);
	}

	public function store(SubjectRequest $request){
		$this->authorize('subject.create');

		$subject = (new Subject);
		$subject->title = $request->input('title');
		$subject->type_id = $request->input('type');

		if($subject->save())	return redirect()->route('subject.edit', ['subject' => $subject->id])->with('success', 'Created successful!');
		else 					return back()->withErrors('Creating failed!');
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
	
	public function update(SubjectRequest $request, Subject $subject){
		$this->authorize('subject.edit');

		$subject->fill($request->only('title'));
		$subject->type()->associate($request->input('type'));

		if($subject->save())	return response()->json(['message' => 'Updated!'], 200);
		else					return response()->json(['message' => 'Failed!'], 500);
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
