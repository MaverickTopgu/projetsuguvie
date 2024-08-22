<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;

use Session;


class SectionController extends Controller
{
    public function sections()
    {
        Session::put('page','sections');
        $sections = Section::get()->toArray();
        //dd($sections);
        return view('admin.sections.sections')->with(compact('sections'));
    }

    public function updateSectionStatus(Request $request)
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
            Section::where('id',$data['section_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'section_id'=>$data['section_id']]);
        }
    }

    public function deleteSection($id)
    {
        //Delete Section
        Section::where('id',$id)->delete();
        $message = "La Section a été supprimée avec Succès !";
        return redirect()->back()->with('success_message',$message);
    }
    public function addEditSection(Request $request,$id=null)
    {
        Session::put('page','sections');
        if($id=="")
        {
            $title = "Ajouter une Section";
            $section = new Section;
            $message = "La Section a été ajouté avec succès!";

        }else
        {  
            $title = "Modifier une Section";
            $section = Section::find($id);
            $message = "La Section a été mise a jour avec succès!";

        }

        if($request->isMethod('post'))
        {
            $data = $request->all();
            //echo"<pre>";print_r($data);die;

            $rules=
            [
                'section_name'=>'required|regex:/^[\pL\s\-]+$/u',
            ];

            $customMessages = [
                // Add Custom Mesages here
                'section_name.required' => 'Le Nom de la Section est réquise!',
                'section_name.regex' => 'un nom de Section valide est réquis!',
                
                
            ];
            $this->validate($request,$rules,$customMessages);

            $section->name = $data['section_name'];
            $section->status = 1;
            $section->save();

            return redirect('admin/sections')->with('success_message',$message);



        }

        return view('admin.sections.add_edit_section')->with(compact('title','section'));


    }
}
