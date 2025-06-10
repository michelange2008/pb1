/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

$(function () {
  // déplier les origines
  function deplie(id) {
    var alerte_id = id.split('_')[1];
    $('#origine_' + alerte_id).fadeToggle(); // déplie la liste des alertes

    $.each($('.ouvert'), function () {
      if ($(this).attr('class') == "non-affiche ouvert" && $(this).attr('id') !== 'origine_' + alerte_id) {
        $(this).fadeToggle(100);
        $(this).toggleClass('ouvert');
      }
    });
    $('#origine_' + alerte_id).toggleClass('ouvert');
  }
  // Quand on clique sur afficher, ça se déplie
  $('.afficher').on('click', function () {
    var id = $(this).attr('id');
    deplie(id);
  });
  // Pareil quand on clique sur déplie
  $('.deplie').on('click', function () {
    var id = $(this).attr('id');
    deplie(id);
  });
  // Alerte + ajax pour afficher les questions cochées
  $('.affiche-origine').on('click', function () {
    var alerte_id = $(this).attr('id').split('_')[2];
    var route = $('#route_' + alerte_id).attr('action');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.confirm({
      columnClass: 'large',
      theme: 'dark',
      buttons: {
        fermer: function fermer() {}
      },
      content: function content() {
        var self = this;
        return $.ajax({
          url: route,
          dataType: 'json',
          method: 'get'
        }).done(function (response) {
          var ligne = new Array();
          var i = 0;
          $.each(response, function (key, val) {
            ligne[i] = '<p>' + val + '</p>';
            i++;
          });
          self.setContentPrepend('<div class="bg-success">');
          self.setContent(ligne);
          self.setContentAppend('</div>');
          self.setTitle("Questions cochées");
        }).fail(function (response) {
          self.setTitle('Désolé');
          self.setContent('Il y a eu un problème');
        });
      }
    });
  });

  // suppression d'une saisie
  $('.supprime').on('click', function (e) {
    var id = '#' + $(this).attr('id');
    console.log(id);
    e.preventDefault();
    $.confirm({
      title: "Suppression",
      content: "Etes-vous sûr.e.s de vouloir supprimer définitivement cette saisie ?",
      type: 'red',
      columnClass: 'medium',
      theme: 'dark',
      buttons: {
        supprimer: {
          btnClass: 'btn-red',
          keys: ['enter'],
          action: function action() {
            window.location.href = $(id).attr('href');
          }
        },
        annuler: {
          keys: ['esc'],
          action: function action() {}
        }
      }
    });
  });
  // Nom pour une nouvelle saisie
  $('.nouvelle-saisie-item').on('click', function (e) {
    var espece_id = $(this).attr('id').split('_')[1];
    var route = $(this).attr('route');
    nouvelleSaisie(route, $(this).attr('name'), espece_id);
  });
  function nouvelleSaisie(route, nom, espece_id) {
    $.confirm({
      columnClass: 'large',
      title: 'Nouvelle saisie',
      content: '' + '<form action="" class="formName">' + '<div class="form-group">' + '<label>Si l\'élevage n\'appartient pas à la personne connectée, saisir son nom, sinon cliquez simplement sur Ok</label>' + '<input type="text" placeholder=' + nom + ' class="name form-control" required />' + '</div>' + '</form>',
      buttons: {
        formSubmit: {
          text: 'Ok',
          btnClass: 'btn-blue',
          action: function action() {
            var name = this.$content.find('.name').val();
            if (!name) {
              var name = nom;
            }
            window.location.href = route + '/saisie/nouvelle/' + name + '/' + espece_id;
          }
        },
        annuler: function annuler() {
          //close
        }
      },
      onContentReady: function onContentReady() {
        // bind to events
        var jc = this;
        this.$content.find('form').on('submit', function (e) {
          // if the user submits the form by pressing enter in the field.
          e.preventDefault();
          jc.$$formSubmit.trigger('click'); // reference the button and click it
        });
      }
    });
  }
  ;
  // Espèces non finies
  $('.choix').on('click', function (e) {
    var espece_nom = $(this).attr('id');
    $.alert({
      columnClass: 'large',
      theme: "dark",
      title: "Désolé !",
      content: "Le travail pour les <strong>" + espece_nom + "</strong> est encore en cours",
      buttons: {
        fermer: {
          text: "fermer",
          keys: ['enter', 'esc'],
          btnClass: 'btn-red'
        }
      }
    });
  });

  // Bascule voir le mot de passe
  $('.oeil').on('click', function () {
    $(this).toggleClass('oeil-ouvert');
    $(this).toggleClass('oeil-ferme');
    var type = $('#password').attr('type');
    if (type === 'password') {
      console.log(type);
      $('#password').attr('type', "text");
    } else {
      $('#password').attr('type', "password");
    }
  });

  // MENU AIDE
  $('#aide-rond').fadeIn().draggable({
    containment: '#aide',
    cursor: 'move',
    snap: '#aide'
  });
  $('.close').on('click', function () {
    $('.aide-contenu').fadeOut();
  });
  $('.aide-bouton').on('focusout', function () {
    $('.aide-contenu').fadeOut();
  });
  $('.aide-bouton').on('click', function () {
    $('.aide-contenu').fadeToggle();
  });
  $('.aide-bouton').on('blur', function () {
    $('.aide-contenu').fadeToggle();
  });
  $('#affiche-texte-d-1').on('click', function () {
    $('#texte-d-1').fadeToggle(0);
    $('#texte-d-2').fadeToggle(0);
  });
  $('#affiche-texte-d-2').on('click', function () {
    $('#texte-d-2').fadeToggle(0);
    $('#texte-d-1').fadeToggle(0);
  });
  $('#affiche-texte-s-1').on('click', function () {
    $('#texte-s-1').fadeToggle(0);
    $('#texte-s-2').fadeToggle(0);
  });
  $('#affiche-texte-s-2').on('click', function () {
    console.log('coucou');
    $('#texte-s-2').fadeToggle(0);
    $('#texte-s-1').fadeToggle(0);
  });
  // MENU ROND
  $('.bouton-rond').on('click', function () {
    $('.menu-item').fadeToggle();
    $('.aide-contenu').fadeOut();
  });
  $('.menu-item').on('click', function () {
    $('.menu-item').fadeToggle();
    var espece_id = $(this).attr('id').split('_')[1];
    var route = $(this).attr('route');
    nouvelleSaisie(route, $(this).attr('name'), espece_id);
  });
});

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/sass/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;