@extends('common.master')

@section('content')

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>Carousel Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/carousel/carousel.css" rel="stylesheet">
  </head>

    <!-- Carousel
    ================================================== -->

  {{ View::make('common.newsfeedPost')->with('post', $questions[0]) }}

  <div class="well">
      @foreach ($questions[0]->comments as $comment)
        <p>{{$comment->content}}</p>
        <p>Posted by {{$comment->user->first}} {{$comment->user->last}} at {{$comment->created_at}}</p>
      @endforeach
    </div>

    <div class="well">
      {{ Form::open(array('url' => 'createComment', 'method'=>'post')) }}

      {{ Form::textarea('content', 'hello world') }}

      {{ Form::hidden('user_id', $user->id) }}

      {{ Form::hidden('post_id', $questions[0]->id) }}

      {{ Form::submit('Comment', array('class' => 'btn btn-lg btn-primary btn-block')) }}
    </div>
  </body>
</html>

@stop