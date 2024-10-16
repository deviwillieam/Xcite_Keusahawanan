<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="role_id">@lang('Role')</label>
            <select name="role_id" id="role_id" class="form-control input-solid" {{ $profile ? 'disabled' : '' }}>
                @foreach($roles as $roleId => $roleName)
                    <option value="{{ $roleId }}" {{ ($edit && $user->role->id == $roleId) ? 'selected' : '' }}>
                        {{ $roleName }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">@lang('Status')</label>
            <select name="status" id="status" class="form-control input-solid" {{ $profile ? 'disabled' : '' }}>
                @foreach($statuses as $statusId => $statusName)
                    <option value="{{ $statusId }}" {{ ($edit && $user->status->value == $statusId) ? 'selected' : '' }}>
                        {{ $statusName }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="first_name">@lang('First Name')</label>
            <input type="text" class="form-control input-solid" id="first_name"
                   name="first_name" placeholder="@lang('First Name')" value="{{ $edit ? $user->first_name : '' }}">
        </div>
        <div class="form-group">
            <label for="last_name">@lang('Last Name')</label>
            <input type="text" class="form-control input-solid" id="last_name"
                   name="last_name" placeholder="@lang('Last Name')" value="{{ $edit ? $user->last_name : '' }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="birthday">@lang('Date of Birth')</label>
            <div class="form-group">
                <input type="text"
                       name="birthday"
                       id='birthday'
                       value="{{ $edit && $user->birthday ? $user->present()->birthday : '' }}"
                       class="form-control input-solid" />
            </div>
        </div>
        <div class="form-group">
            <label for="phone">@lang('Phone')</label>
            <input type="text" class="form-control input-solid" id="phone"
                   name="phone" placeholder="@lang('Phone')" value="{{ $edit ? $user->phone : '' }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('Address')</label>
            <input type="text" class="form-control input-solid" id="address"
                   name="address" placeholder="@lang('Address')" value="{{ $edit ? $user->address : '' }}">
        </div>
        <div class="form-group">
            <label for="country_id">@lang('Country')</label>
            <select name="country_id" id="country_id" class="form-control input-solid">
                @foreach($countries as $countryId => $countryName)
                    <option value="{{ $countryId }}" {{ ($edit && $user->country_id == $countryId) ? 'selected' : '' }}>
                        {{ $countryName }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    @if ($edit)
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-primary" id="update-details-btn">
                <i class="fa fa-refresh"></i>
                @lang('Update Details')
            </button>
        </div>
    @endif
</div>
