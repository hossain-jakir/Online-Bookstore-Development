<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Profile;
use App\Helpers\ImageHelper;
use App\Services\ServeImage;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Backend\BackendController;

class UserController extends Controller
{
    function index( Request $request ){

        $data = [];

        // get all the role except the super admin
        $data['roles'] = Role::where('name', '!=', 'super-admin')->get();

        $user = Auth::user();
        $data['user'] = $user;
        $data['permissions'] = $user->getAllPermissions()->pluck('name')->toArray();

        foreach ($data['roles'] as $role) {
            $role->hashId = Crypt::encrypt($role->id);
        }

        $Users = User::all();
        foreach ($Users as $user) {

            $data['users'][] = [
                'hashId' => Crypt::encrypt($user->id),
                'full_name' => $user->first_name . ' ' . $user->last_name,
                'role' => $user->getRoleNames()->first() ?? null,
                'phone' => $user->phone,
                'email' => $user->email,
                'status' => $user->status,
                'image' => ServeImage::profile($user,'main'),
                // 'permission' => Auth::user()->hasPermissionTo('admin.user.assign.role') ? true : false,
            ];
        }

        return view('Backend.pages.user.index')->with('data', $data);
    }

    function delete( Request $request, $id ){
        dd('Not implemented yet');

        // try{
        //     $id = Crypt::decrypt($id);

        //     $profile = Profile::where('user_id', $id)->first();
        //     $profile->is_deleted = 1;
        //     $profile->save();

        //     Session()->flash('success', 'User deleted successfully');
        //     return redirect()->route('admin.user.index');

        // }catch(\Exception $e){
        //     Session()->flash('error', 'Something went wrong');
        //     return redirect()->route('admin.user.index');
        // }
    }

}
