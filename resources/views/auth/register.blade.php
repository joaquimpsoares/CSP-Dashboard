<x-guest-layout>
    <form method="POST" action="{{ route('register') }}"
          x-data="{
              step: {{ $errors->any() && old('_step', 1) == 2 ? 2 : ($errors->any() ? 1 : 1) }},
              goNext() {
                  // Basic HTML5 check before advancing
                  const inputs = this.$el.querySelectorAll('[data-step=\'1\'] input, [data-step=\'1\'] select');
                  let valid = true;
                  inputs.forEach(i => { if (!i.checkValidity()) { i.reportValidity(); valid = false; } });
                  if (valid) this.step = 2;
              }
          }">
        @csrf
        {{-- track which step was active on submit so we can restore on validation error --}}
        <input type="hidden" name="_step" :value="step">

        {{-- Step indicator --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="flex items-center gap-2">
                <span :class="step >= 1 ? 'bg-primary-600 text-white' : 'bg-slate-200 text-slate-500'"
                      class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-xs font-semibold transition">1</span>
                <span :class="step >= 1 ? 'text-slate-900 font-semibold' : 'text-slate-400'"
                      class="text-sm transition">Company</span>
            </div>
            <div class="flex-1 h-px bg-slate-200"></div>
            <div class="flex items-center gap-2">
                <span :class="step >= 2 ? 'bg-primary-600 text-white' : 'bg-slate-200 text-slate-500'"
                      class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-xs font-semibold transition">2</span>
                <span :class="step >= 2 ? 'text-slate-900 font-semibold' : 'text-slate-400'"
                      class="text-sm transition">Your account</span>
            </div>
        </div>

        {{-- Server-side error banner --}}
        @if($errors->any())
            <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ───────────────────────────── STEP 1 — Company ───────────────────────────── --}}
        <div data-step="1" x-show="step === 1" x-cloak>
            <h2 class="text-base font-semibold text-slate-900 mb-4">Company details</h2>

            <div class="grid grid-cols-2 gap-4">
                {{-- Company Name --}}
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-700" for="company_name">
                        Company Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="company_name" name="company_name"
                           value="{{ old('company_name') }}"
                           required
                           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none @error('company_name') border-red-400 @enderror">
                </div>

                {{-- VAT Number --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700" for="nif">
                        VAT Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nif" name="nif"
                           value="{{ old('nif') }}"
                           required
                           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none @error('nif') border-red-400 @enderror">
                </div>

                {{-- Country --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700" for="country_id">
                        Country <span class="text-red-500">*</span>
                    </label>
                    <select id="country_id" name="country_id" required
                            class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none @error('country_id') border-red-400 @enderror">
                        <option value="">— Select —</option>
                        @foreach($countries as $id => $name)
                            <option value="{{ $id }}" {{ old('country_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Address 1 --}}
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-700" for="address_1">
                        Address 1 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="address_1" name="address_1"
                           value="{{ old('address_1') }}"
                           placeholder="1234 Main St"
                           required
                           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none @error('address_1') border-red-400 @enderror">
                </div>

                {{-- Address 2 --}}
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-700" for="address_2">
                        Address 2 <span class="text-slate-400 font-normal">(optional)</span>
                    </label>
                    <input type="text" id="address_2" name="address_2"
                           value="{{ old('address_2') }}"
                           placeholder="Apartment or number"
                           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none">
                </div>

                {{-- City --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700" for="city">
                        City <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="city" name="city"
                           value="{{ old('city') }}"
                           required
                           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none @error('city') border-red-400 @enderror">
                </div>

                {{-- State --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700" for="state">
                        State <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="state" name="state"
                           value="{{ old('state') }}"
                           required
                           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none @error('state') border-red-400 @enderror">
                </div>

                {{-- Postal Code --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700" for="postal_code">
                        Postal Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="postal_code" name="postal_code"
                           value="{{ old('postal_code') }}"
                           required
                           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none @error('postal_code') border-red-400 @enderror">
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-slate-700">
                    Already registered?
                </a>
                <button type="button" @click="goNext()"
                        class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                    Next
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- ────────────────────────── STEP 2 — Your account ────────────────────────── --}}
        <div data-step="2" x-show="step === 2" x-cloak>
            <h2 class="text-base font-semibold text-slate-900 mb-4">Your account</h2>

            <div class="grid grid-cols-2 gap-4">
                {{-- First Name --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700" for="name">
                        First Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name') }}"
                           placeholder="First Name"
                           required
                           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none @error('name') border-red-400 @enderror">
                </div>

                {{-- Last Name --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700" for="last_name">
                        Last Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="last_name" name="last_name"
                           value="{{ old('last_name') }}"
                           placeholder="Last Name"
                           required
                           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none @error('last_name') border-red-400 @enderror">
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700" for="phone">
                        Phone <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="phone" name="phone"
                           value="{{ old('phone') }}"
                           placeholder="+1 234 567 890"
                           required
                           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none @error('phone') border-red-400 @enderror">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700" for="email">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="you@company.com"
                           required autocomplete="username"
                           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none @error('email') border-red-400 @enderror">
                </div>

                {{-- Password --}}
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-slate-700" for="password">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password" name="password"
                           required autocomplete="new-password"
                           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none @error('password') border-red-400 @enderror">
                </div>

                {{-- Confirm Password --}}
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-slate-700" for="password_confirmation">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           required autocomplete="new-password"
                           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none">
                </div>
            </div>

            {{-- Terms & Conditions --}}
            <div class="mt-4 flex items-start gap-3">
                <input type="checkbox" id="terms_accepted" name="terms_accepted" value="1"
                       class="mt-0.5 h-4 w-4 shrink-0 rounded border-slate-300 text-primary-600 focus:ring-primary-500"
                       {{ old('terms_accepted') ? 'checked' : '' }} required>
                <label for="terms_accepted" class="text-sm text-slate-600 leading-snug">
                    I have read and agree to the
                    <a href="/terms" target="_blank" class="text-primary-600 underline hover:text-primary-800">Terms and Conditions</a>
                    and
                    <a href="/privacy" target="_blank" class="text-primary-600 underline hover:text-primary-800">Privacy Policy</a>.
                </label>
            </div>
            @error('terms_accepted')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror

            <div class="mt-6 flex items-center justify-between">
                <button type="button" @click="step = 1"
                        class="inline-flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                    Create account
                </button>
            </div>
        </div>
    </form>
</x-guest-layout>
