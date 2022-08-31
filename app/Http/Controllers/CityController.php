<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityFromRequest;
use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    protected $city;
    public function __construct(
        City $city
    ){
        $this->city = $city;
    }
    
    /**
     * @OA\Get(
     *     path="/api/city",
     *     operationId="city",
     *     tags={"city Tag"},
     *     summary="取得 city",
     *     @OA\Response(
     *         response="200",
     *         description="請求成功"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="請求失敗"
     *     )
     * )
     */
    public function index()
    {
        $res = $this->city->all();
        return response()->json($res, 200);
    }

    public function create()
    {
        // 
    }

    /**
     * @OA\Post(
     *     path="/api/city",
     *     operationId="create city",
     *     tags={"city Tag"},
     *     summary="新增 city",
     *     @OA\Parameter(
     *         name="name",
     *         description="名稱",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="請求成功"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="格式內容錯誤"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="請求失敗"
     *     )
     * )
     */
    public function store(CityFromRequest $request)
    {
        if( $this->city->where('name', $request->name)->exists() == true ) {
            return response()->json($request->name . '名稱已存在', 404);
        }

        \DB::beginTransaction();
        try {
            // 執行事項(建立修改)
            $res = $this->city->create([
                'name' => $request->name,
            ]);
            // 將資料建立儲存
            \DB::commit();
            return response()->json($res, 200 );

        } catch (\Exception $e) {
            // 上方執行錯誤時 退回執行事項
            \DB::rollback();
            
            // 重新設定 ID 自動增量，避免跳號
            $maxId = City::max('id');
            if ($maxId == null) {
                $maxId = 1;
            }
            \DB::statement("ALTER TABLE city AUTO_INCREMENT=$maxId");

            return response()->json('編輯發生錯誤', 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/city/{id}",
     *     operationId="city id",
     *     tags={"city Tag"},
     *     summary="取得 city 編號",
     *     @OA\Parameter(
     *         name = "id", 
     *         description="Article id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="content",
     *         description="內容",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     security={
     *        {
     *             "Authorization": {}
     *        }
     *     },
     *     @OA\Response(
     *         response="200",
     *         description="請求成功"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="請求失敗"
     *     )
     * )
     */
    public function show($id)
    {
        $res = $this->city->find($id);
        return response()->json($res, 200);
    }

    public function edit($id)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/api/city/{id}",
     *     operationId="update city",
     *     tags={"city Tag"},
     *     summary="編輯 city",
     *     @OA\Parameter(
     *         name="id",
     *         description="編號",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         description="名稱",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="請求成功"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="格式內容錯誤"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="請求失敗"
     *     )
     * )
     */
    public function update(CityFromRequest $request, $id)
    {
        \DB::beginTransaction();
        try {
            // 執行事項(建立修改)
            $res = $this->city->where('id', $id)->update([
                'name' => $request->name,
            ]);
            // 將資料建立儲存
            \DB::commit();
            return response()->json($res, 200);

        } catch (\Exception $e) {
            // 上方執行錯誤時 退回執行事項
            \DB::rollback();
            
            // 重新設定 ID 自動增量，避免跳號
            $maxId = City::max('id');
            if ($maxId == null) {
                $maxId = 1;
            }
            \DB::statement("ALTER TABLE city AUTO_INCREMENT=$maxId");

            return response()->json('編輯發生錯誤', 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/city/{id}",
     *     operationId="delete city",
     *     tags={"city Tag"},
     *     summary="刪除 city",
     *     @OA\Parameter(
     *         name="id",
     *         description="編號",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="請求成功"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="請求失敗"
     *     )
     * )
     */
    public function destroy($id)
    {
        $res = $this->city->where('id', $id)->delete();
        return response()->json($res, 200);
    }
}
