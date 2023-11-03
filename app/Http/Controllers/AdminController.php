<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
  View,
  Auth,
  DB,
  Validator,
  Session,
  Hash
};
use App\Models\{
  BlogPost,
  Partner,
  User,
  UserRole
};
use App\Traits\Helper;

class AdminController extends Controller
{
  use Helper;

  /**
   * Index
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\User $users
   * @param \App\Models\Report $reports
   * @param \App\Models\BlogPost $post
   * @param \App\Models\Partner $partner
   * 
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function index(Request $request, User $users, BlogPost $posts, Partner $partners)
  {
    try {
      return view::make('admin.index')->with([
        "admins" => $users->where('id', '!=', Auth::user()->id)->count(),
        "blog_posts" => $posts->count(),
        "partners" => $partners->count(),
      ]);
    } catch (\Exception $ex) {
      return redirect('/');
    }
  }

  /**
   * Profile
   * @param \Illuminate\Http\Request $request
   * 
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function profile(Request $request)
  {
    try {
      return view('admin.profile');
    } catch (\Exception $ex) {
      return redirect('/');
    }
  }

  /**
   * Update Profile
   * @param \Illuminate\Http\Request $request
   * 
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function updateProfile(Request $request)
  {
    try {
      $admin = Auth::user();

      # rules
      $rules = ['name' => 'required'];

      # validator
      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 403);
      }

      # validate admin
      $validateAdministrator = User::where('email', $admin->email)->first();

      if (!$validateAdministrator) {
        return response()->json([
          "status" =>  203,
          "message" => "Sorry, profile update could not be completed."
        ], 203);
      }

      if ($validateAdministrator && $validateAdministrator->id != $admin->id) {
        return response()->json([
          "status" => 203,
          "message" => "Email address already exist."
        ], 203);
      }

      # collect data
      $name = ucwords(strtolower($request->name));

      try {
        # update profile
        $validateAdministrator->update(['name' => $name, 'email' => $request->email]);

        return response()->json([
          "status" => 200,
          "message" => "Profile updated successfully."
        ], 200);
      } catch (\Exception $ex) {
        return response()->json([
          "status" => 203,
          "message" => "Sorry, profile update could not be completed."
        ], 203);
      }
    } catch (\Exception $ex) {
      return response()->json([
        "status" => 203,
        "message" => "Profile update failed. Please try again."
      ], 203);
    }
  }

  /**
   * Update Security
   * @param \Illuminate\Http\Request $request
   * 
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function updateSecurity(Request $request)
  {
    try {
      $admin = Auth::user();

      # rules
      $rules = [
        'old_password' => 'required',
        'password' => 'required|min:8|max:50',
        'password_confirmation' => 'same:password',
      ];

      # validator
      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 403);
      }

      # validate admin
      $validateAdministrator = User::where('email', $admin->email)->first();

      if (!$validateAdministrator) {
        return response()->json([
          "status" => 203,
          "message" => "Sorry, your account could not be verified."
        ], 203);
      }

      # collect data
      $old_password = $request->old_password;
      $new_password = $request->password;

      try {
        # compare passwords
        $previousPassword = $validateAdministrator->password;
        $checkPassword = Hash::check($old_password, $previousPassword);

        if (!$checkPassword) {
          return response()->json([
            "status" => 203,
            "message" => "Invalid old password supplied."
          ], 203);
        }

        # hash new password
        $password = Hash::make($new_password);

        # update password
        User::find($admin->id)->update(['password' => $password]);

        return response()->json([
          "status" => 200,
          "message" => "Password updated successfully."
        ], 200);
      } catch (\Exception $ex) {
        return response()->json([
          "status" => 203,
          "message" => "Sorry, password update could not be completed."
        ], 203);
      }
    } catch (\Exception $ex) {
      return response()->json([
        "status" => 203,
        "message" => "Sorry, an unknown error occurred."
      ], 203);
    }
  }

  /**
   * Logout
   * @param \Illuminate\Http\Request $request
   * 
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->forget('user');
    $request->session()->regenerate();
    return redirect()->to('/');
  }

  /**
   * Users
   * @param \Illuminate\Http\Request $request
   * 
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function users(Request $request)
  {
    try {
      $admin = Auth::user();
      if ($this->roleCheck("account") == false) return redirect()->route('admin.home');

      # users
      $users = User::with('user_role')->where('id', '!=', $admin->id)->orderBy('created_at', 'DESC')->get();

      return view::make('admin.users')->with([
        'admin' => $admin,
        'users' => $users,
        'roles' => $this->roles()
      ]);
    } catch (\Exception $ex) {
      return redirect()->back();
    }
  }

  /**
   * Register User
   * @param \Illuminate\Http\Request $request
   * 
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function registerUser(Request $request)
  {
    try {
      # rules
      $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'role' => 'required',
      ];

      # validator
      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 403);
      }

      # collate data
      $email = $request->email;
      $role = $request->role;

      # verify user email
      $verifyUserEmail = User::withTrashed()->where('email', $email)->first();

      # restore account if deleted
      if ($verifyUserEmail && $verifyUserEmail->deleted_at != null) {
        $verifyUserEmail->restore();
        $data = collect();
        $users = User::with('user_role')->where('id', '!=', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        $users->each(function ($user) use ($data) {
          $data->push(
            (object) [
              "id" => $user->id,
              "fullname" => $user->name,
              "email" => $user->email,
              "role" => ucwords(str_replace('_', ' ', $user->user_role->type))
            ]
          );
        });
        return response()->json([
          "status" => 201,
          "data" => $data,
          "message" => "User restored successfully."
        ], 201);
      }

      if ($verifyUserEmail) {
        return response()->json([
          "status" => 203,
          "message" => "A user with this email already exist."
        ], 203);
      }

      # define user rights
      $rights = $this->userRole($role);

      try {
        DB::transaction(function () use ($request, $rights) {
          # create account
          $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => 123456
          ]);

          # attach role to user
          $user->user_role()->create(["type" => $request->role, "role" => json_encode($rights)]);
        });

        $data = collect();
        $users = User::with('user_role')->where('id', '!=', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        $users->each(function ($user) use ($data) {
          $data->push(
            (object) [
              "id" => $user->id,
              "fullname" => $user->name,
              "email" => $user->email,
              "role" => ucwords(str_replace('_', ' ', $user->user_role->type))
            ]
          );
        });

        return response([
          "status" => 201,
          "data" => $data,
          "message" => "User registered successfully."
        ], 201);
      } catch (\Exception $ex) {
        return response()->json([
          "status" => 203,
          "message" => "User registration could not be completed. Try again."
        ], 203);
      }
    } catch (\Exception $ex) {
      return response()->json([
        "status" => 203,
        "message" => "User registration failed. Try again."
      ], 203);
    }
  }

  /**
   * Edit User
   * @param \Illuminate\Http\Request $request
   * 
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function editUser(Request $request)
  {
    try {
      # user
      $user = User::with('user_role')->findOrFail($request->user);

      return response()->json([
        "status" => 200,
        "data" => (object)[
          "id" => $user->id,
          "name" => $user->name,
          "email" => $user->email,
          "role" => $user->user_role->type
        ],
        "message" => "User record retrieved."
      ]);
    } catch (\Exception $ex) {
      return response()->json([
        "status" => 203,
        "message" => "An unknown error occurred."
      ], 203);
    }
  }

  /**
   * Update User
   * @param \Illuminate\Http\Request $request
   * 
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function updateUser(Request $request)
  {
    try {
      # rules
      $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'role' => 'required',
      ];

      # validator
      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 403);
      }

      # collate data
      $email = $request->email;
      $role = $request->role;

      # verify user email
      $verifyUserEmail = User::where('email', $email)->first();

      if ($verifyUserEmail && $verifyUserEmail->id != $request->user) {
        return response()->json([
          "status" => 203,
          "message" => "A user with this email already exist."
        ], 203);
      }

      # revalidate user
      User::findOrFail($request->user);

      # define user rights
      $rights = $this->userRole($role);

      try {
        DB::transaction(function () use ($request, $rights) {
          # update account
          $user = User::find($request->user);
          $user->update([
            'name' => $request->name,
            'email' => $request->email,
          ]);

          # update user role
          $user->user_role()->where("user_id", $request->user)->update([
            "type" => $request->role,
            "role" => json_encode($rights)
          ]);
        });

        $data = collect();
        $users = User::with('user_role')->where('id', '!=', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        $users->each(function ($user) use ($data) {
          $data->push(
            (object) [
              "id" => $user->id,
              "fullname" => $user->name,
              "email" => $user->email,
              "role" => ucwords(str_replace('_', ' ', $user->user_role->type))
            ]
          );
        });

        return response()->json([
          "status" => 202,
          "data" => $data,
          "message" => "User record updated successfully."
        ], 202);
      } catch (\Exception $ex) {
        return response()->json([
          "status" => 203,
          "message" => "User record updated could not be completed. Try again."
        ], 203);
      }
    } catch (\Exception $ex) {
      return response()->json([
        "status" => 203,
        "message" => "User record update failed. Try again."
      ], 203);
    }
  }

  /**
   * Delete User
   * @param \Illuminate\Http\Request $request
   * 
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function deleteUser(Request $request)
  {
    try {
      # delete user
      User::find($request->user)->delete();

      $data = collect();
      $users = User::with('user_role')->where('id', '!=', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
      $users->each(function ($user) use ($data) {
        $data->push(
          (object) [
            "id" => $user->id,
            "fullname" => $user->name,
            "email" => $user->email,
            "role" => ucwords(str_replace('_', ' ', $user->user_role->type))
          ]
        );
      });

      return response()->json([
        'status' => 200,
        'data' => $data,
        'message' => 'User deleted.'
      ], 200);
    } catch (\Exception $ex) {
      return response()->json([
        'status' => 203,
        'message' => 'User could not be deleted. Try again'
      ], 203);
    }
  }

  /**
   * User Role Management
   * @param \Illuminate\Http\Request $request
   * 
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function manageUserRole(Request $request)
  {
    try {
      switch ($request->type) {
        case 'load_roles':
          $role = UserRole::where("user_id", $request->user)->first();
          $userRoles = collect(json_decode($role->role)[0]);

          # remove restricted roles
          $exceptions = $this->excludeRole($role->type);
          $data = [];

          foreach ($userRoles as $item => $key) {
            if (!in_array($item, $exceptions ?? [])) {
              $data[$item] = $key;
            }
          }

          return response()->json([
            "status" => 200,
            "data" => $data,
            "message" => "User Roles"
          ], 200);
          break;

        case 'update_role':
          $userRoles = UserRole::where("user_id", $request->user)->first();
          $rights = collect(json_decode($userRoles->role)[0]);

          # loop and update role status
          foreach ($rights as $right => $key) {
            if (in_array($right, $request->roles ?? [])) {
              $rights[$right] = true;
            } else {
              $rights[$right] = false;
            }
          }

          $roles = collect();
          $roles->push($rights);
          $userRoles->update(["role" => json_encode($roles)]);

          return response()->json([
            "status" => 200,
            "message" => "Role update successfully"
          ], 200);
          break;

        default:
          return response()->json([
            "status" => 203,
            "message" => "Your request could not be processed.",
          ], 203);
          break;
      }
    } catch (\Exception $ex) {
      return response()->json([
        "status" => 203,
        "message" => "Sorry, an unknown error occurred.",
        "ex" => $ex->getMessage()
      ], 203);
    }
  }
}
