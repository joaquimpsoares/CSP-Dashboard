<template>
    <b-menu>
                <b-menu-list label="Menu">
                    <b-menu-item icon="information-outline" label="Dashboard" tag="a"
                    href="{{ route('dashboard') }}"></b-menu-item>
                    @permission('reseller.manage')
					@if( auth()->user()->getRole() == 5 && auth()->user()->parentUserRole() == 2 )
					@else
					<li class="{{ Request::is('reseller*') ? 'active' : ''  }}">
						<a href="{{ route('reseller.list') }}">
							<i class="fas fa-user"></i>
							<span> @lang('app.resellers')</span>
						</a>
					</li>
					@endif
                    @endpermission
                    @permission('customer.manage')
                    <li class="{{ Request::is('customer*') ? 'active' : ''  }}">
						<a href="{{ route('customer.list') }}">
							<i class="fas fa-building"></i>
							<span> @lang('app.customers')</span>
						</a>
                    </li>
                    @endpermission
                    <b-menu-item icon="cloud" label="Subscriptions" tag="a"
                    href="{{ route('subscriptions') }}"></b-menu-item>
                    <b-menu-item icon="folder-open" label="Orders" href="{{ route('orders') }}"></b-menu-item>
                    <b-menu-item icon="folder-open" label="Analytics" href="{{ route('analytics.list') }}"></b-menu-item>

                    <b-menu-item icon="cart" label="Marketplace" tag="a" href="{{ route('ecommerce.placeorder') }}"></b-menu-item>
                    <b-menu-item icon="account" label="My Account">
                        <b-menu-item label="Account data"></b-menu-item>
                        <b-menu-item label="Profile"></b-menu-item>
                    </b-menu-item>
                    <b-menu-item
                        icon="settings"
                        :active="isActive"
                        :expanded="isActive"
                        @click="isActive = !isActive">
                        <template slot="label" slot-scope="props">
                            Operations
                            <b-icon
                                class="is-pulled-right"
                                :icon="props.expanded ? 'menu-down' : 'menu-up'">
                            </b-icon>
                        </template>
                        {{-- @permission('users.manage')
							<li class="{{ Request::is('user*') ? 'active' : ''  }}">
								<a href="{{ route('user.list') }}">
                                    <i class="fas fa-users"></i>
                                    <b-menu-item icon="account" label="Users"></b-menu-item>
									<span> @lang('app.users')</span>
								</a>
							</li>
						@endpermission --}}

                        <b-menu-item icon="account">
                            @permission('users.manage')
                            <!-- <template slot="label" slot-scope="props">
                                Users
                                <b-dropdown aria-role="list" class="is-pulled-right" position="is-bottom-right">
                                <b-icon icon="dots-vertical" slot="trigger" ></b-icon>
                                    <b-dropdown-item aria-role="listitem" tag="a" href="{{ route('user.list') }}">Users list</b-dropdown-item>
                                    <b-dropdown-item aria-role="listitem" tag="a" href="{{ route('permission.index') }}">Permissions</b-dropdown-item>
                                    <b-dropdown-item aria-role="listitem" tag="a" href="{{ route('role.index') }}">Roles</b-dropdown-item>
                                </b-dropdown>
                            </template> -->
                            @endpermission
                        </b-menu-item>
                        <b-menu-item icon="cash-multiple" label="Prices" tag="a" href="{{ route('price') }}"></b-menu-item>
                    </b-menu-item>
                </b-menu-list>
                <b-menu-list>
                    <b-menu-item
                        label="Expo"
                        icon="link"
                        tag="router-link"
                        target="_blank"
                        to="/expo">
                    </b-menu-item>
                </b-menu-list>
                <b-menu-list label="Actions">
                    <b-menu-item label="Logout"></b-menu-item>
                </b-menu-list>
            </b-menu>
        </template>

    <b-menu>
                <b-menu-list label="Menu">
                    <b-menu-item icon="information-outline" label="Dashboard" tag="a"
                    href="{{ route('dashboard') }}"></b-menu-item>
                    @permission('reseller.manage')
					@if( auth()->user()->getRole() == 5 && auth()->user()->parentUserRole() == 2 )
					@else
					<li class="{{ Request::is('reseller*') ? 'active' : ''  }}">
						<a href="{{ route('reseller.list') }}">
							<i class="fas fa-user"></i>
							<span> @lang('app.resellers')</span>
						</a>
					</li>
					@endif
                    @endpermission
                    @permission('customer.manage')
                    <li class="{{ Request::is('customer*') ? 'active' : ''  }}">
						<a href="{{ route('customer.list') }}">
							<i class="fas fa-building"></i>
							<span> @lang('app.customers')</span>
						</a>
                    </li>
                    @endpermission
                    <b-menu-item icon="cloud" label="Subscriptions" tag="a"
                    href="{{ route('subscriptions') }}"></b-menu-item>
                    <b-menu-item icon="folder-open" label="Orders" href="{{ route('orders') }}"></b-menu-item>
                    <b-menu-item icon="folder-open" label="Analytics" href="{{ route('analytics.list') }}"></b-menu-item>

                    <b-menu-item icon="cart" label="Marketplace" tag="a" href="{{ route('ecommerce.placeorder') }}"></b-menu-item>
                    <b-menu-item icon="account" label="My Account">
                        <b-menu-item label="Account data"></b-menu-item>
                        <b-menu-item label="Profile"></b-menu-item>
                    </b-menu-item>

                </b-menu-list>
                <b-menu-list>
                    <b-menu-item
                        label="Expo"
                        icon="link"
                        tag="router-link"
                        target="_blank"
                        to="/expo">
                    </b-menu-item>
                </b-menu-list>
                <b-menu-list label="Actions">
                    <b-menu-item label="Logout"></b-menu-item>
                </b-menu-list>
            </b-menu>
        </template>
</template>
