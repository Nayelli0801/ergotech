<div class="flex h-screen bg-gray-100">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-blue-900 text-white flex flex-col">
        
        <!-- Logo -->
        <div class="h-16 flex items-center justify-center border-b border-blue-800">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold">
                ERGOYES
            </a>
        </div>

        <!-- Menu -->
        <nav class="flex-1 px-4 py-6 space-y-2">

            <a href="{{ route('dashboard') }}" 
               class="block px-4 py-2 rounded hover:bg-blue-700 transition">
                Panel
            </a>

            <a href="#" 
               class="block px-4 py-2 rounded hover:bg-blue-700 transition">
                Mis Evaluaciones
            </a>

            <a href="#" 
               class="block px-4 py-2 rounded hover:bg-blue-700 transition">
                Evaluar Mono
            </a>

            <a href="#" 
               class="block px-4 py-2 rounded hover:bg-blue-700 transition">
                Evaluar Multi
            </a>

            <a href="#" 
               class="block px-4 py-2 rounded hover:bg-blue-700 transition">
                Tecnologías IA
            </a>

            <a href="#" 
               class="block px-4 py-2 rounded hover:bg-blue-700 transition">
                Asistentes
            </a>

            <a href="#" 
               class="block px-4 py-2 rounded hover:bg-blue-700 transition">
                Personal
            </a>

            <a href="#" 
               class="block px-4 py-2 rounded hover:bg-blue-700 transition">
                Auditoría
            </a>

        </nav>

        <!-- Logout abajo -->
        <div class="p-4 border-t border-blue-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left hover:text-gray-300">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>


    <!-- CONTENIDO -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
<header class="h-16 bg-white shadow flex items-center justify-end px-6">
    <div class="flex items-center gap-3">

        {{-- FOTO O INICIAL --}}
        @if(Auth::user()->profile_photo)
            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                 class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-300">
        @else
            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-sm font-semibold text-gray-700">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif

        {{-- NOMBRE COMPLETO --}}
        <span class="text-sm font-medium text-gray-700">
            {{ Auth::user()->name }}
            @if(Auth::user()->last_name)
                {{ Auth::user()->last_name }}
            @endif
        </span>

    </div>
</header>

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-6">
            {{ $slot ?? '' }}
        </main>

    </div>

</div>