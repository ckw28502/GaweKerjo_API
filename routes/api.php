<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
    // return User::all();
// });


////////////////
// USER
////////////////

Route::get("/users",[UserController::class, "getUsers"]);
Route::post("/register",[UserController::class, "register"]);

// Route::post('/register', function (Request $r) {
//     $user=new User;
//     $user->name=$r->name;
//     $user->email=$r->email;
//     $user->password=$r->password;
//     $user->save();
//     return $user;
// });

////////////////

////////////////
// POST
////////////////
Route::get("/posts",[PostController::class,"getPosts"]);
Route::post("/addpost",[PostController::class,"addPost"]);

Route::get("/postlikes",[PostController::class,"getPostLikes"]);
Route::post("/addlike",[PostController::class,"addPostLike"]);
////////////////

////////////////
// EDUCATION
////////////////
Route::get("/educations",[UserController::class, "getEducations"]);
Route::post("/addeducation",[UserController::class, "addEducation"]);
////////////////

////////////////
// ACHIEVEMENT
////////////////
Route::get("/achievements",[AchievementController::class, "getAchievements"]);
Route::post("/addachievement",[AchievementController::class, "addAchievement"]);
////////////////

////////////////
// SKILL
////////////////
Route::get("/skills",[SkillController::class, "getSkills"]);
Route::get("/userskill",[SkillController::class, "getUserSkill"]);
Route::post("/adduserskill",[SkillController::class, "addUserSkill"]);
////////////////

////////////////
// CHATS
////////////////
Route::get("/chats",[ChatController::class, "getHChats"]);
Route::get("/userchat",[ChatController::class, "getDChats"]);
Route::post("/addchat",[ChatController::class, "addHchat"]);
Route::post("/adduserchat",[ChatController::class, "addDchat"]);

////////////////
// COMMENT
////////////////
Route::get("/comments",[CommentController::class, "getComments"]);
Route::post("/addcomments",[CommentController::class, "addComment"]);
////////////////

////////////////
// ORGANIZATIONS
////////////////
Route::get("/organizations",[OrganizationController::class, "getOrganizations"]);
Route::post("/addorganizations",[OrganizationController::class, "addOrganization"]);
////////////////