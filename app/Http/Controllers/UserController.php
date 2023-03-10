<?php

namespace App\Http\Controllers;

use App\Models\chat;
use App\Models\Follow;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //
    public function uploadGambar(Request $r)
    {
        try {
            $img=$r->file("uploaded_file");
            Storage::putFileAs('public/user/',$img,$img->getClientOriginalName());
            $id=strtok($img->getClientOriginalName(),".");
            $user=User::find($id);
            $user->image=Storage::url('public/user/'.$img->getClientOriginalName());
            $user->save();
        } catch (\Throwable $th) {
            return makeJson("error",$th->getMessage(),null);
        }
    }
    public function getUsers(Request $r){
        $id = $r->id;
        $email = $r->email;
        $password = $r->password;

        try {
            $usr = User::all();
            if($id != null){
                $usr = $usr->where("id",$id);
            }
            if($email != null){
                $usr = $usr->where("email",$email);
            }
            if($password != null){
                $arr = [];
                foreach ($usr as $k => $v) {
                    if(Hash::check($password, $v->password)){
                        array_push($arr, $v);
                    }
                }
                $usr = $arr;
            }else{
                $usr = $usr->values();
            }
            return makeJson(200, "Success get user", $usr);
        } catch (\Throwable $th) {
            return makeJson(400, $th->getMessage(), null);
        }
    }

    public function searchUser(Request $r){
        $name = $r->name;
        $email = $r->email;
        try {
            $usr = User::where("name","like","%".$name."%")->where("email","like","%".$email."%")->get();
            $usr = $usr->values();
            return makeJson(200, "Success get user",$usr);
        } catch (\Throwable $th) {
            return makeJson(400, $th->getMessage(), null);
        }
    }
    public function getFriends(Request $r)
    {
        $id=$r->id;
        $chat=chat::where("user_id",$id)
        ->orwhere("recipient_id",$id)
        ->get();
        $friend=[];
        foreach ($chat as $key => $c) {
            array_push($friend,($id==$c->user_id) ? User::find($c->recipient_id) : User::find($c->user_id));
        }
        return makeJson(200,"Berhasil ambil data teman",$friend);
    }
    public function getNewFriend(Request $r)
    {
        $id=$r->id;
        $chat=chat::where("user_id",$id)
        ->orwhere("recipient_id",$id)
        ->get();
        $friend=[];
        foreach ($chat as $key => $c) {
            array_push($friend,($id==$c->user_id) ? User::find($c->recipient_id)->id : User::find($c->user_id)->id);
        }
        $follow=[];
        $followed=Follow::where("user_id",$id)->orWhere("follow_id",$id)->get();
        foreach ($followed as $key => $c) {
            array_push($follow,($id==$c->user_id) ? User::find($c->follow_id)->id : User::find($c->user_id)->id);
        }
        $new=User::whereNotIn('id',$friend)
        ->whereIn('id',$follow)
        ->whereNot('id',$id)
        ->get();
        return makeJson(200,"Berhasil ambil data teman baru",$new);
    }

    public function register(Request $r){
        $usr_exist = User::where("email",$r->email)->get();
        if(count($usr_exist) > 0){
            return makeJson(400, "Error, email already used!", null);
        }

        try {
            $user=new User;
            $user->name = $r->name;
            $user->email = $r->email;
            $user->type = $r->type;
            $user->password = Hash::make($r->password);

            $user->notelp = $r->notelp;

            $user->save();

            return makeJson(200, "Register Success", [$user]);
        } catch (\Throwable $th) {
            return makeJson(400, $th->getMessage(), null);
        }
    }

    public function editProfile(Request $r){


        $tempdate = null;
        $user = User::find($r->id);
        if ($user->type == "1") {
            # code...
            try {
                //code...
                if($r->tgllahir != null){
                    $tempdate = Carbon::createFromFormat('Y-m-d',$r->tgllahir);
                    $user->birthdate = $tempdate;
                }


                $user->name = $r->name;
                $user->description = $r->description;
                $user->notelp = $r->notelp;
                $user->gender = $r->gender;
                $user->lokasi = $r->negara;

                $user->save();
                return makeJson(200, "Edit Success", [$user]);
            } catch (\Throwable $th) {
                //throw $th;
                return makeJson(400, "Format tanggal lahir tidak sesuai", null);
            }
        }
        else{
            try {
                //code...
                if ($r->founded != null) {
                    # code...
                    $tempdate = Carbon::createFromFormat('Y-m-d',$r->founded);
                    $user->founded = $tempdate;
                }

                $user->name = $r->name;
                $user->description = $r->description;
                $user->notelp = $r->notelp;
                $user->lokasi = $r->negara;

                $user->industry = $r->industry;
                $user->save();
                return makeJson(200, "Edit Success", [$user]);

            } catch (\Throwable $th) {
                //throw $th;
                return makeJson(400, "Format tanggal didirikan tidak sesuai", null);
            }
        }


    }
}
