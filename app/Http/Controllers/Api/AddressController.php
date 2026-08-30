<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Get user addresses list.
     */
    public function getAddresses(Request $request)
    {
        $user = $request->user();
        $addresses = UserAddress::where('user_id', $user->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'addresses' => $addresses,
        ], 200);
    }

    /**
     * Save a new address or update existing.
     */
    public function saveAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['nullable', 'integer'],
            'title' => ['required', 'string', 'max:100'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:100'],
            'street' => ['required', 'string', 'max:255'],
            'details' => ['nullable', 'string'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات العنوان غير مكتملة',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();
        $isDefault = $request->boolean('is_default');

        if ($isDefault) {
            // Remove previous default
            UserAddress::where('user_id', $user->id)->update(['is_default' => false]);
        }

        $address = UserAddress::updateOrCreate(
            [
                'id' => $request->id,
                'user_id' => $user->id,
            ],
            [
                'title' => $request->title,
                'recipient_name' => $request->recipient_name,
                'phone' => $request->phone,
                'city' => $request->city,
                'street' => $request->street,
                'details' => $request->details,
                'is_default' => $isDefault,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'تم حفظ العنوان بنجاح',
            'address' => $address,
        ], 200);
    }

    /**
     * Delete an address.
     */
    public function deleteAddress(Request $request, $id)
    {
        $user = $request->user();
        $address = UserAddress::where('user_id', $user->id)->where('id', $id)->first();

        if (!$address) {
            return response()->json([
                'status' => 'error',
                'message' => 'العنوان غير موجود.',
            ], 404);
        }

        $address->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'تم حذف العنوان بنجاح',
        ], 200);
    }

    /**
     * Set an address as default.
     */
    public function setDefault(Request $request, $id)
    {
        $user = $request->user();
        $address = UserAddress::where('user_id', $user->id)->where('id', $id)->first();

        if (!$address) {
            return response()->json([
                'status' => 'error',
                'message' => 'العنوان غير موجود.',
            ], 404);
        }

        UserAddress::where('user_id', $user->id)->update(['is_default' => false]);
        $address->is_default = true;
        $address->save();

        return response()->json([
            'status' => 'success',
            'message' => 'تم تعيين العنوان كافتراضي',
            'address' => $address,
        ], 200);
    }
}
