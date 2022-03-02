@if (Session('success'))
    <div id="status_message" class="py-2 bg-emerald-200 text-emerald-700 text-center">
        <p>{{ Session('success') }}</p>
    </div>
@endif
@if (Session('error'))
    <div id="status_message" class="py-2 bg-emerald-200 text-emerald-700 text-center">
        <p>{{ Session('error') }}</p>
    </div>
@endif
