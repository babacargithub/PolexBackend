<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartiRequest;
use App\Http\Requests\UpdatePartiRequest;
use App\Models\Parti;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class PartiController extends Controller
{


    /**
     * promote a user
     *
     * @param User $user
     * @return User
     */
    public function promoteUser(User $user)
    {
        if (! request()->user()->hasRole('owner')){
            abort(403,"Vous n'êtes pas autorisé à désigner un admin !");
        }

        $user->assignRole("owner");
        $user->save();
        $user->tokens()->delete();

        return $user;
    }
    public function disableUser(User $user): User
    {
        //
        $validated = request()->validate(["disabled"=>"required|bool"]);
        if (! request()->user()->hasRole('owner')){
            abort(403,"Vous n'êtes pas autorisé à désactiver un utilisateur !");
        }
        $user->disabled = $validated["disabled"];
        $user->save();
        $user->tokens()->delete();
        return $user;
    }
    public function resetUserPassword(User $user): User
    {
        if (! request()->user()->hasRole('owner')){
            abort(403,"Vous n'êtes pas autorisé à réinitialiser un mot de passe !");
        }
        $user->password = Hash::make("0000");
        $user->save();
        $user->tokens()->delete();
        return $user;
    }
    public function userAddRole(User $user, $role): User
    {
        if (! request()->user()->hasRole('owner')){
            abort(403,"Vous n'êtes pas autorisé à réinitialiser changer le rôle d'un utilisateur !");
        }
        $user->assignRole($role);
        $user->save();
        $user->tokens()->delete();

        return $user;
    }
    public function removeUserRole(User $user, $role): User
    {
        if (! request()->user()->hasRole('owner')){
            abort(403,"Vous n'êtes pas autorisé à réinitialiser changer le rôle d'un utilisateur !");
        }
        $user->removeRole($role);
        $user->save();
        $user->tokens()->delete();

        return $user;
    }
    public function deleteUser(User $user): JsonResponse
    {
        if (! request()->user()->hasRole('superadmin')){
            abort(403,"Vous n'êtes pas autorisé à supprimer un utilisateur ! \n Vous pouvez le désactiver plutôt");
        }
        $user->delete();

        return \response()->json(["message"=>"deleted"],204);
    }


}
