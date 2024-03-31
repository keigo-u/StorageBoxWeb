<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Page;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;

class ScrapeController extends Controller
{
    public function index() : View {
        $cards = Card::with(["type", "rarity", "civils", "races"])->paginate(10);
        $latest_page = Page::orderBy('created_at', "DESC")->first();

        return view("dashboard")->with(["cards" => $cards, "latest_page" => $latest_page]);
    }

    public function dm(Request $request): JsonResponse {
        $start = $request->input('start');
        $len = $request->input('length');
        try {
            Artisan::call('scrape:dm', ['len' => $len, 'page' => $start]);
            return response()->json(['message' => 'succeed']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function page_count(): JsonResponse {
        try {
            Artisan::call('scrape:page');
            return response()->json(['message' => 'succeed']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
