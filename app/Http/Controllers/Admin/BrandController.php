<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

use Session;

class BrandController extends Controller
{
    public function brands()
    {
        Session::put('page','brands');
        $brands = Brand::get()->toArray();
        //dd($brands);
        return view('admin.brands.brands')->with(compact('brands'));
    }

    public function updateBrandStatus(Request $request)
    {
        if($request->ajax())
        {
            $data=$request->all();
            //echo"<pre>";print_r($data);die;
            if($data['status']=="Active")
            {
                $status=0;
            }else
            {
                $status=1;
            }
            Brand::where('id',$data['brand_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'brand_id'=>$data['brand_id']]);
        }
    }

    public function deleteBrand($id)
    {
        //Delete brand
        Brand::where('id',$id)->delete();
        $message = "La Marque a été supprimée avec Succès !";
        return redirect()->back()->with('success_message',$message);
    }
    public function addEditBrand(Request $request,$id=null)
    {
        Session::put('page','brands');
        if($id=="")
        {
            $title = "Ajouter une Marque";
            $brand = new brand;
            $message = "La Marque a été ajouté avec succès!";

        }else
        {  
            $title = "Modifier une Marque";
            $brand = Brand::find($id);
            $message = "La Marque a été mise a jour avec succès!";

        }

        if($request->isMethod('post'))
        {
            $data = $request->all();
            //echo"<pre>";print_r($data);die;

            $rules=
            [
                'brand_name'=>'required|regex:/^[\pL\s\-]+$/u',
            ];

            $customMessages = [
                // Add Custom Mesages here
                'brand_name.required' => 'Le Nom de la Marque est réquise!',
                'brand_name.regex' => 'un nom de Marque valide est réquis!',
                
                
            ];
            $this->validate($request,$rules,$customMessages);

            $brand->name = $data['brand_name'];
            $brand->status = 1;
            $brand->save();

            return redirect('admin/brands')->with('success_message',$message);



        }

        return view('admin.brands.add_edit_brand')->with(compact('title','brand'));


    }
}
