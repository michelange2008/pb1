@extends('layouts.pdf')

@section('contenu')
<br />
<div class="entete">
  <img src="{{asset(config('chemins.images'))}}/otoveil.jpeg" alt="otoveil" class="logo">
  <h1 class="pdf-titre">PANSE-BÊTES</h1>
  </div>
</div>

<div>
    <h1 style="color:darkslategrey">{{$saisie->elevage->nom}} - {{$saisie->espece->nom}}</h1>
    <h3 class="pdf-sous-titre">Saisie du {{$saisie->created_at->day}}/{{$saisie->created_at->month}}/{{$saisie->created_at->year}}</h3>
</div>
<!-- Affichage par Categorie -->
<div class="row mt-3">
  <h2>Résultats globaux</h2>
  @foreach ($categories as $categorie)
    <?php $afficheCat = true;
    $i = 0;  ?>
    @foreach($saisie->salertes as $sAlerte)
      @foreach ($sAlerte->sorigines as $sorigines)
        @if($sorigines->origine->categorie_id === $categorie->id)
          <?php $afficheCat = false;
          $i++;?>
        @endif
      @endforeach
    @endforeach

    @if (!$afficheCat)
      <div class="theme theme-pb">
        <h3>{{mb_strtoupper($categorie->nom)}}</h3>
        @foreach($saisie->salertes as $sAlerte)
          <div class="question">
            @foreach ($sAlerte->sorigines as $sorigines)
              @if($sorigines->origine->categorie_id === $categorie->id)
                  <p>{{$sorigines->origine->reponse}}</p>
                @endif
            @endforeach
        </div>
        @endforeach
      </div>
    @endif
  @endforeach
</div>

<div class="page-break"></div>

<!-- Affichage par Pole -->
<div class="row mt-3">
  <h2>Résultats par pôle</h2>
  @foreach($themes as $theme)

    <?php $affiche = true;
    $i = 0;  ?>
    @foreach($saisie->salertes as $sAlerte)
      @if($sAlerte->alerte->theme->id === $theme->id)
        <?php $affiche = false;
        $i++;?>
      @endif
    @endforeach

    @if($affiche)
      <div class="theme theme-ok">
        <h3>{{mb_strtoupper($theme->nom)}} (OK)</h3>
      </div>

    @else

      <div class="theme theme-pb">
        <h3>{{mb_strtoupper($theme->nom)}}</h3>
        @foreach($saisie->salertes as $sAlerte)
          @if($sAlerte->alerte->theme->id === $theme->id)
            <div class="intitule-alerte">
              <h4 class="">{{ucfirst($sAlerte->alerte->nom)}}
                <span style="color:red" >
                  @if($sAlerte->alerte->type !== "liste")
                    : {{$sAlerte->valeur}} {{$sAlerte->alerte->unite}}
                </span>
                <span style="color:darkslategrey">
                  (seuil: {{$sAlerte->alerte->niveau}} {{$sAlerte->alerte->unite}})
                </span>
                  @else
                <span style="color:red">
                  : {{$sAlerte->alerte->critalertes[$sAlerte->valeur]->nom}}
                </span>
                  @endif()
              </span>
              </h4>
              <div class="question">
                @foreach($sAlerte->sorigines as $sorigine)
                  <p style="font-weight:light">
                    {{$sorigine->origine->reponse}}
                  </p>
                @endforeach
              </div>
            </div>
          @endif
        @endforeach
      </div>

    @endif
    <br />
  @endforeach

</div>

@endsection
