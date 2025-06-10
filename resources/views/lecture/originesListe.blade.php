@extends('layouts.app')

@extends('menus.menuprincipal')

@extends('aide.aide_origines')



@section('contenu')
<div class="container-fluid">
  <div class="bg-otorange titre rounded-0 ml-3 d-flex justify-content-between align-items-center" style="min-height:45px">
    <div class="d-flex align-items-center">
      <img class="img-resp" src="{{URL::asset(config('chemins.saisie'))}}/check.svg" alt="case cochée" class="">
      <p class="m-0 desktop-only">Questions cochées</p>
    </div>
    <h4 id="titreCat" class="text-truncate color-otobleu"><strong>Par catégories</strong></h4>
    <h4 id="titrePol" class="text-truncate color-otobleu" style="display:none"><strong>Par pôles</strong></h4>
    <button id="bascule" class="btn btn-otobleu mr-2" title="Basculer entre affichage par catégorie et affichage par pôle">
      <i class="fas fa-map-signs"></i> Catégories/Pôles
    </button>
  </div>
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
      <p id="aideBascule" class="text-muted text-center"><small>
        Vous pouvez basculer le type d'affichage (par catégorie ou par pôle) en cliquant sur le bouton au-dessus à droite.
      </small></p>
      <p id="aideDragDrop" class="text-muted text-center small" style="display:none">
        Vous pouvez réorganiser les pôles en les déplaçant de bas en haut avec la souris.
        Vous pouvez aussi les regrouper en les décalant vers la droite.
      </p>
    </div>
  </div>


  <div id="parCategorie" class="row">
    <div class="col-md-12">
      @foreach ($categories as $categorie)
        <div class="row m-3">
          <div class="col-md-2"></div>
          <div class="col-md-3 bg-otojaune d-flex flex-row align-items-center">
            <img class="img-75 p-2" src="{{asset(config('chemins.categories'))."/".$categorie->icone}}" alt="">
            <h6 class="lead text-center">{{ucfirst($categorie->nom)}}</h6>
          </div>
          <div class="col-md-5 bg-otobleu pt-2">
            @foreach ($sorigines as $sorigine)
              @if ($categorie->id == $sorigine->origine->categorie_id)
                <div class="row p-1 pl-3">
                  <p>{{ucfirst($sorigine->origine->reponse)}}</p>
                </div>
              @endif
            @endforeach
          </div>
        </div>
      @endforeach
    </div>

    </div>

  <div id="parPole" class="row m-3 justify-content-center" style="display:none">
    <div class="col-md-10">
      <div id="nestable2" class="dd">
        <ol class="dd-list">
          @foreach($sorigines as $sorigine)
            <li class="dd-item" data-id="{{$sorigine->id}}">
              <div class="dd-handle d-flex flex-row">
                <img src="{{asset(config('chemins.saisie')."/".$sorigine->salerte->alerte->theme->icone)}}" alt="-" class="img-handle">
                <p class="text-handle">
                  {{ucfirst($sorigine->origine->reponse)}}
                </p>
              </div>
            </li>
          @endforeach
        </ol>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-10 d-flex justify-content-end">
      <a href="{{route('pdf', $saisie->id)}}" target="_blank" class="btn btn-danger rounded-0 mr-1"><i class="far fa-file-pdf"></i> Voir le pdf</a>
      <a href="{{URL::previous()}}" class="btn btn-otobleu rounded-0 mr-1"><i class="fas fa-undo-alt"></i> Retour page préc.</a>
    </div>
  </div>
</div>

<!--<canvas id="scroll"></canvas>-->

@push('js')
  <script src="{{asset(config('chemins.js'))}}/jquery.nestable.js"></script>
  <script src="{{asset(config('chemins.js'))}}/liste_des_origines.js"></script>
@endpush
@endsection
