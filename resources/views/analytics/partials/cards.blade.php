<style>
    /* Font */
    
    /* Design */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }
    
    html {
        background-color: #ecf9ff;
    }
    
    .main{
        max-width: 1200px;
        margin: 0 auto;
    }
    
    h1 {
        font-size: 24px;
        font-weight: 400;
        text-align: center;
    }
    
    img {
        height: auto;
        max-width: 100%;
        vertical-align: middle;
    }
    
    .btn {
        color: #ffffff;
        padding: 0.8rem;
        font-size: 14px;
        text-transform: uppercase;
        border-radius: 4px;
        font-weight: 400;
        display: block;
        width: 100%;
        cursor: pointer;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: transparent;
    }
    
    .btn:hover {
        background-color: rgba(255, 255, 255, 0.12);
    }
    
    .cards {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    .cards_item {
        display: flex;
        padding: 1rem;
    }
    
    @media (min-width: 40rem) {
        .cards_item {
            width: 50%;
        }
    }
    
    @media (min-width: 56rem) {
        .cards_item {
            width: 33.3333%;
        }
    }
    
    .card {
        background-color: white;
        border-radius: 0.25rem;
        box-shadow: 0 20px 40px -14px rgba(0, 0, 0, 0.25);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    .card_content {
        padding: 1rem;
        background: linear-gradient(to bottom left, #EF8D9C 40%, #FFC39E 100%);
    }
    
    .card_title {
        color: #ffffff;
         
        font-size: 1.1rem;
        font-weight: 700;
        /*letter-spacing: 1px;
        text-transform: capitalize;
        margin: 0px; */
    }
    
    .card_text {
        color: #ffffff;
        /* font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1.25rem;    
        font-weight: 400; */
    }

</style>        



<div class="main">
    <h1>Responsive Card Grid Layout</h1>
    <ul class="cards">
        <li class="cards_item">
            <div class="card">
                <div class="card_image"><img src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg"></div>
                <div class="card_content">  
                    <h2 class="card_title">Status Current Budget</h2>
                    <p class="card_text"> @if($average<=29)
                        <font color="green" , size="16">${{$budget}}</font>
                        <i color="green" class="fas fa-chart-line"></i>
                        <font color="green" , size="4">{{$average}}% Used</font>
                        <progress class="warning" value={{$average}} max="100">{{$average}}%</progress>
                        @endif
                        
                        @if($average>=30 && $average<=70 )
                        <font color="#FFBF58" , size="6">${{$budget}}</font>
                        <i color="#FFBF58" class="fas fa-chart-line"></i>
                        <font color="#FFBF58" , size="4">{{$average}}% Used</font>
                        <progress class="warning" value={{$average}} max="100">{{$average}}%</progress>
                        @endif
                        
                        @if($average>=70 && $average<>100)
                        <font color="red" , size="6">${{$budget}}</font>
                        <i color="red" class="fas fa-chart-line"></i>
                        <font color="red" , size="4">{{$average}}% Used</font>
                        <progress class="warning" value={{$average}} max="100">{{$average}}%</progress>
                        @endif</p>
                    <a href="#"  ></a>
                    <button id="bt" onclick="toggle(this)" class="btn card_btn">Adjust Budget</button>
                    <!--The DIV element to toggle visibility. Its "display" property is set as "none". -->
                    <div style="border:solid 1px #ddd; padding:10px; display:none;" id="cont">
                        <div>
                            <form action=" {{route('analytics.edit')}}" method="post">
                                @csrf
                                <div class="field">
                                    <div class="control">
                                        <input id="value" name="budget" class="input" type="text" value="{{$budget}}">
                                    </div>
                                </div>
                                <input type="submit" class="button is-primary" value="Send">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="cards_item">
            <div class="card">
                <div class="card_image"><img src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg"></div>
                <div class="card_content">
                    <h2 class="card_title">Card Grid Layout</h2>
                    <p class="card_text">Demo of pixel perfect pure CSS simple responsive card grid layout</p>
                    <button class="btn card_btn">Read More</button>
                </div>
            </div>
        </li>
        
    </ul>
</div>

<h3 class="made_by">Made with ♡</h3>

<div class="card-columns">
    <div class="card">
        <img class="card-img-top" src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">Status Current Budget</h5>
        </div>
        <div class="p-3 text-right">
            @if($average<=29)
            <font color="green" , size="16">${{$budget}}</font>
            <i color="green" class="fas fa-chart-line"></i>
            <font color="green" , size="4">{{$average}}% Used</font>
            <progress class="warning" value={{$average}} max="100">{{$average}}%</progress>
            @endif
            
            @if($average>=30 && $average<=70 )
            <font color="#FFBF58" , size="6">${{$budget}}</font>
            <i color="#FFBF58" class="fas fa-chart-line"></i>
            <font color="#FFBF58" , size="4">{{$average}}% Used</font>
            <progress class="warning" value={{$average}} max="100">{{$average}}%</progress>
            @endif
            
            @if($average>=70 && $average<>100)
            <font color="red" , size="6">${{$budget}}</font>
            <i color="red" class="fas fa-chart-line"></i>
            <font color="red" , size="4">{{$average}}% Used</font>
            <progress class="warning" value={{$average}} max="100">{{$average}}%</progress>
            @endif
        </div>
        <div class="card-footer">
            <a href="#"  id="bt" onclick="toggle(this)">Adjust Budget</a>
            <!--The DIV element to toggle visibility. Its "display" property is set as "none". -->
            <div style="border:solid 1px #ddd; padding:10px; display:none;" id="cont">
                <div>
                    <form action=" {{route('analytics.edit')}}" method="post">
                        @csrf
                        <div class="field">
                            <div class="control">
                                <input id="value" name="budget" class="input" type="text" value="{{$budget}}">
                            </div>
                        </div>
                        <input type="submit" class="button is-primary" value="Send">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <img class="card-img-top" src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title"> {{ ucwords(trans_choice('messages.name', 1)) }}: {{ ucwords(trans_choice('messages.microsoft_instance', 1)) }}</h5>
        </div>
        <div class="p-3 text-right">
            <table class="table responsive">
                <tr>
                    <td>Usage</td>
                    <td>Budget</td>
                    @if($total > $budget)
                    <td>Over usage</td>
                    @endif
                    <td>Percent</td>
                </tr>
                <body>
                    <tr>
                        <td>${{$total}}</td>
                        <td>${{$budget}}</td>
                        @if($total > $budget)
                        <td>${{$total - $budget}}</td>
                        @endif
                        <td>{{$average}}%</td>
                    </tr>
                </body>
            </table>
        </div>
        <div class="card-footer">
            <p>Updated at: {{$dateupdated->updated_at ?? ' '}} </p>
            <a href="{{ route('analytics.update') }}" class="button is-primary is-outlined">Refresh Manually </a>
        </div>            
    </div>
</div>
</div>

<script>
    function toggle(ele) {
        var cont = document.getElementById('cont');
        if (cont.style.display == 'block') {
            cont.style.display = 'none';
            
            document.getElementById(ele.id).value = 'Show DIV';
        }
        else {
            cont.style.display = 'block';
            document.getElementById(ele.id).value = 'Hide DIV';
        }
    }
</script>