<?php

use App\Services\Pix\PayloadCreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    $objQrCode = new QrCode($request->qrcode);
    $image = (new Output\Png)->output($objQrCode, 400);

    header('Content-Type: image/png');
    echo $image;
});

Route::get('/estatico/', function (Request $request) {
    $payloadCreator = (new PayloadCreator)->setPixKey('04467564071')
                                            ->setDescription('Pagamento de Teste')
                                            ->setMerchantName('Lucas Coelho Reichert')
                                            ->setMerchantCity('')
                                            ->setAmount(0.05)
                                            ->setTxid('textiddeteste');

    $payloadQrCode = $payloadCreator->getPayload();

    $objQrCode = new QrCode($payloadQrCode);
    $image = (new Output\Png)->output($objQrCode, 400);

    header('Content-Type: image/png');
    echo $image;
});


Route::get('/dinamico/', function (Request $request) {
    $payloadCreator = (new PayloadCreator)->setMerchantName('Lucas Coelho Reichert')
                                            ->setMerchantCity('')
                                            ->setAmount(0.05)
                                            ->setTxid('61d384cadcc90e9530c0f74951053ff0')
                                            ->setUrl('pix-qrcode-h.sicredi.com.br/qr/v2/4c0397ede06e4b00995764d8976d7adb');

    $payloadQrCode = $payloadCreator->getPayload();

    $objQrCode = new QrCode($payloadQrCode);
    $image = (new Output\Png)->output($objQrCode, 400);

    header('Content-Type: image/png');
    echo $image;
});