<?php

namespace App\Http\Controllers;

use App\Http\Requests\product\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Traits\UploadImage;
use App\Repository\Eloquent\ProductRepository;
use App\Traits\ResponseTrait;


class ProductController extends Controller
{
    use UploadImage, ResponseTrait;

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->middleware('auth:api');

        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->all();

        return $this->sendResponse('Products Retrieved Successfully!',  ProductResource::collection($products), null, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $image = $this->upload($request->image, 'images/products');

        $product = $this->productRepository->create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image,
        ]);

        return $this->sendResponse('Product Created Successfully!', new ProductResource($product), null, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->productRepository->find($id);

        if (is_null($product)) {

            return $this->sendError('Product not found');
        }

        return $this->sendResponse('Product Retrieved Successfully!', new ProductResource($product), null, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {

        $image = $this->upload($request->image, 'images/products');

        $product = $this->productRepository->find($id);

        $$this->productRepository->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image,
        ]);

        return $this->sendResponse('Product Updated Successfully!', new ProductResource($product), null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->productRepository->find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found');
        }

        $this->productRepository->delete($id);

        return $this->sendResponse('Product Deleted Successfully!', new ProductResource($product), null, 200);
    }
}
