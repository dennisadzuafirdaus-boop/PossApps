  @if ($errors->any())
      <div class="alert alert-danger d-flex flex-column">
          @foreach ($errors->all() as $error)
              <small class="text-white my-2">{{ $error }} </small>
          @endforeach
      </div>
  @endif

  @if (session('success'))
      <div class="alert alert-success d-flex flex-column">
          <small class="text-white my-2">{{ session('success') }} </small>
      </div>
  @endif
