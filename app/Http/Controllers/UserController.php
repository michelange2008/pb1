<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\Accepte;
use Mail;
use App\Models\Espece;
use App\Models\User;
use App\Models\Saisie;
use App\Models\Inscription;

class UserController extends Controller
{

  public function __construct()
  {
    $this->middleware('isAdmin');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(!Auth::user()->admin)
      {
        return view('accueil', [
          'especes' => Espece::all(),
        ]);
      }
      else
      {
        $users =User::orderBy('admin', 'desc')->get();
        $saisies_groupees = Saisie::all()->mapToGroups(function($item, $key) {
          return [$item['user_id'] => $item['id']];
        });
        $users_saisies = $saisies_groupees->keys();

        foreach ($users as $user) {

          if(!$users_saisies->contains($user->id))
          {
            $saisies_groupees->put($user->id, collect([]));
          }
        }
        return view('admin/admin', [
          'users' => $users,
          'saisies_groupees' => $saisies_groupees,
        ]);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return redirect()->route('utilisateur.index');
    }

    /**
     * Création d'un nouvel utilisateur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // validation de la saisie
        $datas = request()->validate([
          'nom' => 'required|max:191',
          'email' => 'required|email|max:191|unique:users',
          'mot_de_passe' => 'required|min:6',
          'retapez_votre_mot_de_passe' => 'required|min:6|same:mot_de_passe',
          'profession' => 'max:191',
          'region' => 'max:191',
          'captcha' => 'required|in:agriculture biologique, agriculture bio',
        ]);

      // création de l'utilisateur
        $datas = $request->all();
        $user = new User();
        $user->name = $datas['nom'];
        $user->email = $datas['email'];
        $user->password = bcrypt($datas['mot_de_passe']);
        $user->valide = $datas['valide'];
        $user->profession = $datas['profession'];
        $user->region = $datas['region'];
        $user->save();
        return response()->json([
          "id" => $user->id,
          "nom" => $user->name,
          "email" => $user->email
        ]);
    }

    /**
    * Rend valide un user
    **/
    public function valideUser($user_id)
    {
      // On change la statut non valide de l'user
      $user = User::find($user_id);
      $user->valide = 1;
      $user->save();

      // On lui envoie un mail
      Mail::to($user)->bcc(auth()->user())->send(new Accepte($user));

      return response()->json([
        "id" => $user->id,
        "nom" => $user->name,
        "email" => $user->email,
      ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('utilisateur.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      return redirect()->route('utilisateur.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $datas = $request->all();
      $user = User::find($id);
      $user->name = $datas['nom'];
      $user->email = $datas['email'];
      $user->save();
      return response()->json([
        "id" => $user->id,
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);

        return response()->json(['message' => $id]);
    }

    public function tousSauf($id)
    {
      $users = User::select('id', 'name')->where('id', '!=', $id)->get();

      return response()->json(json_encode($users));
    }

    public function changeSaisieUser($ancien_user_id, $nouveau_user_id)
    {
      $saisies = Saisie::where('user_id', $ancien_user_id)->get();
      foreach ($saisies as $saisie) {
        $saisie->user_id = $nouveau_user_id;
        $saisie->save();
      }

      return response()->json(["nombre_saisies" => Saisie::where('user_id', $nouveau_user_id)->count()]);
    }
}
