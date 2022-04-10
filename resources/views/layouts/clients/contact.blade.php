<div class="contact">
    <div class="title">{{ isset((Helper::getSettingJson('custom_language')->text->contact->{$lan->code}))
        ?Helper::getSettingJson('custom_language')->text->contact->{$lan->code}
        :Helper::getSettingJson('custom_language')->text->contact->vi }}</div>
    <div class="wrap-contact-mail">
        @if(!empty($contact = Helper::getSettingJson('custom_general')->admin_email))
        @foreach($contact as $key => $value)
        <div class="contact-mail">
            <div class="title-contact">{{ isset((Helper::getSettingJson('custom_general')->admin_email_title[$key]))
                ?Helper::getSettingJson('custom_general')->admin_email_title[$key] : '' }}</div>
            <div class="mail">{{ $value }}</div>
            <div class="sendmail">
                <a href="mailto:{{ $value }}">{{ isset((Helper::getSettingJson('custom_language')->btn->contact->{$lan->code}))
                ?Helper::getSettingJson('custom_language')->btn->contact->{$lan->code}
                :Helper::getSettingJson('custom_language')->btn->contact->vi }}</a>
            </div>
        </div>
        @endforeach
        @endif
       
    </div>
</div>