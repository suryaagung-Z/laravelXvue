<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RequestAPI extends Controller
{
    // Get all products
    public function products(): JsonResponse
    {
        $d = Products::all();

        return response()->json($d, 200);
    }

    // Get product by Id (true/false)
    public function prodById(string $id)
    {
        $res = Products::find($id);

        return $res ? $res : false;
    }

    // Get product by id with trashed
    public function prodByIdWithTrashed(string $id)
    {
        $res = Products::withTrashed()->find($id);

        return $res ? $res : false;
    }

    // Get product by id Only trashed
    public function prodByIdOnlyTrashed(string $id)
    {
        $res = Products::onlyTrashed()->find($id);

        return $res ? $res : false;
    }

    // Get product by Id (JSON)
    public function prodByIdOrFails(string $id): JsonResponse
    {
        // Crypt::encryptString($id)
        if ($check = Products::find($id)) {
            return response()->json($check, 200);
        } else {
            return response()->json(["notFound" => true], 404);
        }
    }

    // Get products with Category
    public function productsWithCategory(): JsonResponse
    {
        return response()->json(
            Products::with('category')->orderBy('created_at')->get(),
            200
        );
    }

    // Get all catagories
    public function categories(): JsonResponse
    {
        return response()->json(Categories::all(), 200);
    }

    public function productsInTrash(): JsonResponse
    {
        return response()->json(
            Products::with('category')->orderBy('created_at')->onlyTrashed()->get(),
            200
        );
    }


    // Store a new data
    public function store(Request $req): JsonResponse
    {

        $rules = [
            'product_name'     => ['required', 'min:3'],
            'price'            => ['required', 'integer'],
            'category_product' => ['required', 'uuid', 'exists:categories,id'],
            'production_date'  => ['required', 'date_format:Y-m-d'],
        ];

        $messages = [
            'required'    => 'Data tidak boleh kosong',
            'integer'     => 'Data harus bertipe angka',
            'min'         => 'Minimal :min karakter',
            'date_format' => 'Hanya mengizinkan format :format',
            'exists'      => '":attribute" anda tidak tersedia',
            'uuid'        => 'Hanya mengizinkan uuid'
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validate();

        $store = Products::create([
            "product_name"     => $validated['product_name'],
            "price"            => $validated['price'],
            "category_id"      => $validated['category_product'],
            "production_date"  => $validated['production_date'],
        ]);

        if ($store) {
            return response()->json(
                [
                    "message" => "Data berhasil disimpan",
                    "status"  => true
                ],
                200
            );
        } else {
            return response()->json(
                [
                    "message" => "Data gagal disimpan, terjadi kesalahan sistem",
                    "status"  => false
                ],
                422
            );
        }
    }

    public function update(Request $req): JsonResponse
    {
        $rules = [
            'product_name'     => ['required', Rule::unique('products')->ignore($req->id), 'min:3'],
            'price'            => ['required', 'integer'],
            'category_product' => ['required', 'uuid', 'exists:categories,id'],
            'production_date'  => ['required', 'date_format:Y-m-d'],
        ];

        $messages = [
            'required'            => 'Data tidak boleh kosong',
            'integer'             => 'Data harus bertipe angka',
            'min'                 => 'Minimal :min karakter',
            'date_format'         => 'Hanya mengizinkan format :format',
            'exists'              => '":attribute" anda tidak tersedia',
            'uuid'                => 'Hanya mengizinkan uuid',
            'product_name.unique' => 'Nama produk sudah digunakan'
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validate();

        $update = Products::where('id', $req->id)->update([
            "product_name"     => $validated['product_name'],
            "price"            => $validated['price'],
            "category_id"      => $validated['category_product'],
            "production_date"  => $validated['production_date'],
        ]);

        if ($update) {
            return response()->json(
                [
                    "message" => "Data berhasil diperbarui",
                    "status"  => true
                ],
                200
            );
        } else {
            return response()->json(
                [
                    "message" => "Data gagal diperbarui, terjadi kesalahan sistem",
                    "status"  => false
                ],
                422
            );
        }
    }

    public function undo(Request $req): JsonResponse
    {
        $undo = $this->prodByIdOnlyTrashed($req->id);
        if ($undo) {
            if ($undo->restore()) {
                return response()->json(
                    [
                        "message" => "Data berhasil dikembalikan",
                        "status"  => true
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        "message" => "Data gagal dihapus permanen",
                        "status"  => false
                    ],
                    422
                );
            }
        } else {
            return response()->json(
                [
                    "message" => "Data gagal tidak ditemukan",
                    "status"  => false
                ],
                422
            );
        }
    }

    public function delete(string $id, string $soft)
    {
        $get = $this->prodByIdWithTrashed($id);
        if ($get) {
            if ($soft == '1') {
                if ($get->delete()) {
                    return response()->json(
                        [
                            "message" => "Data berhasil dihapus sementara",
                            "status"  => true
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            "message" => "Data gagal dihapus sementara",
                            "status"  => false
                        ],
                        422
                    );
                }
            } else if ($soft == '0') {
                if ($get->forceDelete()) {
                    return response()->json(
                        [
                            "message" => "Data berhasil dihapus permanen",
                            "status"  => true
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            "message" => "Data gagal dihapus permanen",
                            "status"  => false
                        ],
                        422
                    );
                }
            }
        } else {
            return response()->json(
                [
                    "message" => "Data tidak ditemukan",
                    "status"  => false
                ],
                422
            );
        }
    }
}
