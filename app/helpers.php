<?php
  
  use Illuminate\Support\Str;
  
  if (! function_exists('multi_auth_guard')) {
      function multi_auth_guard(): ?string
      {
          $current_uri = request()->path();
          $guard_types = ['user', 'member', 'leader', 'admin'];
          foreach ($guard_types as $guard_type) {
              if(Str::startsWith($current_uri, $guard_type)) {
                  return $guard_type;
              }
          }
          return null;
      }
  }