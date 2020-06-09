<style>
    /* @import url("https://fonts.googleapis.com/css2?family=Merriweather&family=Muli&display=swap"); */
:root {
   --ff-head: "Merriweather", serif;
   --ff-body: "Muli", sans-serif;
   --fs-body: 1.8rem;
   --fs-h2: 4rem;
   --fs-h4: 2.4rem;
   --fs-h5: 1.8rem;
   --clr-head: hsla(208, 11%, 15%, 1);
   --clr-body: hsla(208, 9%, 31%, 0.8);
   --clr-accent: hsla(216, 97%, 61%, 1);

   box-sizing: border-box;
}
*,
*::before,
*::after {
   margin: 0;
   padding: 0;
   box-sizing: inherit;
}
html,
body {
   width: 100%;
   min-height: 100vh;
   font-size: 52.5%;
}
body {
   font-family: var(--ff-body);
   font-size: var(--fs-body);
   color: var(--clr-body);
   line-height: 1.8;
   font-weight: normal;
}

img {
   max-width: 100%;
   height: auto;
}
.main {
   padding: 1em 0;
}
.container {
   max-width: 1200px;
   width: 90%;
   margin: 0 auto;
}

.inner__sub {
   --fs-h5: 1.5rem;
   font-size: var(--fs-h5);
   color: var(--clr-head);
   margin-bottom: 1em;
}

.inner__head {
   --fs-h2: 3rem;
   font-size: var(--fs-h2);
   font-family: var(--ff-head);
   color: var(--clr-head);
   line-height: 1.4;
   margin-bottom: 1em;
}

.inner__content {
   margin-bottom: 3em;
}

.inner__clr {
   color: hsla(216, 97%, 61%, 1);
}

.inner__text {
   text-align: left;
}

/*====== cards style ==========*/

.cards-grid {
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
   grid-gap: 4em 2rem;
}

.card {
   border-radius: 6px;
   box-shadow: 0 20px 40px 0 rgba(173, 181, 189, 0.1);
   border: solid 1px rgba(129, 147, 174, 0.12);
   background-color: #fff;
   padding: 2.5em;
   text-align: center;
   position: relative;
}

.card:first-child::before {
   content: "";
   position: absolute;
   background-color: #ffd25f;
   top: -8px;
   left: -1px;
   width: calc(100% + 2px);
   height: 8px;
   border-radius: 6px 6px 0 0;
}

.card:nth-child(2)::before {
   content: "";
   position: absolute;
   background-color: #63a2ff;
   top: -8px;
   left: -1px;
   width: calc(100% + 2px);
   height: 8px;
   border-radius: 6px 6px 0 0;
}

.card:last-child::before {
   content: "";
   position: absolute;
   background-color: #5ed291;
   top: -8px;
   left: -1px;
   width: calc(100% + 2px);
   height: 8px;
   border-radius: 6px 6px 0 0;
}

.card__body {
   padding-top: 1em;
}

.card__head {
   --fs-h4: 2rem;
   font-size: var(--fs-h4);
   margin-bottom: 1em;
   color: var(--clr-head);
}

.card__content {
   --fs-body: 1.6rem;
   font-size: var(--fs-body);
}

@media (min-width: 750px) {
   .inner {
      padding: 1em 0;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      width: 100%;
   }

   .inner__sub {
      --fs-h5: 1.8rem;
      font-size: var(--fs-h5);
   }
   .inner__headings {
      flex: 1 0 30%;
   }
   .inner__content {
      flex: 1 0 50%;
      align-self: center;
      margin-left: 2rem;
   }
   .inner__sub {
      margin-bottom: 0;
   }
   .inner__head {
      --fs-h2: 4rem;
   }
}

</style>

<div class="row">
    @foreach ($subscriptions as $item)
    <div class="col-md-4">
        <div class="card">
            <div class="view overlay">
                <img class="card-img-top" src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg" alt="Card image cap">
                <a href="{{route('subscription.show', [$item['id']])}}">
                    <div class="mask rgba-white-slight"></div>
                </a>
            </div>
            <div class="card-body">
                <h3 class="card-title">{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</h3> 
                <p class="card-text"><a href=" {{route('subscription.show', [$item['id']])}} ">{{$item->name}}</a></p>
                <h3><p>{{ ucwords(trans_choice('messages.tenant_name', 1)) }}</p></h3>
                <p class="card-text"> <a href="{{route('subscription.show', [$item['id']])}}"> {{$item->tenant_name}}  </a></p>
                <hr>
                <div class="row">
                    <div class="col-sm">
                        {{ ucwords(trans_choice('messages.licenses', 1)) }}
                        <p class="card-text"> <a href="{{route('subscription.show', [$item['id']])}}"> {{$item->amount}}  {{ ucwords(trans_choice('messages.licenses', 1)) }}</a></p>
                        
                    </div>
                    <div class="col-sm">
                        <p class="card-text"> {{ ucwords(trans_choice('messages.billing_cycle', 1)) }} <a href="{{route('subscription.show', [$item['id']])}}"> {{$item->billing_period}} </a> </p>
                    </div>
                </div>
                <hr>
                {{ ucwords(trans_choice('messages.subscription_status', 1)) }}
                <p class="card-text">
                    {{ ucwords(trans_choice( $item->status->name, 1)) }} 
                </p>
                {{-- <h2 class="card-title"> <strong>{{ ucwords(trans_choice('messages.name', 1)) }}:</strong> {{$instance['name']}}</h2>
                <p class="card-text"></p>
                <a href=" {{ route('instances.edit', $instance->id) }}" class="button is-info is-outlined"> {{ ucwords(trans_choice('messages.edit', 1)) }}</a> --}}
            </div>
        </div>
    </div>
    @endforeach
</div>
