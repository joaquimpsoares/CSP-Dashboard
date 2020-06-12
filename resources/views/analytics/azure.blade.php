@extends('layouts.app')

<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="//www.amcharts.com/lib/4/themes/animated.js"></script>
<script src="//www.amcharts.com/lib/4/themes/kelly.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">


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
        
        
        //   chart
        *{
            box-sizing: border-box;
        }
        
        .chart__container {
            border-radius: 8px;
            padding: 30px;
            background-color: #f1f8ff;
            // display: inline-block;
            box-shadow: 0px 5px 12px rgba(0,0,0,0.2);
        }
        
        .panel-body {
            padding: 15px;
            background-color: #f1f8ff;
        }
        
        
        #chartdiv {
            width: 800px;
            height: 300px;
        }
        
        #chartdiv1 {
            width: 1000px;
            height: 500px;
        }
        #chartdiv2 {
            width: 1000px;
            height: 500px;
        }
        
        // Modal
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        
        /* Modal Content */
        .modal-content {
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
            -webkit-animation-name: animatetop;
            -webkit-animation-duration: 0.4s;
            animation-name: animatetop;
            animation-duration: 0.4s
        }
        
        /* Add Animation */
        @-webkit-keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }
        
        @keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }
        
        /* The Close Button */
        .close {
            color: white;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        
        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        
        .modal-header {
            padding: 2px 16px;
            background-color: #5cb85c;
            color: white;
        }
        
        .modal-body {padding: 2px 16px;}
        
        .modal-footer {
            padding: 2px 16px;
            background-color: #5cb85c;
            color: white;
        }
        
        progress[value]::-webkit-progress-bar {
            background-color: #eee;
            border-radius: 2px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25) inset;
        }
    }
    
</style>

@section('content')


<div class="row">
    <div class="col-12">
        <div class="container">
            <div class="content">
                <h2>Azure Analytics for customer: </h2>
                <h4>Customer Name</h4>
                <label>Subscription name: Microsoft Azure</label>
                <p> Microsoft last updated at: {{$date->azure_updated_at ?? ' '}}</p>
                <div class="columns is-multiline">
                    <div class="column">
                        <div class="box col-sm-12">
                                <div class="row">
                                    {{-- {{$average='10'}} --}}
                                    <div class="col-sm-4">
                                        <div class="card">
                                            {{-- <div class="card-header">
                                                Header
                                            </div> --}}
                                            <div class="card-body">
                                                <h5 class="card-title">Status Current Budget</h5>
                                                <br>
                                                <p class="card-text">
                                                    @if($average<=29)
                                                    <font color="green" , size="16">${{$budget}}</font>
                                                    <br>
                                                    
                                                    <br>
                                                    <i color="green" class="fas fa-chart-line"></i>
                                                    <font color="green" , size="4">{{$average}}% Used</font>
                                                    <br>
                                                    
                                                    <progress class="warning" value={{$average}} max="100">{{$average}}%</progress>
                                                    <br>
                                                    @endif
                                                    
                                                    @if($average>=30 && $average<=70 )
                                                    <font color="#FFBF58" , size="6">${{$budget}}</font>
                                                    
                                                    <i color="#FFBF58" class="fas fa-chart-line"></i>
                                                    <font color="#FFBF58" , size="4">{{$average}}% Used</font>
                                                    
                                                    <progress class="warning" value={{$average}} max="100">{{$average}}%</progress>
                                                    @endif
                                                    
                                                    @if($average>=70 && $average<>100)
                                                    <br /> <br /><font color="red" , size="6">${{$budget}}</font>
                                                    <br />
                                                    <i color="red" class="fas fa-chart-line"></i>
                                                    <font color="red" , size="4">{{$average}}% Used</font>
                                                    {{-- <div class="percentage">
                                                        <div class="progress">
                                                            <div class="progress-bar color-5" role="progressbar" style="width: 80%" aria-valuenow="{{$average}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div> --}}
                                                    <br>
                                                    <progress class="warning" value={{$average}} max="100">{{$average}}%</progress>
                                                    
                                                    {{-- <progress class="progress is-danger" value={{$average}} max="100">{{$average}}%</progress> --}}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="card-footer">
                                                {{-- <button type="button is-primary is-outlined" value="Edit Budget" id="bt" onclick="toggle(this)"> </button> --}}
                                                <a href="#"  id="bt" onclick="toggle(this)">Adjust Budget</a>
                                                <!--The DIV element to toggle visibility. Its "display" property is set as "none". -->
                                                <div style="border:solid 1px #ddd; padding:10px; display:none;" id="cont">
                                                    <div>
                                                        <form action=" {{route('analytics.edit')}}" method="post">
                                                            @csrf
                                                            {{-- <p> <strong>New Budget: </strong></p> --}}
                                                            <div class="field">
                                                                <div class="control">
                                                                    <input id="value" name="budget" class="input" type="text" value="{{$budget}}">
                                                                </div>
                                                            </div>
                                                            {{-- <input id="value" type="number" name="budget" value="" /> --}}
                                                            <input type="submit" class="button is-primary" value="Send">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card">
                                            {{-- <div class="card-header">
                                                Current Estimated Usage
                                            </div> --}}
                                            <div class="card-body">
                                                <h5 class="card-title">Current Estimated Usage</h5>
                                                <p class="card-text">
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
                                                </p>
                                            </div>
                                            <div class="card-footer">
                                                <p>Updated at: {{$dateupdated->updated_at ?? ' '}} </p>
                                                <a href="{{ route('analytics.update') }}" class="button is-primary is-outlined">Refresh Manually </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="columns is-multiline">
                    <div class="column">
                        <div class="box">
                            <div class="heading">Current estimate by Category</div>
                            @if ($total > $budget)
                            <font color="red">Over Budget</font>
                            <div class="title text-danger">${{$total}}</div>
                            @else
                            <div class="title text-success">${{$total}}</div>
                            @endif
                            <div class="level">
                                <div class="level-item">
                                    <div class="">
                                        <div class="chart__container">
                                            {{-- <canvas id="chart_0" width="1000" height="400"></canvas> --}}
                                            <div id="chartdiv1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="box">
                            <div class="heading">Top 10 Categoryies</div>
                            <div class="level">
                                <div class="level-item">
                                    <div class="chart__container" >
                                        <div id="chartdiv"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <div class="heading">Resources name</div>
                            <div class="level">
                                <div class="level-item">
                                    <div class="chart__container" >
                                        <table id="resources" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="min-width-80 text-nowrap">Name</th>
                                                    <th>Category</th>
                                                    <th>Sub Category</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <body>
                                                @foreach ($resourceName as $item)
                                                <tr>
                                                    <td class="text-nowrap">{{$item->name}}</td>
                                                    <td class="text-nowrap">{{$item->category}}</td>
                                                    <td class="text-nowrap">{{$item->subcategory}}</td>
                                                    <td class="text-nowrap">${{$item->sum}}</td>
                                                </tr>
                                                @endforeach
                                            </body>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')

{{-- progressbar --}}
<script>
    $(function() {
        var current_progress = {{$average}};
        $("#dynamic")
        .css("width", current_progress + "%")
        .attr("aria-valuenow", current_progress)
        if(current_progress<=30)
        $("#dynamic")
        .attr("class","progress-bar progress-bar-danger")
        if(current_progress>=40 && current_progress<=70)
        $("#dynamic")
        .attr("class","progress-bar progress-bar-warning")
        if(current_progress<=100)
        $("#dynamic")
        .attr("class","progress-bar progress-bar-success")
    });
</script>

{{-- Close button  --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
            $notification = $delete.parentNode;
            
            $delete.addEventListener('click', () => {
                $notification.parentNode.removeChild($notification);
            });
        });
    });
