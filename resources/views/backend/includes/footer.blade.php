<footer class="c-footer">
    <div>
        <strong>
            @lang('Copyright') &copy; {{ date('Y') }}
            <x-utils.link href="{{ env('APP_URL') }}" target="_blank" :text="__(appName())" />
        </strong>

        @lang('All Rights Reserved')
    </div>

    <div class="mfs-auto">
        @lang('Powered by')
        <x-utils.link href="https://Cabral221.github.io" target="_blank" :text="__(appName())" /> &
        <x-utils.link href="https://Cabral221.github.io" target="_blank" text="CoreUI" />
    </div>
</footer>
