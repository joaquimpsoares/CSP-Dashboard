@extends('microsoftcspconnection::layouts.master')

@section('title', 'Microsoft CSP Connection Status')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Microsoft CSP Connection</h1>

    @if ($connection)
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex items-center mb-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    {{ $connection->isReady() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $connection->isReady() ? 'Ready' : 'Incomplete Credentials' }}
                </span>
            </div>

            <dl class="divide-y divide-gray-200">
                <div class="py-3 flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Tenant ID</dt>
                    <dd class="text-sm text-gray-900 font-mono">{{ $connection->tenant_id }}</dd>
                </div>
                <div class="py-3 flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Token Mode</dt>
                    <dd class="text-sm text-gray-900 uppercase">{{ $connection->token_mode }}</dd>
                </div>
                <div class="py-3 flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Partner ID (MPN)</dt>
                    <dd class="text-sm text-gray-900">{{ $connection->partner_id ?? '—' }}</dd>
                </div>
                <div class="py-3 flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Consented At</dt>
                    <dd class="text-sm text-gray-900">{{ $connection->consented_at?->format('Y-m-d H:i') ?? '—' }}</dd>
                </div>
                @if ($connection->token_mode === 'sam')
                <div class="py-3 flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">MFA Compliant</dt>
                    <dd class="text-sm">
                        @if (is_null($connection->mfa_compliant))
                            <span class="text-gray-400">Not checked</span>
                        @elseif ($connection->mfa_compliant)
                            <span class="text-green-600 font-medium">Yes</span>
                        @else
                            <span class="text-red-600 font-medium">No</span>
                        @endif
                    </dd>
                </div>
                <div class="py-3 flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">MFA Checked At</dt>
                    <dd class="text-sm text-gray-900">{{ $connection->mfa_checked_at?->format('Y-m-d H:i') ?? '—' }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <a href="{{ route('microsoft-csp.test') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            Test Connection
        </a>
    @else
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600">
                No Microsoft CSP connection is configured for your provider account.
                Please create a record in the <code class="bg-gray-100 px-1 rounded">microsoft_csp_connections</code> table.
            </p>
        </div>
    @endif
</div>
@endsection