</script>

<script>
    
    // Create chart instance
    var data_category = {!! $top10q !!}
    var chart = am4core.create("chartdiv", am4charts.PieChart);
    
    // Add data
    chart.data = data_category;
    
    // Add and configure Series
    var pieSeries = chart.series.push(new am4charts.PieSeries());
    pieSeries.dataFields.value = "sum";
    pieSeries.dataFields.category = "category";
</script>

<script>
    /**
    * ---------------------------------------
    * This demo was created using amCharts 4.
    *
    * For more information visit:
    * https://www.amcharts.com/
    *
    * Documentation is available at:
    * https://www.amcharts.com/docs/v4/
    * ---------------------------------------
    */
    
    
    // Apply chart themes
    am4core.ready(function() {
        
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end
        
        // Create chart instance
        var data_category = {!! $query !!}
        var chart = am4core.create("chartdiv1", am4charts.XYChart);
        chart.scrollbarX = new am4core.Scrollbar();
        
        // Add data
        chart.data = data_category
        
        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "category";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 30;
        categoryAxis.renderer.labels.template.horizontalCenter = "right";
        categoryAxis.renderer.labels.template.verticalCenter = "middle";
        categoryAxis.renderer.labels.template.rotation = 270;
        categoryAxis.tooltip.disabled = false;
        categoryAxis.renderer.minHeight = 110;
        
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.renderer.minWidth = 50;
        var label = categoryAxis.renderer.labels.template;
        label.truncate = true;
        label.maxWidth = 200;
        label.tooltipText = "{category}";
        
        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.sequencedInterpolation = true;
        series.dataFields.valueY = "sum";
        series.dataFields.categoryX = "category";
        series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
        series.columns.template.strokeWidth = 0;
        
        series.tooltip.pointerOrientation = "vertical";
        
        series.columns.template.column.cornerRadiusTopLeft = 10;
        series.columns.template.column.cornerRadiusTopRight = 10;
        series.columns.template.column.fillOpacity = 0.8;
        
        // on hover, make corner radiuses bigger
        var hoverState = series.columns.template.column.states.create("hover");
        hoverState.properties.cornerRadiusTopLeft = 0;
        hoverState.properties.cornerRadiusTopRight = 0;
        hoverState.properties.fillOpacity = 1;
        
        series.columns.template.adapter.add("fill", function(fill, target) {
            return chart.colors.getIndex(target.dataItem.index);
        });
        
        // Cursor
        chart.cursor = new am4charts.XYCursor();
        
    }); // end am4core.ready()
</script>

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


<script>
    
    $(document).ready(function() {
        $('#resources').DataTable( {
            dom: 'Bfrtip',
            buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
            ]
        } );
    } );
    
</script>






<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>


@stop
