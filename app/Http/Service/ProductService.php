<?php
namespace App\Http\Service;

use App\Models\Product;

class ProductService
{
    private $productModel;

  private static function getModel() : Product
  {
      return new Product();
  }

    private static function getProductById($id)
    {
        return self::getModel()::query()->findOrFail($id);
    }
    public static function getPrice($product_id, $withNumberFormat = false)
    {
        $model = self::getProductById($product_id);
        if (!$model) {
            return null;
        }
        $price = $model->price / 100;

        return $withNumberFormat ? number_format($price, 2) : $price;
    }

}
