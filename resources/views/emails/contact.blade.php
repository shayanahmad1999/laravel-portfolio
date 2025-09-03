<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>New Contact Form Message</title>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeIn 600ms ease-out both;
        }

        .animate-delay-1 {
            animation-delay: 120ms;
        }

        .animate-delay-2 {
            animation-delay: 240ms;
        }

        .animate-delay-3 {
            animation-delay: 360ms;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }

            .px-32 {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }

            .py-24 {
                padding-top: 16px !important;
                padding-bottom: 16px !important;
            }

            .h1 {
                font-size: 22px !important;
            }

            .card {
                padding: 16px !important;
            }

            .btn {
                display: block !important;
                width: 100% !important;
            }
        }
    </style>
</head>

<body
    style="margin:0; padding:0; background:#f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color:#111827;">
    <div class="preheader"
        style="display:none!important; visibility:hidden; opacity:0; color:transparent; height:0; width:0; overflow:hidden;">
        You’ve received a new message from your portfolio contact form.</div>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="background:#f3f4f6; padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" class="container animate-in" width="640" cellpadding="0" cellspacing="0"
                    border="0"
                    style="width:640px; max-width:100%; background:#ffffff; border-radius:16px; box-shadow:0 6px 24px rgba(0,0,0,0.06); overflow:hidden;">
                    <tr>
                        <td align="center" style="background:#ffffff; border-bottom:1px solid #f0f2f5; padding:24px;">
                            <div class="h1"
                                style="font-size:24px; line-height:1.3; font-weight:700; color:#111827;">📬 New
                                Contact Form Message</div>
                            <div style="font-size:13px; color:#6b7280; margin-top:6px;">Submitted via your
                                portfolio</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-32 animate-in animate-delay-1" style="padding:24px 32px;">
                            <p style="margin:0 0 8px; font-size:16px; line-height:1.6; color:#111827;">Hi there,
                            </p>
                            <p style="margin:0; font-size:16px; line-height:1.6; color:#374151;">You just received
                                a new message. Details are below.</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-32 py-24" style="padding:8px 32px 24px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                class="card animate-in animate-delay-1"
                                style="background:#fafafa; border:1px solid #e5e7eb; border-radius:12px; padding:20px; margin-bottom:12px;">
                                <tr>
                                    <td>
                                        <div
                                            style="font-size:12px; font-weight:700; color:#6b7280; letter-spacing:0.02em; text-transform:uppercase; margin-bottom:6px;">
                                            Name</div>
                                        <div style="font-size:16px; color:#111827;">{{ $payload['name'] }}</div>
                                    </td>
                                </tr>
                            </table>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                class="card animate-in animate-delay-2"
                                style="background:#fafafa; border:1px solid #e5e7eb; border-radius:12px; padding:20px; margin-bottom:12px;">
                                <tr>
                                    <td>
                                        <div
                                            style="font-size:12px; font-weight:700; color:#6b7280; letter-spacing:0.02em; text-transform:uppercase; margin-bottom:6px;">
                                            Email</div>
                                        <div style="font-size:16px; color:#111827;"><a
                                                href="mailto:{{ $payload['email'] }}"
                                                style="color:#0ea5e9; text-decoration:none;">{{ $payload['email'] }}</a>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                class="card animate-in animate-delay-3"
                                style="background:#fafafa; border:1px solid #e5e7eb; border-radius:12px; padding:20px; margin-bottom:16px;">
                                <tr>
                                    <td>
                                        <div
                                            style="font-size:12px; font-weight:700; color:#6b7280; letter-spacing:0.02em; text-transform:uppercase; margin-bottom:6px;">
                                            Message</div>
                                        <div style="font-size:16px; color:#111827; line-height:1.7;">
                                            {!! nl2br(e($payload['message'])) !!}</div>
                                    </td>
                                </tr>
                            </table>
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="left"
                                style="margin: 8px 0 0;">
                                <tr>
                                    <td>
                                        <a class="btn" href="mailto:{{ $payload['email'] }}"
                                            style="display:inline-block; padding:12px 18px; font-size:15px; font-weight:600; text-decoration:none; background:#111827; color:#ffffff; border-radius:10px; border:1px solid #111827;">Reply
                                            to {{ $payload['name'] ?? 'Sender' }}</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 32px;">
                            <hr style="border:none; border-top:1px solid #f0f2f5; margin:0;">
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:18px 24px; background:#ffffff;">
                            <div style="font-size:12px; color:#6b7280;">This message was submitted via your
                                portfolio contact form. You can reply directly to respond.</div>
                            <div style="font-size:12px; color:#9ca3af; margin-top:6px;">© {{ date('Y') }} Your
                                Company. All rights reserved.</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
