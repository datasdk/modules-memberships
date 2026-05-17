<section>
    @if($this->translatedStatus)
        <span class="px-2 py-1 text-white text-sm rounded" 
              style="background-color: {{ $this->chipColor }};">
            {{ $this->translatedStatus }}
        </span>
    @else
        -
    @endif
</section>
