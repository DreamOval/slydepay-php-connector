<?php

namespace Slydepay\Order;

class OrderItem
{
    protected $ItemCode;
    protected $ItemName;
    protected $UnitPrice;
    protected $Quantity;
    protected $SubTotal;
    protected $Description;
    protected $ImageUrl

    public function __construct($itemCode, $itemName, $unitPrice, $quantity, $description = null, $imageUrl = null)
    {
        $this->ItemCode = $itemCode;
        $this->ItemName = $itemName;
        $this->UnitPrice = $unitPrice;
        $this->Quantity = $quantity;
        $this->SubTotal = $unitPrice * $quantity;
        $this->Description = $description;
        $this->ImageUrl = $imageUrl;
    }

    public function subTotal()
    {
        return $this->SubTotal;
    }

    public function toArray()
    {
        return [
            'ItemCode' => $this->ItemCode,
            'ItemName' => $this->ItemName,
            'UnitPrice' => $this->UnitPrice,
            'Quantity' => $this->Quantity,
            'SubTotal' => $this->subTotal(),
        ];
    }

    public function __get($name)
    {
        if ($name == 'SubTotal') {
            return $this->subTotal();
        }
        return $this->{$name};
    }
}
