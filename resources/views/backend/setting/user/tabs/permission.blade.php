<div class="accordion" id="accordionExample">
    @forelse($user->roles as $role)
        <div class="card">
            <h4 class="card-header mb-0 px-1 py-2" id="heading{{ $role->id }}"
                data-toggle="collapse" data-target="#collapse{{ $role->id }}"
                aria-expanded="true" aria-controls="collapse{{ $role->id }}">
                <i class="fa fa-user-check"></i>
                {{ $role->name }}
            </h4>
            <div id="collapse{{ $role->id }}" class="collapse"
                 aria-labelledby="heading{{ $role->id }}"
                 data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        @forelse($role->permissions as $permission)
                            <div class="col-md-6">
                                <p class="text-dark fw-bold"
                                   title="{{ $permission->name }}">
                                    <i class="mdi mdi-account-key m-2"></i> {{ $permission->display_name }}
                                </p>
                            </div>
                        @empty
                            <div class="col-12 text-center font-weight-bold">This Role Don't
                                have any
                                Permission/Privileges
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center font-weight-bolder">
            This user don't have any role(s) assigned.
        </div>
    @endforelse
</div>