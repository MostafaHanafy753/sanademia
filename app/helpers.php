<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

function isRtl():bool
{
    if (LaravelLocalization::getCurrentLocaleScript() == 'Arab') {

        return true;
    } else {
        return false;
    }
}

function static_asset(string $asset): string
{
    return app()->environment('local')
        ? asset($asset)
        : asset('public/' . $asset);
}


if (!function_exists('displayAlert')) {
    function displayAlert()
    {

        if (session()->has('success')) {
            return '<script>
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "' . session()->get('success') . '",
                    showConfirmButton: false,

                });
            </script>';
        } elseif (session()->has('error')) {
            return '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "' . session()->get('error') . '",
                    showConfirmButton: false,

                });
            </script>';
        } elseif (session()->has('warning')) {
            return '<script>
                Swal.fire({
                    icon: "warning",
                    title: "Warning",
                    text: "' . session()->get('warning') . '",
                    showConfirmButton: false,

                });
            </script>';
        } elseif (session()->has('info')) {
            return '<script>
                Swal.fire({
                    icon: "info",
                    title: "Info",
                    text: "' . session()->get('info') . '",
                    showConfirmButton: false,

                });
            </script>';
        }

    }
}
