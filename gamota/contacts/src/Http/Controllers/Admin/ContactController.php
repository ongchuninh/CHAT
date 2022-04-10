<?php

namespace Gamota\Contacts\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;

use Illuminate\Support\Facades\Validator;
use Gamota\Contacts\Contact;

class ContactController extends AdminController
{
    public function index()
    {

        $filter = Contact::getRequestFilter();

       
        $this->data['filter'] = $filter; //dd($filter);
        $this->data['contacts'] = Contact::applyFilter($filter)->paginate($this->paginate);

        \Metatag::set('title', 'Danh sách liên hệ');
        
        return view('Contacts::admin.list', $this->data);
    }

    public function detail(Contact $contact)
    {
        
        $this->data['contact'] = $contact;

       

        \Metatag::set('title', "Chi tiết liên hệ");
        return view('Contacts::admin.save', $this->data);
    }



}