<div class="row">
    <div class="card-columns">

        <div class="card">
            <img class="card-img-top" src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg"  height="170" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title"> {{ ucwords(trans_choice('messages.name', 1)) }}: {{ ucwords(trans_choice('messages.microsoft_instance', 1)) }}</h5>
            </div>
            <div class="p-3 text-right">
                <a href=" {{ route('instances.create', ['provider' => $provider->id]) }}" class="btn submit_btn">{{ ucwords(trans_choice('messages.add_new_instance', 1)) }}</a>
            </div>
        </div>
        <div class="card">
            <img class="card-img-top" src="https://media.kasperskydaily.com/wp-content/uploads/sites/88/2019/07/19124650/kaspersky-rebranding-in-details-featured.jpg" height="170" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title"> {{ ucwords(trans_choice('messages.name', 1)) }}: {{ ucwords(trans_choice('messages.kaspersky_instance', 1)) }}</h5>
            </div>
            <div class="p-3 text-right">
                <a href=" {{ route('instances.kascreate', ['provider' => $provider->id]) }}" class="btn submit_btn">{{ ucwords(trans_choice('messages.add_new_instance', 1)) }}</a>
            </div>
        </div>
    </div>
</div>
