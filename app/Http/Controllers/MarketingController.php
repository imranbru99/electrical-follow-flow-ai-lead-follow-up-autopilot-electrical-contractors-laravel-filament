<?php

namespace App\Http\Controllers;

use App\Services\ModuleService;
use Illuminate\View\View;

class MarketingController extends Controller
{
    public function home(ModuleService $modules): View
    {
        return view('public.home', [
            'modules' => $modules->all(),
        ]);
    }

    public function features(ModuleService $modules): View
    {
        return view('public.features', [
            'modules' => $modules->all(),
        ]);
    }

    public function workflow(): View
    {
        return view('public.workflow');
    }

    public function pricing(): View
    {
        return view('public.pricing');
    }

    public function demo(): View
    {
        return view('public.demo');
    }
}
