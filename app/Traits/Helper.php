<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\{
  Session,
  Storage
};

trait Helper
{
  private $sender_mail = "info@kwaranutrition.com.ng";

  private function roles()
  {
    $levels = collect(["editor", "sub_admin"]);
    $roles = collect();
    $levels->each(function ($level) use ($roles) {
      $roles->push((object) [
        "name" => ucwords(str_replace('_', ' ', $level)),
        "value" => $level
      ]);
    });
    return $roles;
  }

  /**
   * User Role
   * @param string $user
   * 
   * @return object $roles
   */
  private function userRole($user)
  {
    $rights = collect();

    if ($user === "admin") {
      $rights->push((object) [
        "blog" => true,
        "account" => true,
        "videos" => true,
        "gallery" => true,
        "team" => true,
        "partners" => true,
        "page_builder" => true,
        "site_settings" => true
      ]);
    }

    if ($user === "editor") {
      $rights->push((object) [
        "blog" => true,
        "account" => false,
        "videos" => false,
        "gallery" => false,
        "team" => false,
        "partners" => false,
        "page_builder" => false,
        "site_settings" => false
      ]);
    }

    if ($user === "sub_admin") {
      $rights->push((object) [
        "blog" => true,
        "account" => false,
        "videos" => true,
        "gallery" => true,
        "team" => true,
        "partners" => true,
        "page_builder" => false,
        "site_settings" => false
      ]);
    }

    return $rights;
  }

  /**
   * Role Check
   * @param string $role
   * 
   * @return boolean
   */
  private function roleCheck($role)
  {
    $roles = Session::get('role');
    if ($roles->$role === true) {
      return true;
    }
    return false;
  }

  /**
   * Roles
   * @param string $role
   * 
   * @return array
   */
  private function excludeRole($role)
  {
    $exclude = [
      "editor" => ["account", "report"],
      "sub_admin" => ["account", "report"],
      "admin" => ["report"]
    ];

    return $exclude[$role];
  }

  /**
   * Store file to storage
   * @param string $path
   * @param string $file
   * @param string $visibility
   * 
   * @return string
   */
  public function storeFile($path, $file, $visibility = 'public'): string
  {
    if (gettype($file) !== 'string') {
      Storage::put($path, file_get_contents($file), $visibility);
      return Storage::url($path);
    }

    Storage::put($path, $file, $visibility);
    return Storage::url($path);
  }

  /**
   * Remove file from storage
   * @param string $key
   * 
   * @return void
   */
  public function removeFile($key): void
  {
    Storage::delete($key);
  }

  /**
   * Check Field
   * @param App\Models $model
   * @param string $field
   * @param string $value
   * 
   * @return string
   */
  public function checkField($model, $field, $value)
  {
    $check = $model::where($field, $value)->first();
    if ($check && $check->$field == $value) {
      return $this->checkField($model, $field, $value = Str::uuid());
    } else {
      return Str::uuid();
    }
  }

  /**
   * Generate Initials from a name
   * @param string $name
   * 
   * @return string
   */
  private function generateInitials(string $name): string
  {
    $words = explode(' ', $name);
    if (count($words) >= 2) {
      return strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
    }
    return $this->makeInitialsFromSingleWord($name);
  }

  /**
   * Make initials from a word with no spaces
   * @param string $name
   * 
   * @return string
   */
  protected function makeInitialsFromSingleWord(string $name): string
  {
    preg_match_all('#([A-Z]+)#', $name, $capitals);
    if (count($capitals[1]) >= 2) {
      return substr(implode('', $capitals[1]), 0, 2);
    }
    return strtoupper(substr($name, 0, 2));
  }
}
