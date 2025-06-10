@section('sousmenu')
  <div class="container-fluid">
    <div class="alert alert-success d-flex">
      <img class="img-40" src="{{asset(config('chemins.categories'))."/".$saisie->espece->icone}}" alt="">
      <h3 class="pl-3 text-truncate">{{$titre}} ({{$saisie->elevage->nom}} - <small>{{$saisie->created_at->month}} {{$saisie->created_at->locale('fr')->monthName}} {{$saisie->created_at->year}})</small></h3>
    </div>

  </div>
@endsection
