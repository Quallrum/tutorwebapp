@extends('layouts.app')

@section('title', 'Группы')

@section('head')
	<link rel="stylesheet" href="/css/main.min.css"/>
@endsection

@section('scripts')
	<script src="/js/chooseGroup.js"></script>
@endsection

@section('content')
	<section class="container-fluid chooseGroup">
		<div class="chooseGroup__window">
			<h2 class="chooseGroup__heading">Выберите группу</h2>
			@if ($groups and $groups->count())
				<div class="chooseGroup__items">
					@foreach ($groups as $group)
						<a class="chooseGroup__item" href="{{ route('group.edit', ['group' => $group->id]) }}">{{ $group->title }}</a>
					@endforeach
				</div>
			@else
				<p class="chooseGroup__null">Нет созданных групп</p>
			@endif
			<a class="chooseGroup__back" href="{{ route('home') }}">Назад</a>
		</div>
	</section>
@endsection