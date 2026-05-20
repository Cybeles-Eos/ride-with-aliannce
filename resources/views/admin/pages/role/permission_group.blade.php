<div class="block permissions_container">
    <div class="block-title">
        <h2><i class="fa fa-pencil"></i> <strong>Permission Details</strong></h2>
    </div>
    <div class="permission-error-container" style="display: none;">
        <div class="alert alert-danger">

        </div>
    </div>
    @foreach($permission_groups as $permission_group)
        <div class="col-sm-6">
            <div class="block">
                <div class="block-title">
                    <h2>{{--<i class="gi gi-display"></i> --}}<strong>{{ $permission_group->name }} Access</strong></h2>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        @foreach($permission_group->permissions as $permission)
                            {{ Form::checkbox('permissions[]', $permission->id, (!empty($role) ? ($role->permissions->contains('id', $permission->id)) : 0)) }}
                            {{ Form::label($permission->name, ucfirst($permission->name)) }}<br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="form-group form-actions">
        <div class="col-md-9 col-md-offset-3">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-warning">Cancel</a>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Save
            </button>
        </div>
    </div>
</div>
