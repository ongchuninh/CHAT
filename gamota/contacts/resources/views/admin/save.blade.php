@extends('Cms::layouts.default',[
    
    'active_admin_menu' 	=> ['contacts', isset($contact->id) ? 'contacts.index' : 'contacts.create'],
    'breadcrumbs'           => [
        'title' => ["Liên hệ", 'Chi tiết liên hệ'],
        'url'   => [
            route('admin.contact.index'),
        ],
    ],
])

@section('page_title', 'Chi tiết liên hệ')



@section('content')
    {!! Form::ajax(['url' => isset($contact->id) ? route('admin.game.update', ['id' => $contact->id])  : route('admin.game.store'), 'class' => 'form-horizontal form-bordered form-row-stripped', 'method' => isset($contact->id) ? 'PUT' : 'POST']) !!}
        <div class="form-body">
            <div class="form-group">
                <label class="control-label col-sm-2 pull-left">
                    Họ tên
                </label>
                <div class="col-sm-8">
                    <input value="{{ isset($contact->name)? $contact->name :'' }}" name="game[name]" type="text" placeholder="" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2 pull-left">
                    Email
                </label>
                <div class="col-sm-8">
                    <input value="{{ isset($contact->email)? $contact->email :'' }}" name="game[name]" type="text" placeholder="" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2 pull-left">
                    Chủ đề
                </label>
                <div class="col-sm-8">
                    <input value="{{ isset($contact->subject)? $contact->subject :'' }}" name="game[name]" type="text" placeholder="" class="form-control">
                </div>
            </div>

            

            <div class="form-group media-box-group">
                <label class="control-label col-sm-2 pull-left">
                    Nội dung
                </label>
                <div class="col-sm-8">
                    <textarea name="game[description]" class="form-control" cols="30" rows="10">{{ isset($contact->message)?$contact->message:'' }}</textarea>
                </div>
            </div>

            

           
            
        </div>
        
    {!! Form::close() !!}
@endsection

@push('js_footer')
   
    <script src="/assets/ckeditor/ckeditor.js"></script>
    <script src="/assets/ckfinder/ckfinder.js"></script>
    <script>
        $('document').ready(function(){
            $('body').on('click','.btn-add',function(){
                var t = $(this);
                CKFinder.popup( {
                    chooseFiles: true,
                    width: 800,
                    height: 600,
                    onInit: function( finder ) {
                        finder.on( 'files:choose', function( evt ) {
                            var file = evt.data.files.first();

                            t.parent().find('#thumbnail').eq(0).val(file.getUrl());

                            t.closest('.row').find('#avatar').eq(0).html("<img src='" + file.getUrl() + "' class='imgProduct img-thumbnail' width='200'/>");

                        } );
                    }
                } );

            });

            

            

            
        });
    </script>
    <script type="text/javascript">
        $('#create-slug').click(function() {
            if(this.checked) {
                var title = $('input[name="game[title]"]').val();
                var slug = strSlug(title);
                $('input[name="game[slug]"]').val(slug);
            }
        });

        $('input[name="game[title]"]').keyup(function() {
            if ($('#create-slug').is(':checked')) {
                var title = $(this).val();
                var slug = strSlug(title);
                $('input[name="game[slug]"]').val(slug);    
            }
        });
        
    </script>
@endpush
