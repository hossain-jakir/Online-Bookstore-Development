<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Address;
use App\Models\Country;
use App\Services\ServeImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends MainController
{
    public function index(Request $request){
        $data = parent::frontendItems($request);

        $user = User::find(auth()->user()->id);
        if(!$user){
            return redirect()->route('home');
        }
        $data['user'] = $user;
        $data['user']['image'] = ServeImage::image($user->image, 'grid');

        return view('Frontend.Profile.index')->with('data', $data);
    }

    public function update(Request $request){
            $validator = Validator::make($request->all(),
                [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'dob' => 'required|date|before:today',
                    'email' => 'required|string|email|max:255|unique:users,email,'.auth()->user()->id,
                    'phone' => 'required|string|max:255',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

        // dd($request->all());
        $user = User::find(auth()->user()->id);
        if(!$user){
            Session::flash('error', 'Something went wrong.');
            return redirect()->route('home');
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->dob = $request->dob;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if($request->hasFile('image')){
            $date = date('YmdHis');
            $image = $request->file('image');
            $file_name = time();
            $imageName = $file_name.'.'.$image->getClientOriginalExtension();
            $image->move(storage_path('app/public/images/users/'.auth()->user()->id .'/'. $date), $imageName);

            $thumbnails = [
                '_default' => ['width' => 200, 'height' => 200],
                '_grid' =>['width' => 250, 'height' => 250],
                '_large' =>['width' => 750, 'height' => 580],
            ];

            $path = storage_path('app/public/images/users/'.auth()->user()->id .'/'. $date .'/'. $imageName);
            foreach($thumbnails as $key => $thumbnail){
                $img = Image::make($path);
                $img->resize($thumbnail['width'], $thumbnail['height'], function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(storage_path('app/public/images/users/'.auth()->user()->id .'/'. $date .'/'. $file_name.$key.'.'.$image->getClientOriginalExtension()));
            }

            $user->image = 'images/users/'.auth()->user()->id .'/'. $date .'/'. $imageName;
        }

        $save = $user->save();

        if($save){
            return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
        }else{
            return redirect()->route('profile.index')->with('error', 'Something went wrong.');
        }
    }

    public function destroy(){
        $user = User::find(auth()->user()->id);
        if(!$user){
            Session::flash('error', 'Something went wrong.');
            return redirect()->route('home');
        }

        $update = $user->update(['isDeleted' => 'yes']);

        if($update){
            return redirect()->route('home')->with('success', 'Profile deleted successfully.');
        }else{
            return redirect()->route('profile.index')->with('error', 'Something went wrong.');
        }
    }

    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(),
            [
                'current_password' => 'required|string',
                'password' => 'required|string|min:6|confirmed',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $user = User::find(auth()->user()->id);
        if(!$user){
            Session::flash('error', 'Something went wrong.');
            return redirect()->route('home');
        }

        // verify password in hash
        if(!Hash::check($request->current_password, $user->password)){
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->password);

        $save = $user->save();

        if($save){
            return redirect()->route('profile.index')->with('success', 'Password updated successfully.');
        }else{
            return redirect()->route('profile.index')->with('error', 'Something went wrong.');
        }
    }

    public function address(Request $request){
        $data = parent::frontendItems($request);

        $user = User::find(auth()->user()->id);
        if(!$user){
            return redirect()->route('home');
        }
        $data['user'] = $user;
        $data['user']['image'] = ServeImage::image($user->image, 'grid');
        $data['address'] = Address::where('user_id', auth()->user()->id)->where('isDeleted', 'no')->where('status', 'active')->latest()->get();
        $data['countries'] = Country::where('status', 'active')->where('isDeleted', 'no')->get();
        // dd($data['user']['address']);

        return view('Frontend.Profile.address')->with('data', $data);
    }

    public function storeAddress(Request $request){
        $validator = Validator::make($request->all(),
            [
                'title' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'address_line_1' => 'required|string|max:255',
                'address_line_2' => 'nullable|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:10',
                'country' => 'required|exists:countries,id',
                'phone_number' => 'required|string|max:15',
                'type' => 'required|string|in:shipping,billing',
                'is_default' => 'nullable',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $address = new Address();
        $address->user_id = auth()->id();
        $address->title = $request->title;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->address_line_1 = $request->address_line_1;
        $address->address_line_2 = $request->address_line_2;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->zip_code = $request->zip_code;
        $address->country_id = $request->country;
        $address->phone_number = $request->phone_number;
        $address->type = $request->type;
        $address->is_default = $request->is_default ? 1 : 0;
        $save = $address->save();

        if($request->is_default ){
            Address::where('user_id', auth()->id())->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        if($save){
            return redirect()->route('profile.address')->with('success', 'Address added successfully.');
        }else{
            return redirect()->route('profile.address')->with('error', 'Something went wrong.');
        }
    }

    public function deleteAddress(Request $request, $id){
        // Find the address by ID
        $address = Address::find($id);

        // Check if the address exists and belongs to the authenticated user
        if (!$address || $address->user_id != auth()->id()) {
            return redirect()->route('profile.address')->with('error', 'Address not found or access denied.');
        }

        // Mark the address as deleted
        $address->isDeleted = 'yes';
        $save = $address->save();

        // If save is successful
        if ($save) {
            // Check if the deleted address was the default address
            if ($address->is_default) {
                // Try to find another active, not deleted address for the user
                $newDefaultAddress = Address::where('user_id', auth()->id())
                    ->where('isDeleted', 'no')
                    ->where('status', 'active')
                    ->first();

                // Set it as the new default address if found
                if ($newDefaultAddress) {
                    $newDefaultAddress->is_default = true;
                    $newDefaultAddress->save();
                }
            }

            return redirect()->route('profile.address')->with('success', 'Address deleted successfully.');
        } else {
            return redirect()->route('profile.address')->with('error', 'Something went wrong while deleting the address.');
        }
    }

    public function updateDefaultAddress(Request $request){
        $addressId = $request->input('address_id');
        $userId = auth()->id();

        // Find the address and validate ownership
        $address = Address::where('id', $addressId)
            ->where('user_id', $userId)
            ->where('isDeleted', 'no')
            ->where('status', 'active')
            ->first();

        if (!$address) {
            return response()->json([
                'status' => 'error',
                'message' => 'Address not found or access denied.'
            ]);
        }

        // Remove default status from all user's addresses
        Address::where('user_id', $userId)
            ->where('isDeleted', 'no')
            ->update(['is_default' => false]);

        // Set the selected address as default
        $address->is_default = true;
        $address->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Default address updated successfully.'
        ]);
    }


}
