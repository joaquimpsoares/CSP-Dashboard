<tr>
    <td style="width: 60px;">
        <a href="{{ route('user.show', $user) }}">
            <img
                class="rounded-circle img-responsive"
                width="40"
                src="{{ $user->avatar }}"
                alt="{{ $user->name }}">
        </a>
    </td>
    <td class="align-middle">{{ $user->email }}</td>
    <td class="align-middle">{{ $user->name . ' ' . $user->last_name }}</td>
    <td class="align-middle">{{ $user->created_at }}</td>
    <td class="align-middle">
        <span class="badge badge-lg badge-{{ $user->labelClass }}">
            {{ trans("{$user->status->name}") }}
        </span>
    </td>
    <td class="text-center align-middle">
        <div class="dropdown show d-inline-block">
            <a class="btn btn-icon"
               href="#" role="button" id="dropdownMenuLink"
               data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-h"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                {{-- @if (config('session.driver') == 'database') --}}
                    {{-- <a href="{{ route('user.sessions', $user) }}" class="dropdown-item text-gray-500"> --}}
                        {{-- <i class="fa fa-list mr-2"></i>
                        @lang('User Sessions')
                    </a>
                @endif --}}
                <a href="{{ route('user.show', $user) }}" class="dropdown-item text-gray-500">
                    <i class="fa fa-eye mr-2"></i>
                    @lang('View User')
                </a>

                @canBeImpersonated($user)
                    <a href="{{ route('impersonate', $user) }}" class="dropdown-item text-gray-500 impersonate">
                        <i class="fa fa-user-secret mr-2"></i>
                        @lang('Impersonate')
                    </a>
                @endCanBeImpersonated
            </div>
        </div>

        <a href="{{ route('user.edit', $user) }}"
           class="btn btn-icon edit"
           title="@lang('Edit User')"
           data-toggle="tooltip" data-placement="top">
            <i class="fa fa-edit"></i>
        </a>

        <a href="{{ route('user.destroy', $user) }}"
           class="btn btn-icon"
           title="@lang('Delete User')"
           data-toggle="tooltip"
           data-placement="top"
           data-method="DELETE"
           data-confirm-title="@lang('Please Confirm')"
           data-confirm-text="@lang('Are you sure that you want to delete this user?')"
           data-confirm-delete="@lang('Yes, delete him!')">
            <i class="fa fa-trash"></i>
        </a>
    </td>
</tr>
