<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index()
    {
        dd('企业后台首页，当前用户名：'.auth('company')->user()->name);
    }
}
