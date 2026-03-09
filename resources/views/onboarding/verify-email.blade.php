<x-onboarding.layout title="Verify your email" :step="1">

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-8">
        <h1 class="text-xl font-semibold text-slate-900">Verify your email</h1>
        <p class="mt-2 text-sm text-slate-600">
            We sent a 6-digit code to <strong>{{ auth()->user()->email }}</strong>.
            Enter it below to continue.
        </p>

        @if(session('otp_sent'))
            <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                A new code has been sent to your email.
            </div>
        @endif

        @if($errors->any())
            <div class="mt-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('onboarding.verify.submit') }}" class="mt-6"
              x-data="{
                  digits: ['','','','','',''],
                  get otp() { return this.digits.join(''); },
                  focus(i) { this.$refs['d'+i]?.focus(); },
                  onInput(i) {
                      const val = this.$refs['d'+i].value;
                      if (val.length > 1) {
                          // handle paste: distribute across fields
                          const chars = val.replace(/\D/g,'').slice(0,6).split('');
                          chars.forEach((c, j) => { if (i+j < 6) this.digits[i+j] = c; });
                          this.focus(Math.min(i + chars.length, 5));
                          this.$refs['d'+i].value = this.digits[i];
                          return;
                      }
                      this.digits[i] = val.replace(/\D/g,'');
                      this.$refs['d'+i].value = this.digits[i];
                      if (this.digits[i] && i < 5) this.focus(i+1);
                  },
                  onBack(i) {
                      if (!this.digits[i] && i > 0) { this.digits[i-1]=''; this.focus(i-1); }
                  }
              }">
            @csrf

            <input type="hidden" name="otp" :value="otp">

            <!-- 6-digit inputs -->
            <div class="flex gap-2 justify-center mt-2">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" inputmode="numeric" maxlength="6"
                           x-ref="d{{ $i }}"
                           x-model="digits[{{ $i }}]"
                           @input="onInput({{ $i }})"
                           @keydown.backspace="onBack({{ $i }})"
                           @paste.prevent="onInput({{ $i }})"
                           class="h-14 w-12 rounded-lg border border-slate-300 bg-white text-center text-2xl font-bold text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 focus:outline-none">
                @endfor
            </div>

            <button type="submit"
                    class="mt-6 w-full rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                Verify email
            </button>
        </form>

        <!-- Resend with 60s cooldown -->
        <div class="mt-4 text-center text-sm text-slate-500"
             x-data="{
                 seconds: {{ session('otp_sent') ? 60 : 0 }},
                 start() { if(this.seconds > 0) { const t = setInterval(() => { this.seconds--; if(this.seconds<=0) clearInterval(t); }, 1000); } }
             }"
             x-init="start()">
            <template x-if="seconds > 0">
                <span>Resend code in <span class="font-medium text-slate-700" x-text="seconds"></span>s</span>
            </template>
            <template x-if="seconds <= 0">
                <form method="POST" action="{{ route('onboarding.verify.send') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-primary-600 font-medium hover:text-primary-800">
                        Resend code
                    </button>
                </form>
            </template>
        </div>
    </div>

</x-onboarding.layout>
