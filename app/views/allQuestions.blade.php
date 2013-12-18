@extends('common.master')

@section('content')

@foreach ($questions as $question)
    {{ View::make('common.csQuestionDetails')->with('question', $question) }}
@endforeach

@stop