<?php
$visitors = \App\Funcs::get_visitors(request('show_visitors'));
$counts = \App\Funcs::get_counts();
$report = \App\Funcs::get_report();
?> 
@extends('backend.main')
@section('content')
@include('backend._top')
<!-- <div class="row">
  <div class="col-xs-12">
		<div class="card card-banner card-chart card-green no-br">
			<div class="card-header">
			  <div class="card-title">
			    <div class="title">Visitors</div>
			  </div>
			  <ul class="card-action">
			    <li>
			      <a href="/">
			        <i class="fa fa-refresh"></i>
			      </a>
			    </li>
			  </ul>
			</div>
			<div class="card-body visitor_chart">
			  <div class="ct-chart-sale"></div>
			</div>
			<input type="hidden" id="visitor-labels" value='{!!$visitors['labels']!!}' />
			<input type="hidden" id="visitor-values" value='{!!$visitors['values']!!}' />
		</div>
  </div>
</div> -->
<canvas id="myChart" width="400" height="400" style="padding: 0px 30px 20px 30px;"></canvas>
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <a class="card card-banner card-green-light">
          <div class="card-body">
            <i class="icon fa fa-shopping-basket fa-4x"></i>
            <div class="content">
              <div class="title">Visits</div>
              <div class="value"><span class="sign"></span>{{$counts['visits']}}</div>
            </div>
          </div>
        </a>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <a class="card card-banner card-blue-light">
          <div class="card-body">
            <i class="icon fa fa-thumbs-o-up fa-4x"></i>
            <div class="content">
              <div class="title">Downloads</div>
              <div class="value"><span class="sign"></span>{{$counts['downloads']}}</div>
            </div>
          </div>
        </a>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <a class="card card-banner card-yellow-light">
          <div class="card-body">
            <i class="icon fa fa-user-plus fa-4x"></i>
            <div class="content">
              <div class="title">Contacts</div>
              <div class="value"><span class="sign"></span>{{$counts['contacts']}}</div>
            </div>
          </div>
        </a>
    </div>
</div>
@endsection
@section('javascripts')
<script type="text/javascript" src="/back/assets/js/dashboard.js"></script>
<script>
var ctx = document.getElementById("myChart").getContext('2d');
var data = '{{$report['values']}}' ; 
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["首頁", "聚落新知", "行銷專區", "討論區"],
        datasets: [{
            label: '數據分析',
            data: {{$report['values']}},
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    min: 0,
                    stepSize: 1000,
                    beginAtZero:true ,
                },
               
            }]
        }
    }
});
</script>
@endsection