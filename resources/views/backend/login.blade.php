<?php
$page = 'login';
?>
@extends('backend.main')
@section('content')
<div class="app-container app-login">
  <div class="flex-center">
    <div class="app-header"></div>
    <div class="app-body">
      <div class="loader-container text-center">
          <div class="icon">
            <div class="sk-folding-cube">
                <div class="sk-cube1 sk-cube"></div>
                <div class="sk-cube2 sk-cube"></div>
                <div class="sk-cube4 sk-cube"></div>
                <div class="sk-cube3 sk-cube"></div>
              </div>
            </div>
          <div class="title">登入中....</div>
      </div>
      <div class="app-block">
      <div class="app-form">
        <div class="form-header">
          <div class="app-brand"><span class="highlight">STMDIC </span> TAIWAN</div>
        </div>

        <form action="/do/login" method="POST">
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1">
                <i class="fa fa-user" aria-hidden="true"></i></span>
              <input type="text" name="adminid" class="form-control" placeholder="帳號" aria-describedby="basic-addon1">
            </div>
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon2">
                <i class="fa fa-key" aria-hidden="true"></i></span>
              <input type="password" name="password" class="form-control" placeholder="密碼" aria-describedby="basic-addon2">
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-success btn-submit" value="登入">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </div>
        </form>
        <!--
        <div class="form-line">
          <div class="title">OR</div>
        </div>
        <div class="form-footer">
          <button type="button" class="btn btn-default btn-sm btn-social __facebook">
            <div class="info">
              <i class="icon fa fa-facebook-official" aria-hidden="true"></i>
              <span class="title">Facebook</span>
            </div>
          </button>
        </div>
        -->
      </div>
      </div>
    </div>
    <div class="app-footer">
    </div>
  </div>
</div>
@endsection