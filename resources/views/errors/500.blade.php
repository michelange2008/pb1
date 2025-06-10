@extends('layouts.app')


@section('contenu')

<div class="jumbotron">
  <h1 class="display-4">Désolé !</h1>
  <p class="lead">Il semble que vous vous soyez égarés dans les dédales de l'application</p>
  <hr class="my-4">
  <p>Mais n'ayez crainte, il vous suffira de cliquer sur le bouton ci-dessous pour trouver une issue.</p>
  <a class="btn btn-otobleu btn-lg" href="{{route('accueil')}}" role="button">Sortir</a>
</div>
@endsection
