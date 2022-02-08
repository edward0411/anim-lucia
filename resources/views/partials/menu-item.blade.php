@if ($item['submenu'] == [])
    <li class="nav-item">
        <a href="{{ url($item['name']) }}" class="nav-link active">
        <i class="nav-icon  {{ $item['icon'] }}"></i>
        <p> {{ $item['name'] }}</p>
        </a>
    </li>
@else
<li class="nav-item has-treeview " id="menuprincipal{{$item['id']}}">
    <a href="#" class="nav-link active">
      <i class="nav-icon {{ $item['icon'] }}"></i>
      <p>
        {{ $item['name'] }}
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
        @foreach ($item['submenu'] as $submenu)
            @if ($submenu['submenu'] == [])
            @can($submenu['permiso'] )
                <li class="nav-item " id="menuid{{$submenu['id']}}">
                <a href="{{ route($submenu['slug']) }}" class="nav-link {!! ($submenu['id']==($item['active']?? 0) )?"active":""  !!}">
                    <i class="nav-icon {{ $submenu['icon'] }}"></i>
                    <p> {{ $submenu['name'] }} </p>
                  
                    @if($submenu['id']==($item['active']?? 0) )
                    <script>
                        document.getElementById("menuprincipal{{$item['id']}}").classList.add('menu-open')
                    </script>
                    @endif
                    </a>
                </li>
            @endcan    
                {{-- <li><a href="{{ url('menu',['id' => $submenu['id'], 'slug' => $submenu['slug']]) }}">{{ $submenu['name'] }} </a></li> --}}
            @else
                @include('partials.menu-item', [ 'item' => $submenu ])
            @endif
        @endforeach
    </ul>
</li>
@endif