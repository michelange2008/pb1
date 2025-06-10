@extends('layouts.app')

@extends('menus.menuprincipal')

@extends('aide.aide_detail')

@extends('menus.sousmenu', ['titre' => 'Synthèse des observations'])

@section('contenu')
<div class="container-fluid">
  @foreach($themes as $theme)

  <?php $affiche = true;
  $i = 0;  ?>
    @foreach($saisie->salertes as $sAlerte)
      @if($sAlerte->alerte->theme->id === $theme->id)
      <?php $affiche = false;
        $i++;?>

      @endif
    @endforeach
    <div class="row justify-content-center">
      <div class="col-md-10">
        @if($affiche)
          <div class="alert detail detail-otobleu">
            <div class="d-flex flex-row align-items-center">
              <img class="img-40" src="{{asset(config('chemins.saisie')).'/'.$theme->icone}}" alt="">
              <h5 class="text-nowrap">{{$theme->nom}}</h5>
            </div>
            <div class="icones">
              <img class="otoveil" src="{{asset(config('chemins.saisie'))}}/ok.svg" alt="ok" />
            </div>
          </div>

        @else
          <div id="alert_{{$theme->id}}" class="deplie alert detail detail-otorange">

            <div class="d-flex flex-row align-items-center">
              <img class="img-40" src="{{asset(config('chemins.saisie')).'/'.$theme->icone}}" alt="">
              <h5>{{$theme->nom}} ({{$i}})</h5>
            </div>
            <div class="icones">
              <img src="{{asset(config('chemins.saisie'))}}/deplie.svg" alt="deplie" class="icone otoveil" title="affiche les alertes" />
            </div>
          </div>

          <div  id="origine_{{$theme->id}}" class="non-affiche">
            @foreach($saisie->salertes as $sAlerte)
              @if($sAlerte->alerte->theme->id === $theme->id)
                <input type="hidden" id="route_{{$sAlerte->id}}" action ="{{route('lecture.observations', $sAlerte->id)}}" />
                <div class="panneau-alerte alert alert-dark bg-otojaune rounded-0">
                  <div class="intitule-alerte">
                    <p class="">{{$sAlerte->alerte->nom}}</p>
                  </div>
                  <div class="element-alerte justify-content-between">
                    <div class="d-flex">

                      <p>
                        @if($sAlerte->alerte->type === 'liste')
                          <span class="text-danger font-weight-bold">
                            <?php
                            foreach($sAlerte->alerte->critalertes as $crit)
                            {
                              if($crit->valeur == $sAlerte->valeur)
                              echo $crit->nom;
                            }
                            ?>
                          </span>
                        @else
                          <span class="font-weight-bold">{{$sAlerte->valeur}} {{$sAlerte->alerte->unite}}</span>
                        @endif
                      </p>
                      @if($sAlerte->alerte->type !== 'liste')
                        <p>
                          @if($sAlerte->alerte->niveau === 0)
                            &nbsp&nbsp({{$sAlerte->alerte->niveau}} {{$sAlerte->alerte->unite}})
                          @else
                            @if($sAlerte->alerte->modalites === 'inverse')
                              &nbsp&nbsp( > {{$sAlerte->alerte->niveau}} {{$sAlerte->alerte->unite}})
                            @else
                              &nbsp&nbsp( < {{$sAlerte->alerte->niveau}} {{$sAlerte->alerte->unite}})
                            @endif
                          @endif
                        </p>
                      @endif
                    </div>
                    <img id = "icone-origine_{{$saisie->id}}_{{$sAlerte->id}}" src="{{asset(config('chemins.saisie'))}}/oeil.svg" alt="origine" class="affiche-origine otoveil curseur" />
                  </div>

                </div>

              @endif
            @endforeach
          </div>
        @endif
      </div>
    </div>
      @endforeach
    <div class="row mb-3">
      <div class="col-md-1"></div>
      <div class="col-md-10 d-flex justify-content-end">
        <a id="listeOrigines" href="{{route('lecture.originesListe', session()->get('saisie_id'))}}" class="btn btn-otojaune rounded-0 mr-1"><i class="fas fa-align-right"></i> Liste des origines</a>
        <a href="{{route('accueil')}}" class="btn btn-otobleu rounded-0"><i class="fas fa-undo-alt"></i> Retour à l'accueil</a>
      </div>
    </div>
    </div>
@endsection
