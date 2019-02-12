<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Ofcold\QrCode\BaconQrCodeGenerator;
use Ofcold\QrCode\HexToRgb;

class QrCodeController extends Controller
{
    /**
     * The request all parameters.
     *
     * @var array
     */
    protected static $parameters = [
        'content',
        'size',
        'logo',
        'format',
        'color',
        'bg_color',
        'data_type',
        'use_inc',
        'margin',
        'module',
    ];

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Created an QrCodeController instance.
     */
    public function __construct()
    {
        $this->request = request();
    }

    /**
     * Created QrCode.
     *
     * @param  BaconQrCodeGenerator $QRcode
     *
     * @return Naiveable\Route\FactoryResponse
     */
    public function make(BaconQrCodeGenerator $QRcode)
    {
        // Parameter analysis.
        $parameters = $this->parameters();

        $qrResponse = $QRcode
            ->encoding('UTF-8')
            ->module($parameters['module'] ?? null)
            ->margin($parameters['margin'] ?? 0)
            ->size($parameters['size'] ?? 320);

        // QR code output format, only supports png, eps, svg.
        if (isset($parameters['format'])) {
            $qrResponse->format($parameters['format']);
        }

        // Set the color and background color..
        $this->color($qrResponse, $parameters);
        $this->color($qrResponse, $parameters, true);

        // This is commonly used to placed logos within a QrCode.
        $this->setLogo($qrResponse, $parameters);

        // In response to the QR code, the output source is from the QR code type output type.
        return response(
                // QR code type. the type support btc, email, geo, phone number, sms, wifi.
                // $qrResponse->{$this->responseMethod($parameters)}(...Arr::wrap($parameters['content']))
                call_user_func_array(
                    [$qrResponse, $this->responseMethod($parameters)],
                    Arr::wrap($parameters['content'])
                )
            )
            ->header('Content-Type', $qrResponse->getContentType());
    }

    /**
     * @param  BaconQrCodeGenerator $qrCode
     * @param  array                $parameters
     * @param  bool|boolean   $isBg
     *
     * @return void
     */
    protected function color(BaconQrCodeGenerator $qrCode, array $parameters, bool $isBg = false): void
    {
        $field = 'color';
        $methd = 'color';

        if ($isBg) {
            $field = 'bg_color';
            $methd = 'backgroundColor';
        }

        if (isset($parameters[$field])) {
            $qrCode->{$methd}(HexToRgb::make($parameters[$field]));
        }
    }

    /**
     * The merge method merges an image over a QrCode.
     *
     * @param  BaconQrCodeGenerator $qrCode
     * @param  array                $parameters
     *
     * @return void
     */
    protected function setLogo(BaconQrCodeGenerator $qrCode, array $parameters)
    {
        $commonFunc = function($qrCode) {
            $qrCode->format('png')->errorCorrection(2);
        };

        if (isset($parameters['logo'])) {
            $commonFunc($qrCode);
            $qrCode->merge($parameters['logo'], .2, true);
        }
        // Use system default logo.
        else if (isset($parameters['use_inc'])) {
            $commonFunc();
            $qrCode->merge('public/favicon.png');
        }
    }

    /**
     * Get QR code response method.
     *
     * @param  array  $parameters
     *
     * @return string
     */
    public function responseMethod(array $parameters): string
    {
        if (! isset($parameters['data_type'])) {
            return 'generate';
        }

        return in_array($parameters['data_type'], ['btc', 'email', 'geo', 'phone_number', 'sms', 'wifi'], true)
            ? lcfirst(Str::studly($parameters['data_type']))
            : 'generate';
    }

    /**
     * Filter all parameters
     *
     * @return array
     */
    protected function parameters(): array
    {
        return array_filter($this->request->all(), function($field) {
            return in_array($field, static::$parameters);
        }, ARRAY_FILTER_USE_KEY);
    }
}
