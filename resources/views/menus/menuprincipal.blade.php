@section('menuprincipal')
<div id="app">
  <nav class="navbar navbar-nav navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container-fluid flex-nowrap">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuAver" aria-controls="menuAver" aria-expanded="false" aria-label="Toggle-navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="decalage collapse navbar-collapse menu-on-right" id="menuAver">
      <ul class="nav navbar-nav navbar-left">
              <!-- Authentication Links -->
              @if (Auth::guest())
                  <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Se connecter</a></li>
              @else
                  <li class="nav-item dropdown">
                      <a href="#" class="nav-link dropdown-toggle bg-otobleu" id="utilisateur" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                          {{ Auth::user()->name }}

                      </a>

                      <div class="dropdown-menu" aria-labelledby="utilisateur">
                        <a class="dropdown-item" href="{{ route('login') }}"
                              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                              Déconnection
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        </div>
                    </li>
                @endif
                <div class="dropdown-divider"></div>
                <li class="nav-item" title="Pour démarrer"><a class="nav-link" href="{{route('accueil')}}">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('aide')}}">Aide</a></li>
                @if (!Auth::user()->admin)
                  <li class="nav-item"><a class="nav-link" href="{{route('notes.create')}}">Votre avis</a></li>
                @endif
                <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle" id="infos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      A propos
                  </a>
                  <div class="dropdown-menu" aria-labelledby="infos">
                    <a class="dropdown-item" href="{{route('instructions')}}">Panse-Bêtes&nbsp?</a>
                    <a class="dropdown-item" href="{{route('description')}}">Otoveil&nbsp?</a>
                    <a class="dropdown-item" href="{{route('credits')}}">Qui a fait quoi&nbsp?</a>
                    <a class="dropdown-item" href="{{route('contact')}}">Nous contacter</a>
                    <a class="dropdown-item" href="{{route('mentions_legales')}}">Mentions légales</a>
                  </div>
                </li>
                @if (Auth::user()->admin)
                  <li class="nav-item"><a class="nav-link" href="{{route('admin.index')}}">Administration</a></li>
                @endif

      </ul>
    </div>
    <a class="navbar-brand" href="{{ url('/') }}">
      {{ config('app.name', 'Panse-bêtes') }}
    </a>
    <img src="{{asset(config('chemins.images'))}}/itab_otoveil.jpeg" alt="otoveil" class="otoveil"/>
    </div>
  </nav>
</div>
</div>
<br />
@endsection()
