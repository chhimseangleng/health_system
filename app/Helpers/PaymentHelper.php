<?php

namespace App\Helpers;

class PaymentHelper
{
    /**
     * Get available payment types
     */
    public static function getPaymentTypes()
    {
        return [
            'nssf' => 'NSSF Member',
            'cash' => 'Cash',
            'health equity fund' => 'Health Equity Fund',
        ];
    }

    /**
     * Get payment type colors for display
     */
    public static function getPaymentColors()
    {
        return [
            'nssf' => 'bg-blue-100 text-blue-800',
            'cash' => 'bg-green-100 text-green-800'
        ];
    }

    /**
     * Get payment type by key
     */
    public static function getPaymentTypeLabel($key)
    {
        $types = self::getPaymentTypes();
        return $types[$key] ?? 'Unknown';
    }

    /**
     * Get payment color by key
     */
    public static function getPaymentColor($key)
    {
        $colors = self::getPaymentColors();
        return $colors[$key] ?? 'bg-gray-100 text-gray-800';
    }
}
