<div>

    <!-- Page Heading -->
    <header class="text-black bg-white" style="box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;">
        <div class="px-4 py-6 mx-auto max-w-7xl lg:px-8 sm:px-6">
            <h2 class="m-0 text-xl font-semibold leading-tight text-gray-800">
                Checkout
            </h2>
        </div>
    </header>

    <!-- Page Content -->
    <main class="text-black">
        <div class="py-12">
            <div class="mx-auto max-w-7xl lg:px-8 sm:px-6">

                <form
                wire:id="2WZe4U9TkwIXrcA7PRIS"
                x-on:submit.prevent="submit"
                x-data="{
                    stripe: null,
                    cardElement: null,
                    email: window.Livewire.find('2WZe4U9TkwIXrcA7PRIS').entangle('accountForm.email').defer,
                    submitButtonLabel: 'Confirm Order and Pay',

                    async submit() {
                        this.submitButtonLabel = 'Validating Details...'

                        await $wire.callValidate()

                        let errorCount = await $wire.getErrorCount()

                        if(errorCount) {
                            this.submitButtonLabel = 'Confirm Order and Pay'

                            return
                        }

                        this.submitButtonLabel = 'Processing Payment...'

                        const { paymentIntent, error } = await this.stripe.confirmCardPayment(
                        'pi_3L0N7cCX0KaSQPxh0PNUUJ43_secret_FidooE7YQtI9Iha8djHjzdfhB',
                        { payment_method: {
                            card: this.cardElement,
                            billing_details: { email: this.email }
                        }
                    }
                    )

                    if (error) {
                        this.submitButtonLabel = 'Confirm Order and Pay'

                        window.dispatchEvent(new CustomEvent('notification', {
                            detail: {
                                body: error.message,
                                timeout: 10000
                            }
                        }))
                    } else {
                        $wire.checkout()
                    }
                },

                init() {
                    this.stripe = Stripe('pk_test_51KcfCTCX0KaSQPxhaBf34R7dmswUgWbGn8vprBAAhBp8mRzoZJ73qI09Ez6btKA4e3NHKNnXJJllSYLfV0CTiF9h006KoTXSXj')

                    const elements = this.stripe.elements()
                    this.cardElement = elements.create('card')

                    this.cardElement.mount('#card-element')
                }
            }"
            class="" >


            <div class="grid grid-flow-col grid-cols-6 gap-4 overflow-hidden shadow-lg sm:rounded-lg">

                <div class="box-border self-start col-span-3 p-6 bg-white border-t-0 border-b border-gray-200 border-solid border-x-0"style="border-width: 0px;">
                    <div class="">
                        <div class="text-lg font-semibold leading-7">
                            Account details
                        </div>
                        <div class="mt-3 mb-0">
                            <label for="email" class="cursor-default">Email</label>
                            <input class="box-border block w-full px-3 py-2 mx-0 mt-1 mb-0 text-base border border-gray-300 border-solid rounded-md appearance-none" wire:model.defer="accountForm.email" id="email" type="text" name="email" style='background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg=="); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto; box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;'/>
                        </div>
                    </div>

                    <div class="mt-6 mb-0">
                        <div class="text-lg font-semibold leading-7">{{ ucwords(trans_choice('messages.tenant', 1)) }}</div>
                        <div class="mt-3 mb-0">
                            <label for="tenant" class="block text-sm font-medium text-gray-700">{{ ucwords(trans_choice('messages.tenant', 1)) }}</label>
                            <div class="flex mt-1 rounded-md shadow-sm">
                                <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                    <input class="box-border block w-full px-3 py-2 mx-0 mt-1 mb-0 text-base border border-gray-300 border-solid rounded-none rounded-md appearance-none rounded-l-md" wire:model.defer="accountForm.email" id="email" type="text" name="email" style='background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg=="); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto; box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;'/>
                                </div>
                                <div  class="relative inline-flex items-center px-3 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 cursor-default rounded-r-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                    <span>{{ trans_choice('onmicrosoft.com', 1) }}</span>
                                </div>
                            </div>
                            {{-- <div class="">
                                <label for="address" class="cursor-default">Address</label>
                                <input
                                class="box-border block w-full px-3 py-2 mx-0 mt-1 mb-0 text-base border border-gray-300 border-solid rounded-md appearance-none cursor-text focus:border-blue-600 focus:outline-offset-2"
                                wire:model.defer="shippingForm.address"
                                id="address"
                                type="text"
                                name="address"
                                style="box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;"
                                />
                            </div> --}}

                            <div class="grid grid-cols-2 gap-4 mt-3 mb-0">
                                <div class="col-span-1">
                                    <label for="city" class="cursor-default">City</label>
                                    <input
                                    class="box-border block w-full px-3 py-2 mx-0 mt-1 mb-0 text-base border border-gray-300 border-solid rounded-md appearance-none cursor-text focus:border-blue-600 focus:outline-offset-2"
                                    wire:model.defer="shippingForm.city"
                                    id="city"
                                    type="text"
                                    name="city"
                                    style="box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;"
                                    />
                                </div>
                                <div class="col-span-1">
                                    <label for="postcode" class="cursor-default"
                                    >Postal code</label
                                    >
                                    <input
                                    class="box-border block w-full px-3 py-2 mx-0 mt-1 mb-0 text-base border border-gray-300 border-solid rounded-md appearance-none cursor-text focus:border-blue-600 focus:outline-offset-2"
                                    wire:model.defer="shippingForm.postcode"
                                    id="postcode"
                                    type="text"
                                    name="postcode"
                                    style="box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 mb-0">
                        <div class="text-lg font-semibold leading-7">Delivery</div>

                        <div class="mt-3 mb-0">
                            <select
                            class="box-border w-full py-2 pl-3 pr-10 m-0 text-base normal-case whitespace-pre bg-no-repeat border border-gray-300 border-solid rounded-md appearance-none cursor-default focus:border-blue-600 focus:outline-offset-2"
                            wire:model="shippingTypeId"
                            style="background-size: 1.5em 1.5em; box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;"
                            >
                            <option value="1" class="whitespace-nowrap">
                                UPS Free (€0.00)
                            </option>
                            <option value="2" class="whitespace-nowrap">
                                UPS Standard (€20.00)
                            </option>
                            <option value="3" class="whitespace-nowrap">
                                UPS Premium (€30.00)
                            </option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 mb-0">
                    <div class="text-lg font-semibold leading-7">Payment</div>
                    <div wire:ignore="" id="card-element" class="mt-3 mb-0">
                        <div
                        class="box-border relative block p-0 m-0 bg-transparent opacity-100"
                        style="margin: 0px !important; padding: 0px !important; border: none !important; display: block !important; background: transparent !important; position: relative !important; opacity: 1 !important;"
                        >
                        <iframe
                        name="__privateStripeFrame5105"
                        frameborder="0"
                        allowtransparency="true"
                        scrolling="no"
                        allow="payment *"
                        src="https://js.stripe.com/v3/elements-inner-card-c7c0b112c7f4497b9e273530f98a2503.html#wait=false&amp;mids[guid]=NA&amp;mids[muid]=NA&amp;mids[sid]=NA&amp;rtl=false&amp;componentName=card&amp;keyMode=test&amp;apiKey=pk_test_51KcfCTCX0KaSQPxhaBf34R7dmswUgWbGn8vprBAAhBp8mRzoZJ73qI09Ez6btKA4e3NHKNnXJJllSYLfV0CTiF9h006KoTXSXj&amp;referrer=http%3A%2F%2Fonline-shoe-store.herokuapp.com%2Fcheckout&amp;controllerId=__privateStripeController5101"
                        title="Secure card payment input frame"
                        style="height: 16.8px; border: none !important; margin: 0px !important; padding: 0px !important; width: 1px !important; min-width: 100% !important; overflow: hidden !important; display: block !important; user-select: none !important; transform: translate(0px); color-scheme: normal;"
                        class="box-border block w-px h-4 min-w-full p-0 m-0 overflow-hidden align-middle select-none"
                        ></iframe
                        ><input
                        class="box-border absolute left-0 block w-full h-px p-0 m-0 text-base opacity-0 pointer-events-none -top-px cursor-text"
                        aria-hidden="true"
                        aria-label=" "
                        autocomplete="false"
                        maxlength="1"
                        style="border: none !important; display: block !important; position: absolute !important; height: 1px !important; top: -1px !important; left: 0px !important; padding: 0px !important; margin: 0px !important; width: 100% !important; opacity: 0 !important; background: transparent !important; pointer-events: none !important; font-size: 16px !important;"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div
        class="box-border self-start col-span-3 p-6 bg-white border-t-0 border-b border-gray-200 border-solid border-x-0"
        style="border-width: 0px;"
        >
        <div class="">
            <div
            class="box-border flex items-start py-3 border-t-0 border-b border-gray-200 border-solid border-x-0"
            style="border-width: 0px;"
            >
            <div class="w-16 mr-4">
                <img
                src="https://jonruedev.s3.ap-northeast-1.amazonaws.com/44/conversions/one-star-purple-thumb200x200.jpg"
                class="block w-16 h-auto max-w-full align-middle"
                />
            </div>

            <div class="">
                <div class="">
                    <div class="font-semibold">€250.00</div>
                    <div class="">
                        <div class="">Converse One Star</div>

                        <div
                        class="flex items-center mt-1 mb-0 text-sm leading-5"
                        >
                        <div class="mr-1 font-semibold">
                            Quantity: 1
                            <span class="mx-1 text-gray-400">/</span>
                        </div>
                        8
                        <span class="mx-1 text-gray-400">/</span>
                        Purple
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 mb-0">
    <div class="">
        <div class="flex items-center justify-between">
            <div class="font-semibold">Subtotal</div>
            <h1 class="mx-0 mt-1 mb-0 font-semibold">€250.00</h1>
        </div>

        <div class="flex items-center justify-between mt-1 mb-0">
            <div class="font-semibold">Shipping (UPS Free)</div>
            <h1 class="mx-0 mt-1 mb-0 font-semibold">€0.00</h1>
        </div>

        <div class="flex items-center justify-between mt-1 mb-0">
            <div class="font-semibold">Total</div>
            <h1 class="mx-0 mt-1 mb-0 font-semibold">€250.00</h1>
        </div>
    </div>

    <button
    type="submit"
    class="box-border inline-flex items-center px-4 py-2 mx-0 mt-4 mb-0 text-xs font-semibold leading-4 tracking-widest text-center text-white uppercase transition bg-gray-800 border border-transparent border-solid rounded-md cursor-pointer bg-none"
    x-text="submitButtonLabel"
    >
    Confirm Order and Pay
