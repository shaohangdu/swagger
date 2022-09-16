<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\City;
use App\Http\Controllers\CityController;

class CityControllerTest extends TestCase
{
    /**
     * A basic feature test store.
     *
     * @return void
     */
    protected static $cityIDs = [];

    public function test_store()
    {
        $str="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
        $name = substr(str_shuffle($str),26,10);

        // 打HTTP Post，去request CityController store method (儲存一筆資料)
        $response = $this->postJson(action([CityController::class, 'store']), [
            'name' => $name,
        ]);

        // 確認store method是return 200 redirect無誤
        $response->assertStatus(200);

        // 取最新insert的city id
        $cityID = $response->decodeResponseJson()['id'];

        // 確認city id都是數字無誤
        $this->assertStringMatchesFormat('%d', $cityID);

        // 確認insert的資料內容無誤
        $city = City::find($cityID);
        $this->assertSame($name, $city->name);
        
        // 將city id存到 self::$cityIDs 中，後續的test會需要
        self::$cityIDs[] = $cityID;
    }

    public function test_show()
    {
        // 從 self::$cityIDs 取回city id
        // 因為測試動作是有連貫性而非獨立的，所以city id才需要互相傳遞
        $cityID = self::$cityIDs[0];

        // 打HTTP Get，去request CityController show method (顯示一筆資料)
        $response = $this->get(action([CityController::class, 'show'], ['id' => $cityID]));
        
        // 確認HTTP status 200無誤
        $response->assertOk();
        
        // 確認view為"city"無誤
        // $response->assertViewIs('city');
        
        // 確認會傳遞$city給view，而其內容應該就是要等於剛剛 testStore() 中儲存的無誤
        $city = City::find($cityID);
    }
}
