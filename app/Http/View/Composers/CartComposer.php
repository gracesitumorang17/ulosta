<?php

namespace App\Http\View\Composers;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $cartCount = 0;
        
        if (Auth::check()) {
            $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        }
        
        $view->with('cartCount', $cartCount);
    }
}