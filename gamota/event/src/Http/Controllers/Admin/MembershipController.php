<?php

namespace Gamota\Event\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Validator;
use Gamota\Event\Membership;

class MembershipController extends AdminController
{
	public function index(){
		$filter = Membership::getRequestFilter();

		$this->data['filter'] = $filter;
        $this->data['member'] = Membership::applyFilter($filter)->paginate($this->paginate);

        \Metatag::set('title', trans('membership.list-member'));
        return view('Event::membership.admin.list', $this->data); //
	}
	public function list_role(){
		$filter = Membership::getRequestFilter();

		$this->data['filter'] = $filter;
        $this->data['member'] = Membership::applyFilterRole($filter)->paginate($this->paginate);

        \Metatag::set('title', trans('membership.list-role'));
        return view('Event::membership.admin.list_role', $this->data); //
	}
}