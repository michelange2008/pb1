@extends('layouts.app')

@section('contenu')
  <div class="controller-fluid d-flex flex-column bg-otorange" style="height:94vh; justify-content:space-around">
    <video class="align-self-center m-1" controls="controls" preload="auto" style="max-width:100%; max-height:60vh" poster="{{asset(config('chemins.fichiers'))}}/{{$theme}}.png" >
      <source
        src="{{asset(config('chemins.fichiers'))}}/{{$theme}}.m4v" type="video/mp4" />
      Votre navigateur ne supporte pas le format video
    </video>
    <div class="d-sm-flex flex-row justify-content-around m-3">
      <div class="b-3 p-3 align-items-center border-left">
        <h5 class="mr-3">Voir la vidéo plus tard</h5>
        <a href="{{asset(config('chemins.fichiers'))}}/{{$theme}}.m4v" download="{{$theme}}">
          <button class="btn btn-otojaune rounded-0" type="button" name="button"><i class="fas fa-file-video"></i> télécharger (10M)</button>
        </a>
      </div>
      <div class="b-3 p-3 align-items-center border-left">
        <h5 class="mr-3">Voir le pdf correspondant</h5>
        <a href="{{asset(config('chemins.fichiers'))}}/{{$theme}}.pdf" download="{{$theme}}">
          <button class="btn btn-danger rounded-0" type="button" name="button"><i class="fas fa-file-pdf"></i> télécharger (3M)</button>
        </a>
      </div>
    </div>
    <div class="pr-3 align-self-end">
      <a href="{{route($route)}}">
        <button class="btn btn-lg btn-otobleu rounded-0" type="button" name="button"><i class="fas fa-undo-alt"></i> {{$bouton}}</button>
      </a>
    </div>
  </div>
@endsection
