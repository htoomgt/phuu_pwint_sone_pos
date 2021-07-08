@if(Session::has('login_status'))
          <div class="alert alert-success">
              {{ Session::get('login_status') }}
          </div>
  @endif


{{ session('login_status') ?? 'no status'}}
