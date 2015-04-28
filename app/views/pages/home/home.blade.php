@extends('layouts.master')

@section('content')

    <div class="container navbar-padding">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="home-header"><strong>Welcome to Nook!</strong></h1>
                <p class="home-subheader">Follow friends, family and the world around you on Nook. Why don't you sign up?</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="home-image"></div>
            </div>
            <div class="col-md-5">
                <h3 class="register-header"><strong>Get started - it's free.</strong></h3>
                @include('pages.home.partials.registration')
                <div class="oauth-login-btn-wrapper">
                    <table>
                        <tr>
                            <td colspan="1"></td>
                            <td colspan="1" class="oauth-login-or"><span>OR</span></td>
                            <td colspan="1"></td>
                        </tr>
                    </table>
                    <a href="/google/authorize" class="btn btn-oauth-google btn-strong form-control">
                        <i class="fa fa-google-plus"></i>
                        <span>Log In with Google</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

@stop