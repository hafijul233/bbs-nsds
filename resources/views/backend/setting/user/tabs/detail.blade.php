<div class="row">
    <div class="col-md-4">
        <label class="d-block">Name</label>
        <p class="font-weight-bold">{{ $user->name ?? null }}</p>
    </div>
    <div class="col-md-4">
        <label class="d-block">Guard(s)</label>
        <p class="font-weight-bold">{{ $user->guard_name ?? null }}</p>
    </div>
    <div class="col-md-4">
        <label class="d-block">Enabled</label>
        <p class="font-weight-bold">{{ \App\Supports\Constant::ENABLED_OPTIONS[$user->enabled] ?? null }}</p>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <label class="d-block">Remarks</label>
        <p class="font-weight-bold">{{ $user->remarks ?? null }}</p>
    </div>
</div>
