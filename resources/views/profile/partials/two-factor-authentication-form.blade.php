<section>
    <header>
        <h2>
            Two Factor Authentication
        </h2>
    </header>

    <div class="mt-4">

        @if (! auth()->user()->two_factor_secret)

            <form method="POST" action="/user/two-factor-authentication">
                @csrf
                <button type="submit">
                    Enable Two-Factor Authentication
                </button>
            </form>

        @else

            <form method="POST" action="/user/two-factor-authentication">
                @csrf
                @method('DELETE')
                <button type="submit">
                    Disable Two-Factor Authentication
                </button>
            </form>

        @endif

    </div>
</section>
