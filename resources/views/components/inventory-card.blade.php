<div class="col-md-3 d-flex">
     <div class="border rounded pa-2 w-100">
          {{ $cardLabel }}
          <div class="fs-2">
              {{ $count > 9999 ? sprintf("%.1e", $count) : $count }}
          </div>
          <div class="d-flex justify-content-between">
            @hasanyrole($role)
            	@if ($linkView) 
                <a href="{{ $linkView }}" 
                    class="text-decoration-none text-info small">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                    {{ __('View') }}
                </a>
              @endif

              @if ($linkAdd)
                <a href="{{ $linkAdd }}" 
                    class="text-decoration-none text-primary small">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    {{ __('Add') }}
                </a>
              @endif
            @endhasanyrole
        </div>
      </div>
 </div>