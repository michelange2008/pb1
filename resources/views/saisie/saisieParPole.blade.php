@extends('layouts.app')

@extends('menus.menuprincipal')

@extends('aide.aide_alertes')

@extends('menus.sousmenu', ['titre' => 'Saisie des observations'])

@section('contenu')

  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-11">
        <div class="bg-otobleu titre d-flex p-2">
          <img src="{{asset(config('chemins.saisie')).'/'.session()->get('theme')->icone}}" alt="{{session()->get('theme')->nom}}" class="otoveil">
          <h3 class="pl-2">{{ucfirst(session()->get('theme')->nom)}}</h3>
        </div>
      </div>
    </div>

    @if($errors->any())
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="alert alert-danger">

            <strong>Oups, nous n'avons pas pu valider votre saisie pour la raison suivante</strong>

            <ul class="list-unstyled">
              @foreach($errors->all() as $error)

                <li>
                  {{ $error }}
                </li>

              @endforeach
            </ul>
          </div>
        </div>
      </div>
    @endif
    {{Form::open(['route' => 'saisie.enregistre'])}}
    <div class="row justify-content-center">
      <div class="col-md-10">

        @foreach($alertes as $alerte)

          <?php
          $value ="";
          $attention = "";
          foreach ($sAlertes as $sAlerte ) {
            if($sAlerte->alerte_id === $alerte->id)
            {
              $value = $sAlerte->valeur;
              $attention = "attention";
            }
          }
          ?>

          <div class="affiche alerte-item">
            <p class="{{$attention}}">{{ucfirst($alerte->nom)}}</p>
            <div>
              @if($alerte->type = "liste" && $alerte->critalertes->count() > 0)
                <?php // construction du tableau pour la liste déroulante
                $liste = [];
                foreach($alerte->critalertes as $crit){
                  $liste[] = $crit->nom;
                }
                ?>
                {{Form::select('alerte_'.$alerte->id, $liste, $value)}}
              @else()
                <input
                name="alerte_{{$alerte->id}}"
                type="number"
                placeholder="{{ old('alerte_'.$alerte->id) }}"
                class="zone-saisie"
                value = "{{$value}}"
                />
                {{Form::label('alerte_'.$alerte->id, $alerte->unite)}}

              @endif()
            </div>

          </div>

        @endforeach()
      </div>
    </div>
    <div class="row">
      <div class="col-md-11 d-flex justify-content-end">
        <button type="submit" class="btn btn-otorange rounded-0">
          <i class="fas fa-share-square"></i> Envoyer
        </button>
        <a href="{{route('saisie.type', config('constantes.pol'))}}" class="btn btn-otobleu rounded-0 ml-2" title="revenir à la liste"><i class="fas fa-undo-alt"></i> Retour</a>
      </div>
      <div class="col-md-1"></div>
      {{Form::close()}}
    </div>
  </div>

@endsection()
