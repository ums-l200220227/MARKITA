<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function store(Request $request)
    {
        $cartItem = CartItem::create($request->all());
        return response()->json($cartItem, 201);
    }

    public function update(Request $request, $id)
    {
        $cartItem = CartItem::find($id);
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }
        $cartItem->update($request->all());
        return response()->json($cartItem);
    }

    public function destroy($id)
    {
        $cartItem = CartItem::find($id);
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }
        $cartItem->delete();
        return response()->json(['message' => 'Cart item deleted successfully']);
    }
}
