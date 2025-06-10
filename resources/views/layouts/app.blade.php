<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Panse-Bêtes') }}</title>
    <link rel="icon" href="{{asset('favicon.ico')}}" />
     <!-- Styles -->
    <link rel="stylesheet" href="{{asset(config('chemins.css'))}}/app.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css" />

    <!-- Matomo -->
      <script type="text/javascript">
        var _paq = window._paq || [];
        // require user consent before processing data
        _paq.push(['requireConsent']);
        _paq.push(['trackPageview']);
        // fin require user consent
          // Debut - Obligation CNIL
          _paq.push([function() {
              var self = this;
              function getOriginalVisitorCookieTimeout() {
                  var now = new Date(),
                  nowTs = Math.round(now.getTime() / 1000),
                  visitorInfo = self.getVisitorInfo();
                  var createTs = parseInt(visitorInfo[2]);
                  var cookieTimeout = 33696000; // 13 mois en secondes
                  var originalTimeout = createTs + cookieTimeout - nowTs;
                  return originalTimeout;
              }
              this.setVisitorCookieTimeout( getOriginalVisitorCookieTimeout() );
          }]);
          // Fin - Obligation CNIL
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
          var u="//panse-betes.fr/matomo/";
          _paq.push(['setTrackerUrl', u+'matomo.php']);
          _paq.push(['setSiteId', '1']);
          var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
          g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
        })();
      </script>
    <!-- End Matomo Code -->
</head>
<body>

        @yield('menuprincipal')
        @yield('menu')
        @yield('sousmenu')
        @yield('soustitre')
        @yield('contenu')
        @yield('aide')


    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    @stack('js')

    <script src="{{asset(config('chemins.js'))}}/bootstrap/bootstrap.min.js"></script>
    {{-- <script src="{{asset(config('chemins.js'))}}/pansebetes.js"></script> --}}
    <script src="{{asset(config('chemins.js'))}}/app.js"></script>

</body>
</html>
