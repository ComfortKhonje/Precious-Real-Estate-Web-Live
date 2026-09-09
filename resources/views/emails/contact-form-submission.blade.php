<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message — Precious Real Estate</title>
    <style>
        body { margin: 0; padding: 0; background: #f4f4f2; font-family: Arial, Helvetica, sans-serif; color: #1E1E1E; }
        .email-wrapper { width: 100%; padding: 32px 12px; background: #f4f4f2; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(30,30,30,0.06); }

        .header { background: #1E1E1E; padding: 28px 32px; }
        .header-line { width: 44px; height: 4px; background: #FFE522; border-radius: 20px; margin-bottom: 16px; }
        .header h1 { margin: 0; color: #ffffff; font-size: 20px; font-weight: 700; letter-spacing: 0.02em; }
        .header p { color: #b3b3b3; margin: 4px 0 0; font-size: 13px; }

        .content { padding: 32px; }
        .badge { display: inline-block; background: #FFE522; color: #1E1E1E; padding: 5px 14px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 16px; }
        h2 { font-size: 22px; margin: 0 0 24px; color: #1E1E1E; font-weight: 700; }

        .section-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: #9a9a97; margin: 0 0 12px; }
        .section { margin-bottom: 24px; }

        table.grid { width: 100%; border-collapse: collapse; }
        table.grid td { width: 50%; padding: 0 0 16px; vertical-align: top; }
        .field-label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.06em; color: #9a9a97; margin: 0 0 3px; }
        .field-value { font-size: 14px; font-weight: 600; color: #1E1E1E; margin: 0; word-break: break-word; }

        .message-box { background: #fafafa; border: 1px solid #eeeeee; border-left: 3px solid #FFE522; border-radius: 12px; padding: 16px 18px; font-size: 14px; line-height: 1.6; color: #1E1E1E; white-space: pre-line; }

        .divider { border: 0; border-top: 1px solid #eee; margin: 24px 0; }

        .signature { color: #666; font-style: italic; font-size: 13px; margin-top: 8px; }

        .footer { background: #1E1E1E; padding: 22px; text-align: center; }
        .footer p { margin: 4px 0; color: #b3b3b3; font-size: 12px; }
        .footer .brand { color: #FFE522; font-weight: 700; font-size: 13px; }

        @media (max-width: 480px) {
            .content { padding: 24px 20px; }
            table.grid td { display: block; width: 100%; padding-bottom: 14px; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="container">

            <div class="header">
                <div class="header-line"></div>
                <h1>Precious Real Estate</h1>
                <p>New message received via the contact page</p>
            </div>

            <div class="content">
                <span class="badge">New Message</span>
                <h2>{{ $data['serviceNeeded'] ?? 'General' }}</h2>

                <div class="section">
                    <p class="section-label">Contact Details</p>
                    <table class="grid" role="presentation" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <p class="field-label">Name</p>
                                <p class="field-value">{{ $data['name'] ?? 'N/A' }}</p>
                            </td>
                            <td>
                                <p class="field-label">Phone</p>
                                <p class="field-value">{{ $data['phone'] ?? 'N/A' }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="field-label">Email</p>
                                <p class="field-value">{{ $data['email'] ?? 'N/A' }}</p>
                            </td>
                            <td>
                                <p class="field-label">Service Needed</p>
                                <p class="field-value">{{ $data['serviceNeeded'] ?? 'N/A' }}</p>
                            </td>
                        </tr>
                    </table>
                </div>

                @if (!empty($data['message']))
                    <hr class="divider">
                    <div class="section">
                        <p class="section-label">Message</p>
                        <div class="message-box">{{ $data['message'] }}</div>
                    </div>
                @endif

                @if ($signature)
                    <div class="signature">{!! $signature !!}</div>
                @endif
            </div>

            <div class="footer">
                <p class="brand">Precious Real Estate</p>
                <p>Premium property solutions in Malawi</p>
                <p>www.preciousrealestate.mw</p>
                <p>&copy; {{ date('Y') }} All rights reserved.</p>
            </div>

        </div>
    </div>
</body>
</html>
