<div class="row">
    <div class="col-md-6">
        <label class="d-block">Name</label>
        <p class="font-weight-normal">{{ $user->name ?? null }}</p>
    </div>
    <div class="col-md-6">
        <label class="d-block">Email</label>
        <p class="font-weight-normal">{{ $user->email ?? null }}</p>
    </div>
    <div class="col-md-6">
        <label class="d-block">Username</label>
        <p class="font-weight-normal">{{ $user->username ?? null }}</p>
    </div>
    <div class="col-md-6">
        <label class="d-block">Mobile</label>
        <p class="font-weight-normal">{{ $user->mobile ?? null }}</p>
    </div>
    <div class="col-md-6">
        <label class="d-block">Enabled</label>
        <p class="font-weight-normal">{{ \App\Supports\Constant::ENABLED_OPTIONS[$user->enabled] ?? null }}</p>
    </div>
    <div class="col-md-6">
        <label class="d-block">Locale</label>
        <p class="font-weight-normal">{{ \App\Supports\Constant::LOCALES[$user->locale] ?? null }}</p>
    </div>
    <div class="col-md-6">
        <label class="d-block">Role(s)</label>
        <p class="font-weight-normal">
            @if($user->roles()->exists())
                {{ implode(", ", $user->roles->pluck('name')->toArray()) }}
            @endif
        </p>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <label class="d-block">Remarks</label>
        <p class="font-weight-normal">{{ $user->remarks ?? null }}</p>
    </div>
</div>