</button>
</div>
</div>
</div>
</form>

<!-- Livewire Component wire-end:2WZe4U9TkwIXrcA7PRIS -->
</div>
</div>
</main>
</div>


{{-- <div>
    <h1 class="mb-4 font-black text-center text-gray-700">STEPS</h1>
    <div class="flex">
        <div class="w-1/3 px-6 text-center">
            <div class="flex items-center justify-center bg-gray-300 border border-gray-200 rounded-lg">
                <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M23.995 24h-1.995c0-3.104.119-3.55-1.761-3.986-2.877-.664-5.594-1.291-6.584-3.458-.361-.791-.601-2.095.31-3.814 2.042-3.857 2.554-7.165 1.403-9.076-1.341-2.229-5.413-2.241-6.766.034-1.154 1.937-.635 5.227 1.424 9.025.93 1.712.697 3.02.338 3.815-.982 2.178-3.675 2.799-6.525 3.456-1.964.454-1.839.87-1.839 4.004h-1.995l-.005-1.241c0-2.52.199-3.975 3.178-4.663 3.365-.777 6.688-1.473 5.09-4.418-4.733-8.729-1.35-13.678 3.732-13.678 4.983 0 8.451 4.766 3.732 13.678-1.551 2.928 1.65 3.624 5.09 4.418 2.979.688 3.178 2.143 3.178 4.663l-.005 1.241zm-13.478-6l.91 2h1.164l.92-2h-2.994zm2.995 6l-.704-3h-1.615l-.704 3h3.023z"/></svg>
                </div>
                <div class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-200 rounded-r-lg body-step">
                    <h2 class="text-sm font-bold">Personal Info</h2>
                    <p class="text-xs text-gray-600">
                        Just your personal information
                    </p>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-center flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M14 2h-7.229l7.014 7h-13.785v6h13.785l-7.014 7h7.229l10-10z"/></svg>
        </div>
        <div class="w-1/3 px-6 text-center">
            <div class="flex items-center justify-center bg-gray-300 border border-gray-200 rounded-lg">
                <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M24 22h-24v-20h24v20zm-1-19h-22v18h22v-18zm-4 13v1h-4v-1h4zm-6.002 1h-10.997l-.001-.914c-.004-1.05-.007-2.136 1.711-2.533.789-.182 1.753-.404 1.892-.709.048-.108-.04-.301-.098-.407-1.103-2.036-1.305-3.838-.567-5.078.514-.863 1.448-1.359 2.562-1.359 1.105 0 2.033.488 2.545 1.339.737 1.224.542 3.033-.548 5.095-.057.106-.144.301-.095.41.14.305 1.118.531 1.83.696 1.779.41 1.773 1.503 1.767 2.56l-.001.9zm-9.998-1h8.999c.003-1.014-.055-1.27-.936-1.473-1.171-.27-2.226-.514-2.57-1.267-.174-.381-.134-.816.119-1.294.921-1.739 1.125-3.199.576-4.111-.332-.551-.931-.855-1.688-.855-.764 0-1.369.31-1.703.871-.542.91-.328 2.401.587 4.09.259.476.303.912.13 1.295-.342.757-1.387.997-2.493 1.252-.966.222-1.022.478-1.021 1.492zm18-3v1h-6v-1h6zm0-3v1h-6v-1h6zm0-3v1h-6v-1h6z"/></svg>
                </div>
                <div class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-200 rounded-r-lg body-step">
                    <h2 class="text-sm font-bold">Account Info</h2>
                    <p class="text-xs text-gray-600">
                        Anything you want for your credentials
                    </p>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-center flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M14 2h-7.229l7.014 7h-13.785v6h13.785l-7.014 7h7.229l10-10z"/></svg>
        </div>
        <div class="w-1/3 px-6 text-center">
            <div class="flex items-center justify-center bg-gray-300 border border-gray-200 rounded-lg">
                <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z"/></svg>
                </div>
                <div class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-200 rounded-r-lg body-step">
                    <h2 class="text-sm font-bold">Confirmation</h2>
                    <p class="text-xs text-gray-600">
                        Finish it!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div> --}}
</div>
