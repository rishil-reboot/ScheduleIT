<!DOCTYPE html>
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="utf8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title>{{$emailTemplate->subject}}</title>
  <style>
    .hover-bg-brand-600:hover {
      background-color: #0047c3 !important;
    }
    .hover-text-brand-700:hover {
      color: #003ca5 !important;
    }
    .hover-underline:hover {
      text-decoration: underline !important;
    }
    @media screen {
      img {
        max-width: 100%;
      }
      .all-font-sans {
        font-family: -apple-system, "Segoe UI", sans-serif !important;
      }
    }
    @media (max-width: 640px) {
      u~div .wrapper {
        min-width: 100vw;
      }
      .sm-block {
        display: block !important;
      }
      .sm-h-16 {
        height: 16px !important;
      }
      .sm-mt-16 {
        margin-top: 16px !important;
      }
      .sm-py-16 {
        padding-top: 16px !important;
        padding-bottom: 16px !important;
      }
      .sm-px-16 {
        padding-left: 16px !important;
        padding-right: 16px !important;
      }
      .sm-py-24 {
        padding-top: 24px !important;
        padding-bottom: 24px !important;
      }
      .sm-text-14 {
        font-size: 14px !important;
      }
      .sm-w-full {
        width: 100% !important;
      }
    }
  </style>
</head>
<body lang="en" style="margin: 0; padding: 0; width: 100%; word-break: break-word; -webkit-font-smoothing: antialiased; background-color: #ffffff;">
<div style="display: none; line-height: 0; font-size: 0;">{{$emailTemplate->subject}} &zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;
  &#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;
  &#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;&zwnj;&#160;</div>
<table class="wrapper all-font-sans" style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
  <tr>
    <td align="center" style bgcolor="#ffffff">
      <table class="sm-w-full" style="width: 640px;" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
          <td class="sm-px-16 sm-py-24" style="padding-left: 40px; padding-right: 40px; padding-top: 48px; padding-bottom: 48px; text-align: left;" bgcolor="#ffffff" align="left">
            <div style="margin-bottom: 24px;">
              <a href="{{route('front.index')}}" style="color: #0047c3; text-decoration: none;">
                <img src="{{asset('assets/front/img/'.$bs->logo)}}" alt="{{env('APP_NAME')}}" width="143" style="line-height: 100%; vertical-align: middle; border: 0;">
              </a>
            </div>
              {!! $emailTemplate->body_content !!}

              {!! $bs->template_footer_content !!}
              <p style="line-height: 16px; margin: 0; color: #8492a6; font-size: 12px;">&copy; {{date('Y')}} {{env('APP_NAME')}}. All rights reserved.</p>
            </div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>