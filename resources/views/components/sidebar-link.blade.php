@props(['active' => false, 'icon' => ''])

<li>
    <a {{ $attributes }} 
       class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group
       {{ $active 
          ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-[0_0_15px_rgba(16,185,129,0.1)]' 
          : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
        
        <i class="{{ $icon }} text-lg transition-transform duration-200 group-hover:scale-110 
           {{ $active ? 'text-emerald-400' : 'text-slate-500' }}"></i>
        
        <span class="flex-1">{{ $slot }}</span>

        @if($active)
            <div class="size-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_var(--color-emerald-400)]"></div>
        @endif
    </a>
</li>