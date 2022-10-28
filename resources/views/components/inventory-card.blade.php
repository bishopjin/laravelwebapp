<div class="{{ $cardWidth }} d-flex">
     <div class="border rounded pa-2 w-100">
          {{ $cardLabel }}
          <div class="@if($shortCountDisplay) fs-2 @else fs-1 @endif">
              {{ $shortCountDisplay ? sprintf("%.1e", $count) : $count }}
          </div>
          <div class="d-flex justify-content-between">
            @hasanyrole($role)
            	@if ($linkView) 
                <a href="{{ $linkView }}" 
                    class="text-decoration-none text-info @if($shortCountDisplay) small @endif">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    {{ __('View') }}
                </a>
              @endif

              @if ($linkAdd)
                <a href="{{ $linkAdd }}" 
                    class="text-decoration-none text-primary @if($shortCountDisplay) small @endif">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    {{ __('Add') }}
                </a>
              @endif
            @endhasanyrole
        </div>
      </div>
 </div>